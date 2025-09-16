<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ChecklistTareaResource\Pages;
use App\Models\ChecklistTarea;
use App\Models\Peritaje;
use App\Models\Tarea;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Forms\Components\{Select, DatePicker, FileUpload, Textarea};
use Filament\Tables\Columns\{TextColumn, BadgeColumn};

class ChecklistTareaResource extends Resource
{
    protected static ?string $model = ChecklistTarea::class;

    // Ocultar del nav
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

            Select::make('tarea_id')
                ->label('Tarea')
                ->options(fn () => Tarea::orderBy('orden')->pluck('nombre', 'id'))
                ->searchable()
                ->required(),

            Select::make('estado')
                ->label('Estado')
                ->options([
                    'pendiente' => 'Pendiente',
                    'ok'        => 'OK',
                    'no_aplica' => 'No aplica',
                ])
                ->required(),

            DatePicker::make('fecha')
                ->label('Fecha')
                ->native(false),

            FileUpload::make('evidencia')
                ->label('Evidencia')
                ->directory('peritajes/tareas')
                ->preserveFilenames()
                ->openable()
                ->downloadable(),

            Textarea::make('notas')
                ->label('Notas')
                ->rows(3),
        ])->columns(2);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('peritaje.id')->label('Peritaje')->sortable(),
                TextColumn::make('tarea.nombre')->label('Tarea')->searchable()->sortable(),

                BadgeColumn::make('estado')
                    ->label('Estado')
                    ->colors([
                        'warning' => 'pendiente',
                        'success' => 'ok',
                        'gray'    => 'no_aplica',
                    ])
                    ->sortable(),

                TextColumn::make('fecha')->label('Fecha')->date('d/m/Y')->sortable(),

                TextColumn::make('evidencia')
                    ->label('Evidencia')
                    ->formatStateUsing(fn ($state) => $state ? 'Ver/Descargar' : '—')
                    ->url(fn ($record) => $record->evidencia ? \Storage::url($record->evidencia) : null, true)
                    ->openUrlInNewTab(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('estado')
                    ->label('Estado')
                    ->options([
                        'pendiente' => 'Pendiente',
                        'ok'        => 'OK',
                        'no_aplica' => 'No aplica',
                    ]),
                Tables\Filters\SelectFilter::make('peritaje_id')
                    ->relationship('peritaje', 'id')
                    ->label('Peritaje'),
                Tables\Filters\SelectFilter::make('tarea_id')
                    ->relationship('tarea', 'nombre')
                    ->label('Tarea'),
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
            'index'  => Pages\ListChecklistTareas::route('/'),
            'create' => Pages\CreateChecklistTarea::route('/create'),
            'edit'   => Pages\EditChecklistTarea::route('/{record}/edit'),
        ];
    }
}
