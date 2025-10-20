<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TerceroResource\Pages;
use App\Models\Tercero;
use App\Models\Participante;
use Filament\Forms;
use Filament\Forms\Components\Actions\Action;
use Filament\Forms\Components\{Select, TextInput};
use Filament\Forms\Set;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\{TextColumn};

class TerceroResource extends Resource
{
    protected static ?string $model = Tercero::class;

    protected static ?string $navigationIcon = 'heroicon-o-user-group';

    public static function form(Forms\Form $form): Forms\Form
    {
        return $form->schema([
            Select::make('siniestro_id')
                ->label('Siniestro')
                ->relationship('siniestro', 'id')
                ->searchable()->preload()
                ->required()
                ->getOptionLabelFromRecordUsing(
                    fn ($record) => "{$record->id_interno} - Asegurado: {$record->asegurado->nombre} {$record->asegurado->apellido}"
                ),

            Select::make('participante_id')
                ->label('Participante')
                ->relationship('participante', 'nombre')
                ->searchable()->preload()
                ->required()
                ->suffixAction(
                    Action::make('createParticipante')
                        ->label('Agregar participante')
                        ->icon('heroicon-o-plus')
                        ->form(Participante::getFormSchema())
                        ->action(function (array $data, Set $set) {
                            $participante = Participante::create($data);
                            $set('contratante_id', $participante->id);
                        })

                )
                ->getOptionLabelFromRecordUsing(
                    fn ($record) => trim("{$record->nombre} {$record->apellido} - {$record->rut}")
                ),

            TextInput::make('rol')
                ->label('Rol')
                ->required(),
        ]);
    }

    public static function table(Tables\Table $table): Tables\Table
    {
        return $table
            ->columns([
                TextColumn::make('siniestro.id')->label('Siniestro')->sortable(),
                TextColumn::make('participante.nombre')->label('Participante')->searchable()->sortable(),
                TextColumn::make('rol')->label('Rol')->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('siniestro_id')
                    ->relationship('siniestro', 'id')
                    ->label('Siniestro'),
                Tables\Filters\SelectFilter::make('participante_id')
                    ->relationship('participante', 'nombre')
                    ->label('Participante'),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListTerceros::route('/'),
            'create' => Pages\CreateTercero::route('/create'),
            'edit' => Pages\EditTercero::route('/{record}/edit'),
        ];
    }
}
