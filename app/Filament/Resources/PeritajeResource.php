<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PeritajeResource\Pages;
use App\Models\Peritaje;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Filament\Forms\Components\{TextInput, Select, DatePicker};
use Filament\Tables\Columns\{TextColumn, DateColumn};

class PeritajeResource extends Resource
{
    protected static ?string $model = Peritaje::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationLabel = 'Peritajes';

    public static function form(Form $form): Form
    {
        return $form->schema([
            TextInput::make('solicitante')
                ->label('Nombre del Solicitante')
                ->required(),

            Select::make('siniestro_id')
                ->label('Siniestro')
                ->relationship('siniestro', 'id_interno')
                ->searchable()
                ->required(),

            Select::make('perito_id')
                ->label('Perito')
                ->relationship('perito', 'nombre')
                ->searchable()
                ->required(),

            DatePicker::make('fecha_sinis')
                ->label('Fecha del Siniestro')
                ->required(),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('solicitante')->label('Solicitante')->sortable()->searchable(),
                TextColumn::make('siniestro.id_interno')->label('ID Siniestro')->sortable(),
                TextColumn::make('perito.nombre')->label('Perito')->sortable(),
                DateColumn::make('fecha_sinis')->label('Fecha Siniestro')->sortable(),
            ])
            ->filters([
                // puedes agregar filtros si es necesario
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPeritajes::route('/'),
            'create' => Pages\CreatePeritaje::route('/create'),
            'edit' => Pages\EditPeritaje::route('/{record}/edit'),
        ];
    }
}
