<?php

namespace App\Filament\Resources\PeritajeResource\RelationManagers;

use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Columns\{TextColumn, IconColumn};
use Filament\Tables\Actions;
use Filament\Forms\Components\{Toggle, FileUpload};
use Illuminate\Database\Eloquent\Builder;
use App\Models\ChecklistDocumento;

class ChecklistDocumentosRelationManager extends RelationManager
{
    protected static string $relationship = 'checklistDocumentos'; // método en Peritaje

    public function table(Table $table): Table
    {
        return $table
            // Evita N+1
            ->modifyQueryUsing(fn (Builder $query) => $query->with('documento'))
            ->columns([
                TextColumn::make('documento.nombre')
                    ->label('Documento')
                    ->sortable()
                    ->searchable(),

                IconColumn::make('requerido')
                    ->label('Req.')
                    ->boolean()
                    ->tooltip('Requerido'),

                IconColumn::make('cargado')
                    ->label('Cargado')
                    ->boolean(),

                TextColumn::make('ruta')
                    ->label('Archivo')
                    ->url(fn (ChecklistDocumento $record) => $record->ruta ? asset('storage/'.$record->ruta) : null, true)
                    ->openUrlInNewTab()
                    ->formatStateUsing(fn ($state) => $state ? 'Ver archivo' : '—'),

                TextColumn::make('updated_at')
                    ->since()
                    ->label('Actualizado')
                    ->toggleable(),
            ])
            ->filters([])
            ->headerActions([]) // las filas se crean por observer/seed
            ->actions([
                Actions\EditAction::make()
                    ->label('Editar')
                    ->form([
                        Toggle::make('requerido')->label('Requerido'),
                        Toggle::make('cargado')->label('Cargado'),

                        // Guarda la ruta en la columna 'ruta'
                        FileUpload::make('ruta')
                            ->label('Archivo')
                            ->disk('public')
                            ->directory(fn (ChecklistDocumento $record) => 'peritajes/'.$record->peritaje_id.'/documentos')
                            ->preserveFilenames()
                            ->visibility('public')
                            ->helperText('PDF/JPG/PNG. Se guarda en /storage/app/public')
                            ->acceptedFileTypes(['application/pdf','image/*']),
                    ]),
            ])
            ->defaultSort('documento.nombre');
    }
}
