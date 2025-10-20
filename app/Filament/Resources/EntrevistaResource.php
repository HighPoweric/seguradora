<?php

namespace App\Filament\Resources;

use App\Filament\Resources\EntrevistaResource\Pages;
use App\Models\Entrevista;
use Filament\Forms;
use Filament\Forms\Components\{Select, DateTimePicker, FileUpload, Textarea};
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\{TextColumn, BadgeColumn};

class EntrevistaResource extends Resource
{
    protected static ?string $model = Entrevista::class;

    protected static ?string $navigationIcon = 'heroicon-o-microphone';

    public static function form(Forms\Form $form): Forms\Form
    {
        return $form->schema([
            Select::make('peritaje_id')
                ->label('Peritaje')
                ->relationship('peritaje', 'id')
                ->searchable()
                ->required(),

            Select::make('participante_id')
                ->label('Participante')
                ->relationship('participante', 'nombre')
                ->searchable()
                ->required(),

            Select::make('perito_id')
                ->label('Perito')
                ->relationship('perito', 'nombre')
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
                TextColumn::make('peritaje.id')->label('Peritaje')->sortable(),
                TextColumn::make('participante.nombre')->label('Participante')->searchable()->sortable(),
                TextColumn::make('perito.nombre')->label('Perito')->searchable()->sortable(),
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
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('estado')
                    ->label('Estado')
                    ->options([
                        'no iniciada' => 'No Iniciada',
                        'aguardando agenda' => 'Aguardando Agenda',
                        'agendada' => 'Agendada',
                        'completada' => 'Completada',
                    ]),
                Tables\Filters\SelectFilter::make('peritaje_id')
                    ->relationship('peritaje', 'id')
                    ->label('Peritaje'),
                Tables\Filters\SelectFilter::make('participante_id')
                    ->relationship('participante', 'nombre')
                    ->label('Participante'),
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
