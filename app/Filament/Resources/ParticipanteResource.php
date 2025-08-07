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
    protected static ?string $model = Participante::class;

    protected static ?string $navigationIcon = 'heroicon-o-user';
    protected static ?string $navigationLabel = 'Participantes';
    protected static ?string $pluralModelLabel = 'Participantes';
    protected static ?string $modelLabel = 'Participante';

    public static function form(Form $form): Form
    {
        return $form->schema([
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
                ->maxLength(20),

            Forms\Components\TextInput::make('email')
                ->label('Correo Electrónico')
                ->email()
                ->maxLength(255),

            Forms\Components\TextInput::make('licencia_conducir')
                ->label('Licencia de Conducir')
                ->maxLength(255),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table->columns([
            Tables\Columns\TextColumn::make('rut')
                ->label('RUT')
                ->sortable()
                ->searchable(),

            Tables\Columns\TextColumn::make('dv')
                ->label('DV'),

            Tables\Columns\TextColumn::make('nombre')
                ->sortable()
                ->searchable(),

            Tables\Columns\TextColumn::make('apellido')
                ->sortable()
                ->searchable(),

            Tables\Columns\TextColumn::make('telefono')
                ->label('Teléfono')
                ->searchable(),

            Tables\Columns\TextColumn::make('email')
                ->label('Correo')
                ->searchable(),

            Tables\Columns\TextColumn::make('licencia_conducir')
                ->label('Licencia'),

            Tables\Columns\TextColumn::make('created_at')
                ->label('Creado')
                ->dateTime()
                ->toggleable(isToggledHiddenByDefault: true),

            Tables\Columns\TextColumn::make('updated_at')
                ->label('Actualizado')
                ->dateTime()
                ->toggleable(isToggledHiddenByDefault: true),
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

    public static function getRelations(): array
    {
        return [
            // Aquí puedes agregar RelationManagers si es necesario
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListParticipantes::route('/'),
            'create' => Pages\CreateParticipante::route('/create'),
            'edit' => Pages\EditParticipante::route('/{record}/edit'),
        ];
    }
}
