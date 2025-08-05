<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ParticipanteResource\Pages;
use App\Models\Participante;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class ParticipanteResource extends Resource
{
    // Vinculamos el modelo Eloquent
    protected static ?string $model = Participante::class;

    // Ícono que se mostrará en el panel de navegación de Filament
    protected static ?string $navigationIcon = 'heroicon-o-user';

    // Etiqueta del recurso en el menú
    protected static ?string $navigationLabel = 'Participantes';

    /**
     * Define el formulario de creación/edición de participantes
     */
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('rut')
                    ->label('RUT')
                    ->required()
                    ->maxLength(10)
                    ->unique(ignoreRecord: true),

                Forms\Components\TextInput::make('dv')
                    ->label('Dígito Verificador')
                    ->required()
                    ->maxLength(1),

                Forms\Components\TextInput::make('nombre')
                    ->label('Nombre')
                    ->required()
                    ->maxLength(255),

                Forms\Components\TextInput::make('apellido')
                    ->label('Apellido')
                    ->required()
                    ->maxLength(255),

                Forms\Components\TextInput::make('telefono')
                    ->label('Teléfono')
                    ->tel()
                    ->maxLength(255),

                Forms\Components\TextInput::make('email')
                    ->label('Correo Electrónico')
                    ->email()
                    ->maxLength(255),

                Forms\Components\TextInput::make('licencia_conducir')
                    ->label('Licencia de Conducir')
                    ->maxLength(255),
            ]);
    }

    /**
     * Define las columnas y acciones en la tabla de participantes
     */
    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('rut')
                    ->sortable()
                    ->searchable(),

                Tables\Columns\TextColumn::make('dv'),

                Tables\Columns\TextColumn::make('nombre')
                    ->sortable()
                    ->searchable(),

                Tables\Columns\TextColumn::make('apellido')
                    ->sortable()
                    ->searchable(),

                Tables\Columns\TextColumn::make('telefono')
                    ->searchable(),

                Tables\Columns\TextColumn::make('email')
                    ->searchable(),

                Tables\Columns\TextColumn::make('licencia_conducir')
                    ->label('Licencia'),

                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                // Puedes agregar filtros si lo deseas
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    /**
     * Si tienes relaciones, las defines aquí
     */
    public static function getRelations(): array
    {
        return [];
    }

    /**
     * Define las rutas internas del recurso (listar, crear, editar)
     */
    public static function getPages(): array
    {
        return [
            'index' => Pages\ListParticipantes::route('/'),
            'create' => Pages\CreateParticipante::route('/create'),
            'edit' => Pages\EditParticipante::route('/{record}/edit'),
        ];
    }
}
