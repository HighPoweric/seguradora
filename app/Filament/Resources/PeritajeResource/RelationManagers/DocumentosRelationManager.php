<?php

namespace App\Filament\Resources\PeritajeResource\RelationManagers;

use Filament\Resources\RelationManagers\RelationManager;
use Filament\Forms;
use Filament\Tables;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Storage;
use Filament\Notifications\Notification;

// Forms
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Textarea;

// Table Columns
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\BadgeColumn;

// Actions
use Filament\Tables\Actions\AttachAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\DetachAction;
use Filament\Tables\Actions\Action;

class DocumentosRelationManager extends RelationManager
{
    protected static string $relationship = 'documentos';
    protected static ?string $title = 'Documentos';

    public function form(Forms\Form $form): Forms\Form
    {
        return $form->schema([
            Toggle::make('pivot.requerido')
                ->label('Requerido')
                ->default(true),

            Select::make('pivot.estado')
                ->label('Estado')
                ->options([
                    'pendiente' => 'Pendiente',
                    'entregado' => 'Entregado',
                    'rechazado' => 'Rechazado',
                ])
                ->default('pendiente')
                ->required(),

            Textarea::make('pivot.observacion')
                ->label('Observación')
                ->rows(2),

            FileUpload::make('pivot.archivo')
                ->label('Archivo')
                ->disk('public')
                ->directory('peritajes/documentos')
                ->downloadable()
                ->openable()
                ->previewable(true),
        ])->columns(2);
    }

    public function table(Tables\Table $table): Tables\Table
    {
        return $table
            ->columns([
                TextColumn::make('nombre')
                    ->label('Documento')
                    ->searchable()
                    ->sortable(),

                IconColumn::make('pivot.requerido')
                    ->label('Req.')
                    ->boolean(),

                BadgeColumn::make('pivot.estado')
                    ->label('Estado')
                    ->colors([
                        'warning' => 'pendiente',
                        'success' => 'entregado',
                        'danger'  => 'rechazado',
                    ])
                    ->sortable(),

                TextColumn::make('pivot.observacion')
                    ->label('Observación')
                    ->limit(40)
                    ->toggleable(),

                // Muestra nombre del archivo y permite abrirlo en nueva pestaña
                TextColumn::make('pivot.archivo')
                    ->label('Archivo')
                    ->url(fn ($record) => $record->pivot?->archivo ? Storage::url($record->pivot->archivo) : null)
                    ->openUrlInNewTab()
                    ->formatStateUsing(fn ($state) => $state ? basename($state) : '—'),
            ])
            ->headerActions([
                AttachAction::make()
                    ->label('Adjuntar')
                    ->recordSelect(fn (Select $select) => $select->searchable()->preload())
                    ->form(fn (AttachAction $action): array => [
                        $action->getRecordSelect(),
                        Toggle::make('requerido')->label('Requerido')->default(true),
                        Select::make('estado')
                            ->label('Estado')
                            ->options([
                                'pendiente' => 'Pendiente',
                                'entregado' => 'Entregado',
                                'rechazado' => 'Rechazado',
                            ])
                            ->default('pendiente')
                            ->required(),
                        Textarea::make('observacion')->label('Observación')->rows(2),
                        FileUpload::make('archivo')
                            ->label('Archivo')
                            ->disk('public')
                            ->directory('peritajes/documentos')
                            ->downloadable()
                            ->openable()
                            ->previewable(true),
                    ])
                    ->using(function (RelationManager $livewire, array $data): void {
                        $recordId = $data['recordId'] ?? null;
                        if (! $recordId) return;

                        $pivot = Arr::except($data, ['recordId']);
                        $relation = $livewire->getRelationship();

                        if ($relation->whereKey($recordId)->exists()) {
                            $relation->updateExistingPivot($recordId, $pivot);
                        } else {
                            $relation->attach($recordId, $pivot);
                        }
                    }),
            ])
            ->actions([
                // Botón Descargar (responde con un download real)
                Action::make('descargar')
                    ->label('Descargar')
                    ->icon('heroicon-m-arrow-down-tray')
                    ->visible(fn ($record) => filled($record->pivot?->archivo))
                    ->action(function ($record) {
                        $path = $record->pivot->archivo ?? null;

                        if (! $path || ! Storage::disk('public')->exists($path)) {
                            Notification::make()
                                ->title('Archivo no encontrado')
                                ->body('El archivo asociado no existe o fue movido.')
                                ->danger()
                                ->send();
                            return;
                        }

                        // Devuelve respuesta de descarga
                        return Storage::disk('public')->download($path, basename($path));
                    }),

                EditAction::make()->label('Editar'),

                DetachAction::make()
                    ->label('Quitar')
                    ->hidden(fn ($record) => (bool) ($record->pivot?->requerido)),
            ]);
    }
}
