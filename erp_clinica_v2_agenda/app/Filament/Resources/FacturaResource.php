<?php

namespace App\Filament\Resources;

use App\Filament\Resources\FacturaResource\Pages;
use App\Models\Factura;
use Filament\Forms;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class FacturaResource extends Resource
{
    protected static ?string $model = Factura::class;

    protected static ?string $navigationIcon = 'heroicon-o-currency-dollar';

    protected static ?string $navigationLabel = 'Facturación';

    // Configuración del Buscador Global
    protected static ?string $recordTitleAttribute = 'numero_factura';

    public static function getGloballySearchableAttributes(): array
    {
        return ['numero_factura', 'paciente.nombre', 'paciente.apellido'];
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Información de la Factura')
                    ->schema([
                        Select::make('paciente_id')
                            ->relationship('paciente', 'nombre')
                            ->getOptionLabelFromRecordUsing(fn ($record) => "{$record->nombre} {$record->apellido}")
                            ->searchable()
                            ->preload()
                            ->required(),
                        Select::make('cita_id')
                            ->relationship('cita', 'id')
                            ->label('Cita Relacionada (Opcional)'),
                        TextInput::make('numero_factura')
                            ->label('Número de Folio')
                            ->default('FAC-' . strtoupper(uniqid()))
                            ->required()
                            ->maxLength(255),
                        Forms\Components\DatePicker::make('fecha_emision')
                            ->default(now())
                            ->required(),
                        Select::make('estado')
                            ->options([
                                'pendiente' => 'Pendiente',
                                'pagada' => 'Pagada',
                                'anulada' => 'Anulada',
                            ])
                            ->default('pendiente')
                            ->required(),
                        Select::make('metodo_pago')
                            ->options([
                                'efectivo' => 'Efectivo',
                                'tarjeta_credito' => 'Tarjeta de Crédito',
                                'tarjeta_debito' => 'Tarjeta de Débito',
                                'transferencia' => 'Transferencia',
                                'seguro' => 'Seguro Médico',
                            ]),
                    ])->columns(3),

                Section::make('Detalle de Servicios / Productos')
                    ->schema([
                        Repeater::make('items')
                            ->relationship()
                            ->schema([
                                TextInput::make('descripcion')
                                    ->required()
                                    ->columnSpan(2),
                                TextInput::make('cantidad')
                                    ->numeric()
                                    ->default(1)
                                    ->required()
                                    ->live(onBlur: true)
                                    ->afterStateUpdated(function (Get $get, Set $set) {
                                        self::updateLineTotal($get, $set);
                                    }),
                                TextInput::make('precio_unitario')
                                    ->numeric()
                                    ->prefix('$')
                                    ->required()
                                    ->live(onBlur: true)
                                    ->afterStateUpdated(function (Get $get, Set $set) {
                                        self::updateLineTotal($get, $set);
                                    }),
                                TextInput::make('subtotal')
                                    ->numeric()
                                    ->prefix('$')
                                    ->readOnly(),
                            ])
                            ->columns(5)
                            ->live()
                            ->afterStateUpdated(function (Get $get, Set $set) {
                                self::updateInvoiceTotal($get, $set);
                            }),
                    ]),

                Section::make('Totales')
                    ->schema([
                        TextInput::make('subtotal')
                            ->numeric()
                            ->prefix('$')
                            ->readOnly(),
                        TextInput::make('impuestos')
                            ->label('Impuestos (IVA)')
                            ->numeric()
                            ->prefix('$')
                            ->default(0)
                            ->live(onBlur: true)
                            ->afterStateUpdated(function (Get $get, Set $set) {
                                self::updateInvoiceTotal($get, $set);
                            }),
                        TextInput::make('total')
                            ->numeric()
                            ->prefix('$')
                            ->readOnly()
                            ->extraInputAttributes(['style' => 'font-weight: bold; font-size: 1.2rem;']),
                    ])->columns(3),
            ]);
    }

    // Función auxiliar para calcular el total de una línea
    public static function updateLineTotal(Get $get, Set $set): void
    {
        $cantidad = (float) $get('cantidad');
        $precio = (float) $get('precio_unitario');
        $set('subtotal', number_format($cantidad * $precio, 2, '.', ''));
    }

    // Función auxiliar para calcular el total de la factura
    public static function updateInvoiceTotal(Get $get, Set $set): void
    {
        $items = $get('items');
        $subtotal = 0;

        if ($items) {
            foreach ($items as $item) {
                $subtotal += (float) ($item['subtotal'] ?? 0);
            }
        }

        $impuestos = (float) $get('impuestos');
        $total = $subtotal + $impuestos;

        $set('subtotal', number_format($subtotal, 2, '.', ''));
        $set('total', number_format($total, 2, '.', ''));
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('numero_factura')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('paciente.nombre')
                    ->label('Paciente')
                    ->formatStateUsing(fn ($record) => "{$record->paciente->nombre} {$record->paciente->apellido}")
                    ->searchable(),
                Tables\Columns\TextColumn::make('fecha_emision')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('total')
                    ->money('USD') // O tu moneda local
                    ->sortable(),
                Tables\Columns\TextColumn::make('estado')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'pendiente' => 'warning',
                        'pagada' => 'success',
                        'anulada' => 'danger',
                    }),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('estado')
                    ->options([
                        'pendiente' => 'Pendiente',
                        'pagada' => 'Pagada',
                        'anulada' => 'Anulada',
                    ]),
            ])
            ->actions([
                Tables\Actions\Action::make('pdf')
                    ->label('PDF')
                    ->icon('heroicon-o-arrow-down-tray')
                    ->url(fn (Factura $record) => route('facturas.pdf', $record))
                    ->openUrlInNewTab(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
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
            'index' => Pages\ListFacturas::route('/'),
            'create' => Pages\CreateFactura::route('/create'),
            'edit' => Pages\EditFactura::route('/{record}/edit'),
        ];
    }
}
