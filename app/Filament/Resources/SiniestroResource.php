<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SiniestroResource\Pages;
use App\Models\Siniestro;

use App\Filament\Resources\SiniestroResource\RelationManagers;
use App\Models\Vehiculo;
use Filament\Forms;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Forms\Components\Actions\Action;

use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\TimePicker;
use Filament\Forms\Components\Toggle;
use Filament\Resources\RelationManagers\RelationManager;
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

            TextInput::make('aseguradora')
            ->label('Aseguradora')
            ->maxLength(120)
            ->placeholder('BCI Seguros / Zenit / Mapfre / …')
            ->columnSpanFull(),

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
                ->suffixAction(
                    Action::make('createVehiculo')
                        ->label('Agregar vehículo')
                        ->icon('heroicon-o-plus')
                        ->form(Vehiculo::getFormSchema())
                        ->action(function (array $data, Set $set) {
                            $vehiculo = Vehiculo::create($data);
                            $set('vehiculo_id', $vehiculo->id);
                        })

                )
                ->getOptionLabelFromRecordUsing(
                    fn ($record) => "{$record->patente} — {$record->marca} {$record->modelo}"
                ),

            
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
                TextColumn::make('aseguradora')
                    ->label('Aseguradora')
                    ->searchable()
                    ->sortable(),
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
        return [
            //RelationManagers\ParticipantesRelationManager::class,
            RelationManagers\ParticipanteSiniestrosRelationManager::class,
        ];
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
