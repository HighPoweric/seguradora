<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TareaResource\Pages;
use App\Models\Tarea;
use Filament\Forms\Form;
use Filament\Forms\Components\{TextInput, Textarea};
use Filament\Resources\Resource;
use Filament\Tables\Table;
use Filament\Tables\Columns\{TextColumn};
use Filament\Tables\Actions;
use Filament\Tables\Filters;

class TareaResource extends Resource
{
    protected static ?string $model = Tarea::class;

    protected static ?string $navigationIcon  = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationLabel = 'Tareas';
    protected static ?string $pluralModelLabel = 'Tareas';
    protected static ?string $modelLabel = 'Tarea';
    protected static ?string $navigationGroup = 'Gestión de Casos';

    /** (Opcional) fuerza el slug para garantizar /admin/tareas */
    public static function getSlug(): string
    {
        return 'tareas';
    }

    public static function form(Form $form): Form
    {
        return $form->schema([
            TextInput::make('tarea')
                ->label('Título de la tarea')
                ->required()
                ->maxLength(255)
                ->placeholder('Ej: Llamar a asegurado'),

            Textarea::make('descripcion')
                ->label('Descripción')
                ->rows(6)
                ->maxLength(2000)
                ->placeholder('Detalles, pasos, notas internas…'),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')
                    ->label('#')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('tarea')
                    ->label('Tarea')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('descripcion')
                    ->label('Descripción')
                    ->limit(60),

                TextColumn::make('created_at')
                    ->label('Creado')
                    ->dateTime('d/m/Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                // Filters::Filter::make('...') si luego necesitas
            ])
            ->actions([
                Actions\ViewAction::make(),
                Actions\EditAction::make(),
                Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Actions\BulkActionGroup::make([
                    Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('created_at', 'desc');
    }

    public static function getRelations(): array
    {
        return [
            // RelationManagers si más adelante enlazas ChecklistTarea, etc.
        ];
    }

    public static function getPages(): array
    {
        return [
            'index'  => Pages\ListTareas::route('/'),
            'create' => Pages\CreateTarea::route('/create'),
            'edit'   => Pages\EditTarea::route('/{record}/edit'),
        ];
    }
}
