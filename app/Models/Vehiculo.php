<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Forms;

class Vehiculo extends Model
{
    protected $fillable = [
        'patente',
        'tipo',
        'marca',
        'modelo',
    ];

    //metodo estatico para definir el esquema del formulario de Filament
    public static function getFormSchema() : array
    {
        return[
            TextInput::make('patente')
                ->label('Patente')
                ->required()
                ->unique()
                ->maxLength(10),
            Select::make('tipo')
                ->label('Tipo de vehículo')
                ->options([
                    'auto' => 'Auto',
                    'camioneta' => 'Camioneta',
                    'moto' => 'Moto',
                ])
                ->required(),
            TextInput::make('marca')
                ->label('Marca')
                ->required()
                ->maxLength(50),
            TextInput::make('modelo')
                ->label('Modelo')
                ->required()
                ->maxLength(50),
        ];
    }

    //Relación con Siniestro (un vehículo puede tener muchos siniestros)
    public function siniestros()
    {
        return $this->hasMany(Siniestro::class);
    }

}   