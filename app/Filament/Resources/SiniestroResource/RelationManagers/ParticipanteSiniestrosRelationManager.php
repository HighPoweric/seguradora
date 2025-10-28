<?php

namespace App\Filament\Resources\SiniestroResource\RelationManagers;

use App\Models\ParticipanteSiniestro;
use App\Models\Participante;
use Closure;
use Filament\Forms;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Forms\Form;
use Filament\Forms\Components\Actions\Action;
use Filament\Forms\Components\Component;
use Filament\Forms\Components\Fieldset;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\TextInput;
use Filament\Tables;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Resources\RelationManagers\RelationManager;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Actions\CreateAction;
use GuzzleHttp\Promise\Create;

class ParticipanteSiniestrosRelationManager extends RelationManager
{
    protected static string $relationship = 'participanteSiniestros';
    
    public function form(Form $form): Form
    {
        return $form
            ->schema([
                // Campo "Oculto" para o ID do participante
                // Precisamos disso para a validação
                Select::make('participante_id')
                    ->relationship('participante', 'nombre')
                    ->label('Participante')
                    ->searchable()
                    ->required()
                    ->preload()
                    ->native(false)
                    ->rules([$this->uniqueRule('participante_id')])
                    ->disabled(fn ($context) => $context === 'edit')
                    ->suffixAction(
                        Action::make('createParticipante')
                            ->label('Crear Nuevo Participante')
                            ->icon('heroicon-o-plus')
                            ->disabled(fn ($context) => $context === 'edit')
                            ->form(Participante::getFormSchema())
                            ->action(function (array $data, Set $set) {
                                $participante = Participante::create($data);
                                $set('participante_id', $participante->id);
                            }))        
                    ,
                Fieldset::make('Roles del Participante')
                ->schema([
                    // Checkboxes para los roles
                    Checkbox::make('asegurado')
                        ->label('Asegurado')
                        ->default(false)
                        ->rules([$this->uniqueRule('asegurado')]),
                    
                    Checkbox::make('conductor')
                        ->label('Conductor')
                        ->default(false)
                        ->rules([$this->uniqueRule('conductor')]),

                    Checkbox::make('contratante')
                        ->label('Contratante')
                        ->default(false)
                        ->rules([$this->uniqueRule('contratante')]),

                    Checkbox::make('denunciante')
                        ->label('Denunciante')
                        ->default(false)
                        ->rules([$this->uniqueRule('denunciante')]),
                ]),

                TextInput::make('otro_rol')
                    ->label('Otro Rol (Testigo, Carabinero, etc.)')
                    ->maxLength(255),
                
                Checkbox::make('crear_entrevista')
                    ->label('Crear entrevista para este participante?')
                    ->default(true)
                    ->required(false)
                    ->visible (fn ($context) => $context === 'create'),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('nombre')
            ->columns([
                TextColumn::make('participante_nombre_completo_rut')
                    ->label('Participante')
                    ->sortable()
                    ->searchable()
                    ->getStateUsing(fn ($record) => $record->participante->nombre_completo_rut),
                IconColumn::make('asegurado')->label('Asegurado')->boolean()->sortable(),
                IconColumn::make('conductor')->label('Conductor')->boolean()->sortable(),
                IconColumn::make('contratante')->label('Contratante')->boolean()->sortable(),
                IconColumn::make('denunciante')->label('Denunciante')->boolean()->sortable(),
                TextColumn::make('otro_rol')->label('Otro Rol')->sortable()->searchable(),
            ])
            ->defaultSort(function (Builder $query) {
                return $query
                    ->orderBy('asegurado', 'desc')
                    ->orderBy('conductor', 'desc')
                    ->orderBy('contratante', 'desc')
                    ->orderBy('denunciante', 'desc');
            })
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make()
                ->after(function (Model $record, array $data) {
                    if (!empty($data['crear_entrevista'])) {
                        \App\Models\Entrevista::create([
                            'participante_siniestro_id' => $record->id,
                            'estado'          => 'no iniciada',
                        ]);
                    }
                }),
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

    private function uniqueRule(string $field): Closure
    {
        return function (Get $get, Component $component) use ($field) {
            return function (string $attribute, $value, Closure $fail) use ($field, $component) {
                // Só valida se o usuário marcou como 'true'
                $bool_field = in_array($field, ["asegurado", "conductor", "contratante", "denunciante"]);
                if ($bool_field && $value !== true) {
                    return;
                }
                $msg_val = $bool_field ? "Ya existe un '{$field}' para este siniestro. Solo puede haber uno." : "El participante ya está asociado a este siniestro.";
                
                // Pega o ID do Siniestro atual
                $siniestroId = $this->getOwnerRecord()->id;
                //pega o id do participante siniestro que  esta sendo editado
                $id_edit = $component->getContainer()->getRecord()?->id;

                //DD( $value, $siniestroId, $field, $component);
                if ($bool_field){
                    $query = \App\Models\Siniestro::find($siniestroId)
                    ->participantes()
                    ->wherePivot($field, true);
                } else {
                    //se não é um campo booleano é o campo participante_id que não pode estar duplicado tambem
                    $query = \App\Models\Siniestro::find($siniestroId)
                    ->participantes()
                    ->where('participante_id', $value);
                }
                //se estiver editando, ignorar o proprio registro
                if (isset($id_edit)) {
                    $query->wherePivot('id', '!=', $id_edit);
                }
                //DD($query->toSql(), $query->getBindings());
                if ($query->exists()) {
                    $fail("Ya existe un '{$field}' para este siniestro. Solo puede haber uno.");
                }
            };
        };
    }
}
