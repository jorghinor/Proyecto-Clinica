<?php

namespace App\Filament\Resources\PacienteResource\RelationManagers;

use App\Filament\Resources\HistoriaClinicaResource;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;

class HistoriasClinicasRelationManager extends RelationManager
{
    protected static string $relationship = 'historiasClinicas';

    protected static ?string $title = 'Historial de Consultas';

    public function form(Form $form): Form
    {
        // El formulario completo se gestionará en HistoriaClinicaResource
        return $form->schema([]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('motivo_consulta')
            ->columns([
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Fecha')
                    ->dateTime('d/m/Y H:i')
                    ->sortable(),
                Tables\Columns\TextColumn::make('medico.nombre')
                    ->label('Atendido por'),
                Tables\Columns\TextColumn::make('motivo_consulta')
                    ->limit(50)
                    ->tooltip(fn (Model $record) => $record->motivo_consulta),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                // Al crear, pre-llenamos el paciente actual
                Tables\Actions\CreateAction::make()
                    ->url(fn () => HistoriaClinicaResource::getUrl('create', ['ownerRecord' => $this->getOwnerRecord()])),
            ])
            ->actions([
                // Al ver/editar, vamos al recurso principal
                Tables\Actions\Action::make('Ver')
                    ->url(fn (Model $record): string => HistoriaClinicaResource::getUrl('edit', ['record' => $record]))
                    ->icon('heroicon-o-arrow-top-right-on-square'),
            ])
            ->bulkActions([]);
    }
}
