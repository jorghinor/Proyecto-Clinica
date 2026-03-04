<?php

namespace App\Filament\Resources;

use App\Filament\Resources\LoteResource\Pages;
use App\Models\Lote;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Carbon;

class LoteResource extends Resource
{
    protected static ?string $model = Lote::class;

    protected static ?string $navigationIcon = 'heroicon-o-beaker';

    protected static ?string $navigationLabel = 'Lotes';
    protected static ?string $navigationGroup = 'Inventario';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('producto_id')
                    ->relationship('producto', 'nombre')
                    ->searchable()
                    ->preload()
                    ->required(),
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

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('producto.nombre')
                    ->searchable()
                    ->sortable(),
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
                Tables\Filters\SelectFilter::make('producto')
                    ->relationship('producto', 'nombre'),
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
            'index' => Pages\ListLotes::route('/'),
            'create' => Pages\CreateLote::route('/create'),
            'edit' => Pages\EditLote::route('/{record}/edit'),
        ];
    }
}
