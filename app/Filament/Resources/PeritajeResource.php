<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PeritajeResource\Pages;
use App\Filament\Resources\PeritajeResource\RelationManagers;
use App\Models\Peritaje;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\{TextInput, Select};

class PeritajeResource extends Resource
{
    protected static ?string $model = Peritaje::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form->schema([
            TextInput::make('solicitante')
                ->label('Nombre del Solicitante')
                ->required(),

            Select::make('siniestro_id')
                ->label('Siniestro')
                ->relationship('siniestro', 'id_interno') // o el campo que quieras mostrar
                ->searchable()
                ->required(),

            Select::make('perito_id')
                ->label('Perito')
                ->relationship('perito', 'nombre') // asegúrate de que 'nombre' exista en tu modelo Perito
                ->searchable()
                ->required(),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                //
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
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
            'index' => Pages\ListPeritajes::route('/'),
            'create' => Pages\CreatePeritaje::route('/create'),
            'edit' => Pages\EditPeritaje::route('/{record}/edit'),
        ];
    }
}
