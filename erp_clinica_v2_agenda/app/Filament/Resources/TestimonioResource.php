<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TestimonioResource\Pages;
use App\Models\Testimonio;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class TestimonioResource extends Resource
{
    protected static ?string $model = Testimonio::class;

    protected static ?string $navigationIcon = 'heroicon-o-chat-bubble-left-right';
    protected static ?string $navigationLabel = 'Testimonios';
    protected static ?string $navigationGroup = 'Contenido Web';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('nombre_paciente')
                    ->required()
                    ->maxLength(255),
                Forms\Components\FileUpload::make('foto_paciente_path')
                    ->label('Foto del Paciente')
                    ->image()
                    ->directory('testimonios')
                    ->visibility('public')
                    ->nullable(),
                Forms\Components\Textarea::make('testimonio')
                    ->required()
                    ->columnSpanFull(),
                Forms\Components\Toggle::make('es_visible')
                    ->label('Visible en la Web')
                    ->default(true),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('foto_paciente_path')
                    ->label('Foto'),
                Tables\Columns\TextColumn::make('nombre_paciente')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('testimonio')
                    ->limit(50)
                    ->tooltip(fn ($record) => $record->testimonio),
                Tables\Columns\IconColumn::make('es_visible')
                    ->label('Visible')
                    ->boolean(),
            ])
            ->filters([
                Tables\Filters\TernaryFilter::make('es_visible')
                    ->label('Visibilidad')
                    ->trueLabel('Visible')
                    ->falseLabel('Oculto')
                    ->placeholder('Todos'), // Cambiado nullableLabel por placeholder
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
            'index' => Pages\ListTestimonios::route('/'),
            'create' => Pages\CreateTestimonio::route('/create'),
            'edit' => Pages\EditTestimonio::route('/{record}/edit'),
        ];
    }
}
