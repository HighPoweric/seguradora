<?php

namespace App\Filament\Resources;

// Importamos las clases necesarias para construir el recurso
use App\Filament\Resources\PeritoResource\Pages;
use App\Models\Perito;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

// Definimos el recurso de Filament para el modelo Perito
class PeritoResource extends Resource
{
    // Especificamos el modelo Eloquent al que está vinculado este recurso
    protected static ?string $model = Perito::class;

    // Ícono que se mostrará en el menú de navegación de Filament
    protected static ?string $navigationIcon = 'heroicon-o-user-group';

    // Texto que se mostrará como etiqueta del recurso en el menú
    protected static ?string $navigationLabel = 'Peritos';

    /**
     * Define el formulario para crear o editar registros de peritos.
     * Este formulario se utiliza en las páginas CreatePerito y EditPerito.
     */
    public static function form(Form $form): Form
    {
        return $form
            ->schema([ // Esquema del formulario: define los campos y sus reglas
                Forms\Components\TextInput::make('nombre') // Campo para el nombre del perito
                    ->required() // Obligatorio
                    ->maxLength(255), // Longitud máxima de 255 caracteres

                Forms\Components\TextInput::make('apellido') // Campo para el apellido
                    ->required()
                    ->maxLength(255),

                Forms\Components\TextInput::make('telefono') // Campo para el teléfono
                    ->tel() // Input tipo teléfono
                    ->maxLength(255),

                Forms\Components\TextInput::make('email') // Campo para el email
                    ->email() // Valida que sea un correo electrónico válido
                    ->required()
                    ->unique(ignoreRecord: true) // El email debe ser único en la tabla, ignorando el actual al editar
                    ->maxLength(255),
            ]);
    }

    /**
     * Define la tabla que se muestra en la vista principal (ListPeritos).
     * Aquí se configuran las columnas visibles, sus propiedades y acciones disponibles.
     */
    public static function table(Table $table): Table
    {
        return $table
            ->columns([ // Definimos qué columnas se verán en la tabla
                Tables\Columns\TextColumn::make('nombre') // Columna del nombre
                    ->searchable() // Permite buscar por este campo
                    ->sortable(), // Permite ordenar por este campo

                Tables\Columns\TextColumn::make('apellido') // Columna del apellido
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('telefono') // Teléfono, solo se puede buscar
                    ->searchable(),

                Tables\Columns\TextColumn::make('email') // Email, también se puede ordenar
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('created_at') // Fecha de creación del registro
                    ->dateTime() // Formato fecha y hora
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true), // El usuario puede ocultarla si quiere

                Tables\Columns\TextColumn::make('updated_at') // Fecha de última actualización
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                // Aquí podrías agregar filtros personalizados si los necesitas (por ejemplo, por estado, fecha, etc.)
            ])
            ->actions([
                Tables\Actions\EditAction::make(), // Botón de edición por fila
                Tables\Actions\DeleteAction::make(), // Botón de eliminar por fila
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([ // Acciones por lote
                    Tables\Actions\DeleteBulkAction::make(), // Eliminar varios registros a la vez
                ]),
            ]);
    }

    /**
     * Define las páginas (rutas internas de Filament) que se habilitan para este recurso.
     * Cada una corresponde a una acción CRUD (listar, crear, editar).
     */
    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPeritos::route('/'), // Página de lista de registros (ruta: /admin/peritos)
            'create' => Pages\CreatePerito::route('/create'), // Página para crear un nuevo perito
            'edit' => Pages\EditPerito::route('/{record}/edit'), // Pági  na para editar un registro existente
        ];
    }
}
