<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SiniestroResource\Pages;
use App\Filament\Resources\SiniestroResource\RelationManagers;
use App\Models\Siniestro;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class SiniestroResource extends Resource
{
    protected static ?string $model = Siniestro::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form->schema([
            \Filament\Forms\Components\TextInput::make('id_interno')
                ->label('ID Interno')
                ->required()
                ->unique(ignoreRecord: true),

            \Filament\Forms\Components\Select::make('vehiculo_id')
                ->label('Vehículo')
                ->relationship('vehiculo', 'patente')
                ->searchable()
                ->required(),

            \Filament\Forms\Components\Select::make('asegurado_id')
                ->label('Asegurado')
                ->relationship('asegurado', 'nombre')
                ->searchable()
                ->required(),

            \Filament\Forms\Components\Select::make('denunciante_id')
                ->label('Denunciante')
                ->relationship('denunciante', 'nombre')
                ->searchable()
                ->nullable(),

            \Filament\Forms\Components\Select::make('conductor_id')
                ->label('Conductor')
                ->relationship('conductor', 'nombre')
                ->searchable()
                ->required(),

            \Filament\Forms\Components\Select::make('contratante_id')
                ->label('Contratante')
                ->relationship('contratante', 'nombre')
                ->searchable()
                ->nullable(),

            \Filament\Forms\Components\TextInput::make('relacion_asegurado_conductor')
                ->label('Relación asegurado/conductor')
                ->required(),

            \Filament\Forms\Components\TextInput::make('direccion_aproximada')
                ->label('Dirección aproximada')
                ->required(),

            \Filament\Forms\Components\TextInput::make('latitud')
                ->numeric()
                ->required(),

            \Filament\Forms\Components\TextInput::make('longitud')
                ->numeric()
                ->required(),

            \Filament\Forms\Components\Select::make('status')
                ->options([
                    'pendiente' => 'Pendiente',
                    'investigacion' => 'Investigación',
                    'completado' => 'Completado',
                ])
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
            'index' => Pages\ListSiniestros::route('/'),
            'create' => Pages\CreateSiniestro::route('/create'),
            'edit' => Pages\EditSiniestro::route('/{record}/edit'),
        ];
    }
}
