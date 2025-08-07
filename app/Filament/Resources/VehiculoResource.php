<?php

namespace App\Filament\Resources;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Tables\Columns\TextColumn;

use App\Filament\Resources\VehiculoResource\Pages;
use App\Filament\Resources\VehiculoResource\RelationManagers;
use App\Models\Vehiculo;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class VehiculoResource extends Resource
{
    protected static ?string $model = Vehiculo::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';


    public static function form(Form $form): Form
    {
        return $form->schema([
            TextInput::make('patente')
                ->label('Patente')
                ->required()
                ->unique(ignoreRecord: true),

            Select::make('tipo')
                ->label('Tipo de Vehículo')
                ->options([
                    'auto' => 'Auto',
                    'camioneta' => 'Camioneta',
                    'moto' => 'Moto',
                ])
                ->required(),

            TextInput::make('marca')
                ->label('Marca')
                ->required(),

            TextInput::make('modelo')
                ->label('Modelo')
                ->required(),
        ]);
    }


    public static function table(Table $table): Table
    {
        return $table
            ->columns([
            TextColumn::make('patente')->label('Patente')->sortable()->searchable(),
            TextColumn::make('marca')->label('Marca')->sortable(),
            TextColumn::make('modelo')->label('Modelo')->sortable(),
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
            'index' => Pages\ListVehiculos::route('/'),
            'create' => Pages\CreateVehiculo::route('/create'),
            'edit' => Pages\EditVehiculo::route('/{record}/edit'),
        ];
    }
}
