<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CitaResource\Pages;
use App\Models\Cita;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class CitaResource extends Resource
{
    protected static ?string $model = Cita::class;

    protected static ?string $navigationIcon = 'heroicon-o-calendar';

    protected static ?string $navigationLabel = 'Agenda de Citas';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('paciente_id')
                    ->relationship('paciente', 'nombre')
                    ->getOptionLabelFromRecordUsing(fn ($record) => "{$record->nombre} {$record->apellido}")
                    ->searchable()
                    ->preload()
                    ->required(),
                Forms\Components\Select::make('medico_id')
                    ->relationship('medico', 'nombre')
                    ->searchable()
                    ->preload()
                    ->required(),
                Forms\Components\DatePicker::make('fecha')
                    ->required(),
                Forms\Components\TimePicker::make('hora')
                    ->required()
                    ->seconds(false),
                Forms\Components\Select::make('estado')
                    ->options([
                        'reservado' => 'Reservado',
                        'atendido' => 'Atendido',
                        'cancelado' => 'Cancelado',
                    ])
                    ->required()
                    ->default('reservado'),
                Forms\Components\Textarea::make('observacion')
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('fecha')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('hora')
                    ->time('H:i')
                    ->sortable(),
                Tables\Columns\TextColumn::make('paciente.nombre')
                    ->label('Paciente')
                    ->formatStateUsing(fn ($record) => "{$record->paciente->nombre} {$record->paciente->apellido}")
                    ->searchable(['nombre', 'apellido']),
                Tables\Columns\TextColumn::make('medico.nombre')
                    ->label('Médico')
                    ->searchable(),
                Tables\Columns\TextColumn::make('estado')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'reservado' => 'warning',
                        'atendido' => 'success',
                        'cancelado' => 'danger',
                    }),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('estado')
                    ->options([
                        'reservado' => 'Reservado',
                        'atendido' => 'Atendido',
                        'cancelado' => 'Cancelado',
                    ]),
                Tables\Filters\SelectFilter::make('medico')
                    ->relationship('medico', 'nombre'),
            ])
            ->actions([
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
            'index' => Pages\ListCitas::route('/'),
            'create' => Pages\CreateCita::route('/create'),
            'edit' => Pages\EditCita::route('/{record}/edit'),
        ];
    }
}
