<?php

namespace App\Filament\Resources\PeritajeResource\RelationManagers;

use Filament\Resources\RelationManagers\RelationManager;
use Filament\Forms;
use Filament\Tables;

class DocumentosRelationManager extends RelationManager
{
    protected static string $relationship = 'documentos';
    protected static ?string $title = 'Documentos';

    public function form(Forms\Form $form): Forms\Form
    {
        return $form->schema([
            Forms\Components\Toggle::make('pivot_requerido')
                ->label('Requerido')
                ->default(true),

            Forms\Components\Select::make('pivot_estado')
                ->label('Estado')
                ->options([
                    'pendiente' => 'Pendiente',
                    'entregado' => 'Entregado',
                    'rechazado' => 'Rechazado',
                ])
                ->default('pendiente'),

            Forms\Components\Textarea::make('pivot_observacion')
                ->label('Observación')
                ->rows(2),
        ])->columns(2);
    }

    public function table(Tables\Table $table): Tables\Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('nombre')
                    ->label('Documento')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\IconColumn::make('pivot_requerido')
                    ->label('Req.')
                    ->boolean(),

                Tables\Columns\BadgeColumn::make('pivot_estado')
                    ->label('Estado')
                    ->colors([
                        'warning' => 'pendiente',
                        'success' => 'entregado',
                        'danger'  => 'rechazado',
                    ]),

                Tables\Columns\TextColumn::make('pivot_observacion')
                    ->label('Observación')
                    ->limit(40),
            ])
            ->headerActions([
                Tables\Actions\AttachAction::make()
                    ->label('Adjuntar')
                    ->preloadRecordSelect()
                    ->form([
                        // OJO: en AttachAction NO se usa el prefijo "pivot_"
                        Forms\Components\Toggle::make('requerido')
                            ->label('Requerido')
                            ->default(true),

                        Forms\Components\Select::make('estado')
                            ->label('Estado')
                            ->options([
                                'pendiente' => 'Pendiente',
                                'entregado' => 'Entregado',
                                'rechazado' => 'Rechazado',
                            ])
                            ->default('pendiente'),

                        Forms\Components\Textarea::make('observacion')
                            ->label('Observación'),
                    ]),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),   // aquí sí usa los campos "pivot_"
                Tables\Actions\DetachAction::make()->label('Quitar'),
            ]);
    }
}
