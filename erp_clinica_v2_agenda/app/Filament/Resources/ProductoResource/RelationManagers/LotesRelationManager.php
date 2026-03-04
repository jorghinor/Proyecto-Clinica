<?php

namespace App\Filament\Resources\ProductoResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Carbon;

class LotesRelationManager extends RelationManager
{
    protected static string $relationship = 'lotes';

    protected static ?string $title = 'Lotes del Producto';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('numero_lote')
                    ->required()
                    ->maxLength(255),
                Forms\Components\DatePicker::make('fecha_vencimiento')
                    ->required(),
                Forms\Components\TextInput::make('cantidad_inicial')
                    ->numeric()
                    ->required(),
                Forms\Components\TextInput::make('cantidad_actual')
                    ->numeric()
                    ->required(),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('numero_lote')
            ->columns([
                Tables\Columns\TextColumn::make('numero_lote')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('fecha_vencimiento')
                    ->date()
                    ->sortable()
                    ->color(fn (string $state): string => Carbon::parse($state)->isPast() ? 'danger' : (Carbon::parse($state)->isBefore(now()->addMonths(3)) ? 'warning' : 'success')),
                Tables\Columns\TextColumn::make('cantidad_inicial')
                    ->sortable(),
                Tables\Columns\TextColumn::make('cantidad_actual')
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
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
}
