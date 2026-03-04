<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AuditResource\Pages;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use OwenIt\Auditing\Models\Audit as AuditModel;

class AuditResource extends Resource
{
    protected static ?string $model = AuditModel::class;

    protected static ?string $navigationIcon = 'heroicon-o-clipboard-document-list';
    protected static ?string $navigationLabel = 'Auditoría';
    protected static ?string $navigationGroup = 'Administración';
    protected static ?int $navigationSort = 99;

    // Definimos un recordTitleAttribute que existe en la tabla 'audits'
    protected static ?string $recordTitleAttribute = 'event';

    public static function form(Form $form): Form
    {
        // Por ahora, el formulario estará vacío. Lo llenaremos después de que la tabla funcione.
        return $form
            ->schema([
                Forms\Components\Section::make('Detalles del Evento')
                    ->schema([
                        Forms\Components\TextInput::make('id')->readOnly(),
                        Forms\Components\TextInput::make('event')->readOnly(),
                        Forms\Components\TextInput::make('auditable_type')->readOnly(),
                        Forms\Components\TextInput::make('auditable_id')->readOnly(),
                        Forms\Components\TextInput::make('user_id')->readOnly(),
                        Forms\Components\KeyValue::make('old_values')->columnSpanFull(),
                        Forms\Components\KeyValue::make('new_values')->columnSpanFull(),
                        Forms\Components\TextInput::make('url')->readOnly()->columnSpanFull(),
                        Forms\Components\TextInput::make('ip_address')->readOnly(),
                        Forms\Components\TextInput::make('user_agent')->readOnly()->columnSpanFull(),
                        Forms\Components\DateTimePicker::make('created_at')->readOnly(),
                    ])->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->defaultSort('created_at', 'desc') // Ordenamiento por defecto válido
            ->columns([
                Tables\Columns\TextColumn::make('id')
                    ->label('ID')
                    ->sortable(),
                Tables\Columns\TextColumn::make('event')
                    ->label('Evento')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'created' => 'success',
                        'updated' => 'info',
                        'deleted' => 'danger',
                        default => 'gray',
                    })
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Fecha/Hora')
                    ->dateTime()
                    ->sortable(),
            ])
            ->filters([
                // Filtros se añadirán después
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
            ])
            ->bulkActions([
                // Acciones masivas se añadirán después
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
            'index' => Pages\ListAudits::route('/'),
            'view' => Pages\ViewAudit::route('/{record}'),
        ];
    }

    // Deshabilitar creación y eliminación
    public static function canCreate(): bool
    {
        return false;
    }

    public static function canDelete(\Illuminate\Database\Eloquent\Model $record): bool
    {
        return false;
    }

    public static function canDeleteAny(): bool
    {
        return false;
    }
}
