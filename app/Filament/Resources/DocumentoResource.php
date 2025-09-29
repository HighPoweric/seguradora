<?php

namespace App\Filament\Resources;

use App\Filament\Resources\DocumentoResource\Pages;
use App\Models\Documento;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Forms\Components\{TextInput, Textarea, Toggle};
use Filament\Tables\Columns\{TextColumn, IconColumn};

class DocumentoResource extends Resource
{
    protected static ?string $model = Documento::class;

    protected static ?string $navigationIcon = 'heroicon-o-document-text';
    protected static ?string $navigationLabel = 'Documentos';
    protected static ?string $modelLabel       = 'Documento';
    protected static ?string $pluralModelLabel = 'Documentos';

    public static function form(Form $form): Form
    {
        return $form->schema([
            TextInput::make('nombre')
                ->label('Nombre')
                ->required()
                ->maxLength(255)
                ->placeholder('Ej: Padrón del vehículo'),

            Textarea::make('descripcion')
                ->label('Descripción')
                ->rows(3),

            Toggle::make('obligatorio')
                ->label('Obligatorio')
                ->inline(false)
                ->default(false),


            TextInput::make('orden')
                ->label('Orden')
                ->numeric()
                ->minValue(0)
                ->helperText('Define prioridad/orden en listados'),
        ])->columns(2);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('nombre')
                    ->label('Nombre')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('descripcion')
                    ->label('Descripción')
                    ->limit(60)
                    ->toggleable(),

                IconColumn::make('obligatorio')
                    ->label('Obligatorio')
                    ->boolean()
                    ->sortable(),

                TextColumn::make('orden')
                    ->label('Orden')
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\TernaryFilter::make('obligatorio')
                    ->label('Obligatorio')
                    ->trueLabel('Sí')
                    ->falseLabel('No')
                    ->placeholder('Todos'),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('created_at', 'desc');
    }

    public static function getPages(): array
    {
        return [
            'index'  => Pages\ListDocumentos::route('/'),
            'create' => Pages\CreateDocumento::route('/create'),
            'edit'   => Pages\EditDocumento::route('/{record}/edit'),
        ];
    }
}
