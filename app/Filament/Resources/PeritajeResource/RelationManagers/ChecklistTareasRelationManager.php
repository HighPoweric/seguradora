<?php

namespace App\Filament\Resources\PeritajeResource\RelationManagers;

use Illuminate\Database\Eloquent\Builder;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Columns\{TextColumn, BadgeColumn};
use Filament\Tables\Actions;
use Filament\Forms\Components\{Select, Textarea};
use Illuminate\Support\Facades\Auth;
use App\Models\ChecklistTarea;

class ChecklistTareasRelationManager extends RelationManager
{
    protected static string $relationship = 'checklistTareas';

    public function table(Table $table): Table
    {
        return $table
            // 👇 Usa $query (o tipado) – no $q
            ->modifyQueryUsing(fn (Builder $query) => $query->with(['tarea', 'responsable']))
            ->columns([
                TextColumn::make('tarea.tarea')->label('Tarea')->sortable()->searchable(),

                BadgeColumn::make('estado')->label('Estado')->colors([
                    'gray'    => 'no_iniciada',
                    'warning' => 'pendiente',
                    'info'    => 'en_proceso',
                    'success' => 'completada',
                ]),

                TextColumn::make('responsable.name')->label('Responsable')->toggleable(),
                TextColumn::make('completada_at')->label('Terminado')->since()->toggleable(),
                TextColumn::make('observaciones')->label('Notas')->limit(40)->toggleable(),


            ])
            ->headerActions([]) // se crean desde catálogos u observer
            ->actions([
                // Completar (1 clic)
                Actions\Action::make('completar')
                    ->label('Marcar completada')
                    ->icon('heroicon-o-check-circle')
                    ->color('success')
                    // 👇 Usa $record — no $r
                    ->visible(fn (ChecklistTarea $record) => $record->estado !== 'completada')
                    ->action(function (ChecklistTarea $record) {
                        $record->estado = 'completada';
                        $record->completada_at = now();
                        $record->responsable_id = Auth::id();
                        $record->save();
                    }),

                // Reabrir
                Actions\Action::make('reabrir')
                    ->label('Reabrir')
                    ->icon('heroicon-o-arrow-path')
                    ->color('warning')
                    ->visible(fn (ChecklistTarea $record) => $record->estado === 'completada')
                    ->action(function (ChecklistTarea $record) {
                        $record->estado = 'pendiente';
                        $record->completada_at = null;
                        // $record->responsable_id = null; // si quieres limpiar
                        $record->save();
                    }),

                // Edición detallada (estado + notas)
                Actions\EditAction::make()->form([
                    Select::make('estado')
                        ->options([
                            'no_iniciada' => 'No iniciada',
                            'pendiente'   => 'Pendiente',
                            'en_proceso'  => 'En proceso',
                            'completada'  => 'Completada',
                        ])->required(),
                    Textarea::make('observaciones')->rows(4),
                ])->using(function (ChecklistTarea $record, array $data) {
                    $record->fill($data);
                    if ($record->estado === 'completada' && ! $record->completada_at) {
                        $record->completada_at = now();
                    }
                    $record->save();
                    return $record;
                }),
            ])
            // Evita defaultSort por relación (puede fallar sin join)
            ->defaultSort('id', 'asc');
    }
}
