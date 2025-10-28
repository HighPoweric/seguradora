<?php

namespace App\Filament\Resources;

use App\Filament\Resources\EntrevistaResource\Pages;
use App\Models\Entrevista;
use App\Models\Siniestro;
use App\Models\ParticipanteSiniestro;
use App\Models\Perito;
use Filament\Forms;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\BadgeColumn;

class EntrevistaResource extends Resource
{
    protected static ?string $model = Entrevista::class;

    protected static ?string $navigationIcon = 'heroicon-o-microphone';

    public static function form(Forms\Form $form): Forms\Form
    {
        return $form->schema([
            // Selecionar o siniestro (apenas na criação)
            Select::make('siniestro_id')
                ->label('Siniestro')
                ->options(Siniestro::all()->pluck('id_interno', 'id'))
                ->searchable()
                ->required()
                ->reactive()
                ->visible(fn ($context) => $context === 'create'),

            // Selecionar participante vinculado ao siniestro
            Select::make('participante_siniestro_id')
                ->label('Participante')
                ->options(function ($get) {
                    $siniestroId = $get('siniestro_id');
                    if (!$siniestroId) return [];
                    return ParticipanteSiniestro::where('siniestro_id', $siniestroId)
                        ->with('participante')
                        ->get()
                        ->mapWithKeys(fn($ps) => [
                            $ps->id => $ps->participante->nombre . ' ' . $ps->participante->apellido . ' (' . $ps->participante->rut . '-' . $ps->participante->dv . ')'
                        ]);
                })
                ->searchable()
                ->required()
                ->reactive(),

            Select::make('perito_id')
                ->label('Perito')
                ->options(Perito::all()->pluck('nombre', 'id'))
                ->searchable()
                ->nullable(),

            DateTimePicker::make('fecha_entrevista')
                ->label('Fecha de Entrevista')
                ->nullable(),

            FileUpload::make('archivo_audio')
                ->label('Archivo de Audio')
                ->nullable(),

            Textarea::make('transcripcion')
                ->label('Transcripción')
                ->nullable(),

            Select::make('estado')
                ->label('Estado')
                ->options([
                    'no iniciada' => 'No Iniciada',
                    'aguardando agenda' => 'Aguardando Agenda',
                    'agendada' => 'Agendada',
                    'completada' => 'Completada',
                ])
                ->default('no iniciada')
                ->required(),
        ]);
    }

    public static function table(Tables\Table $table): Tables\Table
    {
        return $table
            ->columns([
                TextColumn::make('participanteSiniestro.participante.nombre_completo_rut')
                    ->label('Participante')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('participanteSiniestro.siniestro.id_interno')
                    ->label('Siniestro')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('perito.nombre')->label('Perito')->sortable()->searchable(),
                TextColumn::make('fecha_entrevista')->label('Fecha de Entrevista')->dateTime('d/m/Y H:i')->sortable(),
                BadgeColumn::make('estado')
                    ->label('Estado')
                    ->colors([
                        'warning' => 'no iniciada',
                        'info' => 'aguardando agenda',
                        'primary' => 'agendada',
                        'success' => 'completada',
                    ])
                    ->sortable(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListEntrevistas::route('/'),
            'create' => Pages\CreateEntrevista::route('/create'),
            'edit' => Pages\EditEntrevista::route('/{record}/edit'),
        ];
    }
}
