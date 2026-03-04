<?php

namespace App\Filament\Resources;

use App\Filament\Resources\HistoriaClinicaResource\Pages;
use App\Models\HistoriaClinica;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class HistoriaClinicaResource extends Resource
{
    protected static ?string $model = HistoriaClinica::class;

    protected static ?string $navigationIcon = 'heroicon-o-clipboard-document-list';

    protected static ?string $navigationLabel = 'Historias Clínicas';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Tabs::make('Historia Clínica')->tabs([
                    Forms\Components\Tabs\Tab::make('Datos Generales')
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
                            Forms\Components\Select::make('cita_id')
                                ->relationship('cita', 'id') // Podríamos mejorar el label aquí
                                ->label('Cita Asociada (Opcional)'),
                            Forms\Components\Textarea::make('motivo_consulta')
                                ->required()
                                ->columnSpanFull(),
                        ])->columns(2),

                    Forms\Components\Tabs\Tab::make('Evaluación Médica')
                        ->schema([
                            Forms\Components\RichEditor::make('examen_fisico')
                                ->label('Examen Físico y Anamnesis'),
                            Forms\Components\RichEditor::make('diagnostico')
                                ->label('Diagnóstico Principal')
                                ->required(),
                        ]),

                    Forms\Components\Tabs\Tab::make('Plan y Tratamiento')
                        ->schema([
                            Forms\Components\RichEditor::make('tratamiento'),
                            Forms\Components\RichEditor::make('receta_medica')
                                ->label('Receta Médica'),
                        ]),

                    Forms\Components\Tabs\Tab::make('Notas Privadas')
                        ->schema([
                            Forms\Components\RichEditor::make('notas_privadas')
                                ->label('Notas (Solo visibles para personal médico)'),
                        ]),
                ])->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Fecha de Consulta')
                    ->dateTime('d/m/Y H:i')
                    ->sortable(),
                Tables\Columns\TextColumn::make('paciente.nombre')
                    ->label('Paciente')
                    ->formatStateUsing(fn ($record) => "{$record->paciente->nombre} {$record->paciente->apellido}")
                    ->searchable(),
                Tables\Columns\TextColumn::make('medico.nombre')
                    ->label('Médico')
                    ->searchable(),
                Tables\Columns\TextColumn::make('motivo_consulta')
                    ->label('Motivo')
                    ->limit(40)
                    ->tooltip(fn ($record) => $record->motivo_consulta),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('paciente')
                    ->relationship('paciente', 'nombre'), // Aquí hay que ajustar para buscar por nombre y apellido
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
            'index' => Pages\ListHistoriaClinicas::route('/'),
            'create' => Pages\CreateHistoriaClinica::route('/create'),
            'edit' => Pages\EditHistoriaClinica::route('/{record}/edit'),
        ];
    }
}
