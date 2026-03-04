<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ConsentimientoResource\Pages;
use App\Models\Consentimiento;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class ConsentimientoResource extends Resource
{
    protected static ?string $model = Consentimiento::class;

    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static ?string $navigationLabel = 'Consentimientos';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Datos del Documento')
                    ->schema([
                        Forms\Components\Select::make('paciente_id')
                            ->relationship('paciente', 'nombre')
                            ->getOptionLabelFromRecordUsing(fn ($record) => "{$record->nombre} {$record->apellido}")
                            ->searchable()
                            ->preload()
                            ->required(),
                        Forms\Components\TextInput::make('titulo')
                            ->label('Título del Documento')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\RichEditor::make('contenido_legal')
                            ->label('Términos y Condiciones')
                            ->required()
                            ->columnSpanFull(),
                    ])->columns(2),

                Forms\Components\Section::make('Firma Digital')
                    ->schema([
                        Forms\Components\FileUpload::make('firma_digital_path')
                            ->label('Imagen de la Firma')
                            ->image()
                            ->directory('firmas')
                            ->visibility('public')
                            ->columnSpanFull(),
                        Forms\Components\Select::make('estado')
                            ->options([
                                'borrador' => 'Borrador',
                                'firmado' => 'Firmado',
                            ])
                            ->default('borrador')
                            ->required(),
                        Forms\Components\DateTimePicker::make('fecha_firma')
                            ->label('Fecha de Firma')
                            ->default(now()),
                    ])->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('titulo')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('paciente.nombre')
                    ->label('Paciente')
                    ->formatStateUsing(fn ($record) => "{$record->paciente->nombre} {$record->paciente->apellido}")
                    ->searchable(),
                Tables\Columns\TextColumn::make('estado')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'borrador' => 'gray',
                        'firmado' => 'success',
                    }),
                Tables\Columns\TextColumn::make('fecha_firma')
                    ->dateTime()
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('estado')
                    ->options([
                        'borrador' => 'Borrador',
                        'firmado' => 'Firmado',
                    ]),
            ])
            ->actions([
                Tables\Actions\Action::make('pdf')
                    ->label('PDF')
                    ->icon('heroicon-o-arrow-down-tray')
                    ->url(fn (Consentimiento $record) => route('consentimientos.pdf', $record))
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
            'index' => Pages\ListConsentimientos::route('/'),
            'create' => Pages\CreateConsentimiento::route('/create'),
            'edit' => Pages\EditConsentimiento::route('/{record}/edit'),
        ];
    }
}
