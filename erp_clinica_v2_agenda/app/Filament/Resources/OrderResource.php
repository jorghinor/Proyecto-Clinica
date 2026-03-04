<?php

namespace App\Filament\Resources;

use App\Filament\Resources\OrderResource\Pages;
use App\Models\Order;
use App\Models\Lote;
use App\Models\Factura;
use App\Models\FacturaItem;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Notifications\Notification;
use Illuminate\Database\Eloquent\Model;

class OrderResource extends Resource
{
    protected static ?string $model = Order::class;

    protected static ?string $navigationIcon = 'heroicon-o-shopping-bag';
    protected static ?string $navigationLabel = 'Pedidos Web';
    protected static ?string $navigationGroup = 'Inventario';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Información del Pedido')
                    ->schema([
                        Forms\Components\TextInput::make('id')
                            ->label('Nº Pedido')
                            ->disabled(),
                        Forms\Components\Select::make('estado')
                            ->options([
                                'pendiente' => 'Pendiente',
                                'pagado' => 'Pagado',
                                'entregado' => 'Entregado',
                                'cancelado' => 'Cancelado',
                            ])
                            ->required(),
                        Forms\Components\TextInput::make('total')
                            ->prefix('$')
                            ->disabled(),
                        Forms\Components\DateTimePicker::make('created_at')
                            ->label('Fecha de Creación')
                            ->disabled(),
                    ])->columns(2),

                Forms\Components\Section::make('Cliente')
                    ->schema([
                        Forms\Components\Select::make('paciente_id')
                            ->relationship('paciente', 'nombre')
                            ->disabled(),
                        Forms\Components\TextInput::make('nombre_cliente')
                            ->label('Nombre (Invitado)')
                            ->visible(fn ($record) => !$record->paciente_id)
                            ->disabled(),
                        Forms\Components\TextInput::make('email_cliente')
                            ->label('Email (Invitado)')
                            ->visible(fn ($record) => !$record->paciente_id)
                            ->disabled(),
                    ])->columns(2),

                Forms\Components\Section::make('Productos')
                    ->schema([
                        Forms\Components\Repeater::make('items')
                            ->relationship()
                            ->schema([
                                Forms\Components\Select::make('producto_id')
                                    ->relationship('producto', 'nombre')
                                    ->disabled(),
                                Forms\Components\TextInput::make('cantidad')
                                    ->disabled(),
                                Forms\Components\TextInput::make('precio_unitario')
                                    ->prefix('$')
                                    ->disabled(),
                                Forms\Components\TextInput::make('subtotal')
                                    ->prefix('$')
                                    ->disabled(),
                            ])
                            ->disableItemCreation()
                            ->disableItemDeletion()
                            ->columns(4),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')->sortable(),
                Tables\Columns\TextColumn::make('paciente.nombre')
                    ->label('Cliente')
                    ->formatStateUsing(fn ($record) => $record->paciente ? $record->paciente->nombre . ' ' . $record->paciente->apellido : $record->nombre_cliente)
                    ->searchable(),
                Tables\Columns\TextColumn::make('total')->money('USD')->sortable(),
                Tables\Columns\TextColumn::make('estado')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'pendiente' => 'warning',
                        'pagado' => 'info',
                        'entregado' => 'success',
                        'cancelado' => 'danger',
                    }),
                Tables\Columns\TextColumn::make('created_at')->dateTime()->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('estado')
                    ->options([
                        'pendiente' => 'Pendiente',
                        'pagado' => 'Pagado',
                        'entregado' => 'Entregado',
                        'cancelado' => 'Cancelado',
                    ]),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\Action::make('entregar')
                    ->label('Entregar y Facturar')
                    ->icon('heroicon-o-check-circle')
                    ->color('success')
                    ->requiresConfirmation()
                    ->visible(fn (Order $record) => $record->estado === 'pendiente' || $record->estado === 'pagado')
                    ->action(function (Order $record) {
                        // 1. Verificar Stock
                        foreach ($record->items as $item) {
                            if ($item->producto->stock_total < $item->cantidad) {
                                Notification::make()
                                    ->title('Error de Stock')
                                    ->body("No hay suficiente stock para el producto: {$item->producto->nombre}")
                                    ->danger()
                                    ->send();
                                return;
                            }
                        }

                        // 2. Descontar Stock (FIFO)
                        foreach ($record->items as $item) {
                            $cantidadRestante = $item->cantidad;
                            // Buscar lotes con stock, ordenados por fecha de vencimiento (los más viejos primero)
                            $lotes = Lote::where('producto_id', $item->producto_id)
                                ->where('cantidad_actual', '>', 0)
                                ->orderBy('fecha_vencimiento', 'asc')
                                ->get();

                            foreach ($lotes as $lote) {
                                if ($cantidadRestante <= 0) break;

                                if ($lote->cantidad_actual >= $cantidadRestante) {
                                    $lote->cantidad_actual -= $cantidadRestante;
                                    $lote->save();
                                    $cantidadRestante = 0;
                                } else {
                                    $cantidadRestante -= $lote->cantidad_actual;
                                    $lote->cantidad_actual = 0;
                                    $lote->save();
                                }
                            }
                        }

                        // 3. Generar Factura
                        if ($record->paciente_id) {
                            $factura = Factura::create([
                                'paciente_id' => $record->paciente_id,
                                'medico_id' => null, // Venta directa, sin médico asociado obligatoriamente
                                'cita_id' => null,
                                'numero_factura' => 'FAC-' . time(), // Generación simple
                                'fecha_emision' => now(),
                                'total' => $record->total,
                                'estado' => 'pagada',
                            ]);

                            foreach ($record->items as $item) {
                                FacturaItem::create([
                                    'factura_id' => $factura->id,
                                    'descripcion' => $item->producto->nombre,
                                    'cantidad' => $item->cantidad,
                                    'precio_unitario' => $item->precio_unitario,
                                    'subtotal' => $item->subtotal,
                                ]);
                            }
                        }

                        // 4. Actualizar Estado del Pedido
                        $record->update(['estado' => 'entregado']);

                        Notification::make()
                            ->title('Pedido Entregado')
                            ->body('El stock ha sido descontado y la factura generada.')
                            ->success()
                            ->send();
                    }),
                Tables\Actions\Action::make('descargarFactura')
                    ->label('Factura')
                    ->icon('heroicon-o-document-arrow-down')
                    ->color('info')
                    ->visible(fn (Order $record) => $record->estado === 'entregado' && $record->paciente_id)
                    ->url(function (Order $record) {
                        // Buscar la factura asociada (aproximación por paciente y monto)
                        $factura = Factura::where('paciente_id', $record->paciente_id)
                            ->where('total', $record->total)
                            ->latest()
                            ->first();

                        return $factura ? route('facturas.pdf', $factura) : null;
                    })
                    ->openUrlInNewTab(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListOrders::route('/'),
            'create' => Pages\CreateOrder::route('/create'),
            'edit' => Pages\EditOrder::route('/{record}/edit'),
        ];
    }

    public static function canCreate(): bool
    {
        return false; // No permitir crear pedidos manualmente desde el admin
    }
}
