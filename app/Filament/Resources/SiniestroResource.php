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
            TextInput::make('id_interno')
            ->label('N° interno')
            ->required()
            ->unique(ignoreRecord: true)
            ->default(fn () => (string) (((int) (\App\Models\Siniestro::max('id_interno') ?? 0)) + 1))
            ->disabledOn('edit'),


            DatePicker::make('fecha_siniestro')
                ->label('Fecha siniestro')
                ->required(),

            TimePicker::make('hora_siniestro')
                ->label('Hora siniestro')
                ->required(),

            TextInput::make('comuna')->required(),
            TextInput::make('ciudad')->required(),
            TextInput::make('region')->required(),

            Toggle::make('policia_presente')->label('Policía presente'),
            Toggle::make('alcolemia_realizada')->label('Alcoholemia realizada'),
            Toggle::make('vehiculo_inmovilizado')->label('Vehículo inmovilizado'),

            Select::make('vehiculo_id')
                ->label('Vehículo')
                ->relationship('vehiculo', 'patente')
                ->required()
                ->searchable()
                ->preload()
                ->native(false)
                ->getOptionLabelFromRecordUsing(
                    fn ($record) => "{$record->patente} — {$record->marca} {$record->modelo}"
                ),

            Select::make('asegurado_id')
                ->label('Asegurado')
                ->relationship('asegurado', 'nombre')
                ->required()
                ->searchable()
                ->preload()
                ->native(false)
                ->getOptionLabelFromRecordUsing(
                    fn ($record) => trim("{$record->nombre} {$record->apellido}") .
                        ' — RUT ' . ($record->rut ?? '') . (isset($record->dv) ? "-{$record->dv}" : '')
                ),

            Select::make('denunciante_id')
                ->label('Denunciante')
                ->relationship('denunciante', 'nombre')
                ->searchable()
                ->preload()
                ->native(false)
                ->getOptionLabelFromRecordUsing(
                    fn ($record) => trim("{$record->nombre} {$record->apellido}") .
                        ($record->correo ? " — {$record->correo}" : '')
                ),

            Select::make('conductor_id')
                ->label('Conductor')
                ->relationship('conductor', 'nombre')
                ->required()
                ->searchable()
                ->preload()
                ->native(false)
                ->getOptionLabelFromRecordUsing(
                    fn ($record) => trim("{$record->nombre} {$record->apellido}") .
                        (isset($record->licencia) ? " — Lic. {$record->licencia}" : '')
                ),

            Select::make('contratante_id')
                ->label('Contratante')
                ->relationship('contratante', 'nombre')
                ->searchable()
                ->preload()
                ->native(false)
                ->getOptionLabelFromRecordUsing(
                    fn ($record) => trim("{$record->nombre} {$record->apellido}")
                ),

            TextInput::make('relacion_asegurado_conductor')
                ->label('Relación asegurado–conductor')
                ->required(),

            TextInput::make('direccion_informada')->required(),
            TextInput::make('direccion_aproximada')->required(),

            TextInput::make('latitud')->required(),
            TextInput::make('longitud')->required(),

            Select::make('status')
                ->label('Status')
                ->options([
                    'pendiente'     => 'Pendiente',
                    'investigacion' => 'Investigación',
                    'completado'    => 'Completado',
                ])
                ->required(),
        ])->columns(2);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id_interno')->label('Id interno')->searchable()->sortable(),
                TextColumn::make('fecha_siniestro')->label('Fecha')->date(),
                TextColumn::make('hora_siniestro')->label('Hora')->time(),
                TextColumn::make('comuna')->searchable(),
                TextColumn::make('region')->searchable(),

                TextColumn::make('vehiculo.patente')->label('Patente')->searchable()->sortable(),
                TextColumn::make('asegurado.nombre')->label('Asegurado')->searchable()->sortable(),
                TextColumn::make('conductor.nombre')->label('Conductor')->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('denunciante.nombre')->label('Denunciante')->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('contratante.nombre')->label('Contratante')->toggleable(isToggledHiddenByDefault: true),

                BadgeColumn::make('status')
                    ->label('Estado')
                    ->colors([
                        'warning' => 'pendiente',
                        'info'    => 'investigacion',
                        'success' => 'completado',
                    ])
                    ->formatStateUsing(fn ($state) => ucfirst($state)),

                TextColumn::make('created_at')->label('Creado')->dateTime('d-m-Y H:i'),
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
            'index'  => Pages\ListSiniestros::route('/'),
            'create' => Pages\CreateSiniestro::route('/create'),
            'edit'   => Pages\EditSiniestro::route('/{record}/edit'),
        ];
    }
}
