<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SiniestroResource\Pages;
use App\Models\Siniestro;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\TimePicker;
use Filament\Forms\Components\Toggle;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\BadgeColumn;

class SiniestroResource extends Resource
{
    protected static ?string $model = Siniestro::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form->schema([
            TextInput::make('id_interno')->required()->unique(ignoreRecord: true),

            DatePicker::make('fecha_siniestro')->required(),
            TimePicker::make('hora_siniestro')->required(),

            TextInput::make('comuna')->required(),
            TextInput::make('ciudad')->required(),
            TextInput::make('region')->required(),

            Toggle::make('policia_presente')->label('Policía presente'),
            Toggle::make('alcolemia_realizada')->label('Alcoholemia realizada'),
            Toggle::make('vehiculo_inmovilizado')->label('Vehículo inmovilizado'),

            TextInput::make('vehiculo_id')->required()->numeric(),
            TextInput::make('asegurado_id')->required()->numeric(),
            TextInput::make('denunciante_id')->nullable()->numeric(),
            TextInput::make('conductor_id')->required()->numeric(),
            TextInput::make('contratante_id')->nullable()->numeric(),

            TextInput::make('relacion_asegurado_conductor')->required(),
            TextInput::make('direccion_informada')->required(),
            TextInput::make('direccion_aproximada')->required(),

            TextInput::make('latitud')->required()->numeric(),
            TextInput::make('longitud')->required()->numeric(),

            Select::make('status')->options([
                'pendiente' => 'Pendiente',
                'investigacion' => 'Investigación',
                'completado' => 'Completado',
            ])->required(),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id_interno')->searchable()->sortable(),
                TextColumn::make('fecha_siniestro')->date(),
                TextColumn::make('hora_siniestro')->time(),
                TextColumn::make('comuna')->searchable(),
                TextColumn::make('region')->searchable(),
                TextColumn::make('vehiculo_id')->label('Vehículo ID'),
                TextColumn::make('asegurado_id')->label('Asegurado ID'),
                BadgeColumn::make('status')
                    ->colors([
                        'primary' => 'pendiente',
                        'warning' => 'investigacion',
                        'success' => 'completado',
                    ]),
                TextColumn::make('created_at')->dateTime('d-m-Y H:i')->label('Creado'),
            ])
            ->filters([])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    public static function getRelations(): array
    {
        return [];
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
