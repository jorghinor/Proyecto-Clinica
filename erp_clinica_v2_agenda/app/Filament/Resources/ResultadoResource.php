<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ResultadoResource\Pages;
use App\Models\Resultado;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class ResultadoResource extends Resource
{
    protected static ?string $model = Resultado::class;

    protected static ?string $navigationIcon = 'heroicon-o-document-chart-bar';
    protected static ?string $navigationGroup = 'Registros Médicos';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('paciente_id')
                    ->relationship('paciente', 'nombre')
                    ->searchable()
                    ->preload()
                    ->required(),
                Forms\Components\Select::make('cita_id')
                    ->relationship('cita', 'id')
                    ->label('Cita Asociada (Opcional)'),
                Forms\Components\TextInput::make('tipo_examen')
                    ->label('Tipo de Examen')
                    ->required()
                    ->maxLength(255),
                Forms\Components\DatePicker::make('fecha_resultado')
                    ->default(now())
                    ->required(),
                Forms\Components\Textarea::make('descripcion')
                    ->columnSpanFull(),
                Forms\Components\FileUpload::make('archivo_path')
                    ->label('Archivo del Resultado')
                    ->directory('resultados')
                    ->visibility('public')
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('paciente.nombre')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('tipo_examen')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('fecha_resultado')
                    ->date()
                    ->sortable(),
            ])
            ->filters([
                //
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
            'index' => Pages\ListResultados::route('/'),
            'create' => Pages\CreateResultado::route('/create'),
            'edit' => Pages\EditResultado::route('/{record}/edit'),
        ];
    }
}
