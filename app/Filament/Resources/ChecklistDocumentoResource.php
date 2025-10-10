<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ChecklistDocumentoResource\Pages;
use App\Models\ChecklistDocumento;
use App\Models\Peritaje;
use App\Models\Documento;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Forms\Components\{Select, DatePicker, FileUpload, Textarea, TextInput};
use Filament\Tables\Columns\{TextColumn, BadgeColumn};

class ChecklistDocumentoResource extends Resource
{
    protected static ?string $model = ChecklistDocumento::class;

    // Ocultar del nav: se administra desde Peritaje
    protected static bool $shouldRegisterNavigation = false;

    public static function form(Form $form): Form
    {
        return $form->schema([
            Select::make('peritaje_id')
                ->label('Peritaje')
                ->relationship('peritaje', 'id')
                ->searchable()
                ->preload()
                ->required(),

            Select::make('documento_id')
                ->label('Documento')
                ->options(fn () => Documento::orderBy('orden')->pluck('nombre', 'id'))
                ->searchable()
                ->required(),

            Select::make('estado')
                ->label('Estado')
                ->options([
                    'pendiente' => 'Pendiente',
                    'aprobado'  => 'Aprobado',
                    'rechazado' => 'Rechazado',
                ])
                ->required(),

            DatePicker::make('fecha_recepcion')
                ->label('Fecha de recepción')
                ->native(false),

            FileUpload::make('archivo')
                ->label('Archivo')
                ->directory(fn ($record) => 'peritajes/documentos/' . ($record->peritaje_id))
                ->preserveFilenames()
                ->openable()
                ->downloadable(),

            Textarea::make('observaciones')
                ->label('Observaciones')
                ->rows(3),
        ])->columns(2);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('peritaje.id')->label('Peritaje')->sortable(),
                TextColumn::make('documento.nombre')->label('Documento')->searchable()->sortable(),

                BadgeColumn::make('estado')
                    ->label('Estado')
                    ->colors([
                        'warning' => 'pendiente',
                        'success' => 'aprobado',
                        'danger'  => 'rechazado',
                    ])
                    ->sortable(),

                TextColumn::make('fecha_recepcion')->label('Recepción')->date('d/m/Y')->sortable(),

                TextColumn::make('archivo')
                    ->label('Archivo')
                    ->formatStateUsing(fn ($state) => $state ? 'Ver/Descargar' : '—')
                    ->url(fn ($record) => $record->archivo ? \Storage::url($record->archivo) : null, true)
                    ->openUrlInNewTab(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('estado')
                    ->label('Estado')
                    ->options([
                        'pendiente' => 'Pendiente',
                        'aprobado'  => 'Aprobado',
                        'rechazado' => 'Rechazado',
                    ]),
                Tables\Filters\SelectFilter::make('peritaje_id')
                    ->relationship('peritaje', 'id')
                    ->label('Peritaje'),
                Tables\Filters\SelectFilter::make('documento_id')
                    ->relationship('documento', 'nombre')
                    ->label('Documento'),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('id', 'desc');
    }

    public static function getPages(): array
    {
        // Normalmente no se usa navegación directa
        return [
            'index'  => Pages\ListChecklistDocumentos::route('/'),
            'create' => Pages\CreateChecklistDocumento::route('/create'),
            'edit'   => Pages\EditChecklistDocumento::route('/{record}/edit'),
        ];
    }
}
