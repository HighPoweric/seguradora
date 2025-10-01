<?php

namespace App\Filament\Resources;
use Illuminate\Support\Facades\Schema;
use App\Models\Documento;

use App\Filament\Resources\PeritajeResource\Pages;
use App\Models\Peritaje;
use Filament\Forms\Form;
use Filament\Forms\Components\{TextInput, Select, DatePicker};
use Filament\Resources\Resource;
use Filament\Tables\Table;
use Filament\Tables\Columns\{TextColumn, BadgeColumn};
use Filament\Tables\Actions;
use Filament\Tables\Filters;
use Illuminate\Database\Eloquent\Builder;
use Filament\Tables\Actions\Action;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Mail;
use App\Mail\SiniestroPendienteMail;
use App\Jobs\ReenviarCorreoPeritajeJob;

class PeritajeResource extends Resource
{
    protected static ?string $model = Peritaje::class;

    protected static ?string $navigationIcon  = 'heroicon-o-clipboard-document-check';
    protected static ?string $navigationLabel = 'Peritajes';
    protected static ?string $pluralModelLabel = 'Peritajes';
    protected static ?string $modelLabel = 'Peritaje';
    protected static ?string $navigationGroup = 'Gestión de Casos';

    public static function getSlug(): string
    {
        return 'peritajes';
    }

    /** Mueve los withCount aquí (NO en table()->modifyQueryUsing) */
    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->withCount([
                'checklistTareas as tareas_total',
                'checklistTareas as tareas_completadas' => fn ($q) => $q->where('estado', 'completada'),
                'checklistDocumentos as docs_total',
                'checklistDocumentos as docs_cargados' => fn ($q) => $q->where('cargado', true),
            ]);
    }

    public static function form(Form $form): Form
    {
        return $form->schema([
            TextInput::make('solicitante')->label('Nombre del Solicitante')->required()->maxLength(255),

            Select::make('siniestro_id')
                ->label('Siniestro')
                ->relationship('siniestro', 'id_interno')
                ->searchable()->preload()->required(),

            Select::make('perito_id')
                ->label('Perito')
                ->relationship('perito', 'nombre')
                ->searchable()->preload()->required(),

            DatePicker::make('fecha_siniestro')
                ->label('Fecha del Siniestro')
                ->required()->native(false)->displayFormat('d/m/Y')->closeOnDateSelection(),
            Select::make('documentos')
                ->label('Documentos requeridos')
                ->relationship('documentos', 'nombre')
                ->multiple()
                ->preload()
                ->searchable()
                ->helperText('Los documentos obligatorios se preseleccionan al crear.')
                ->afterStateHydrated(function (Select $component, $state, ?\App\Models\Peritaje $record) {
                    // Solo en CREAR (cuando no existe $record)
                    if ($record) {
                        return;
                    }

                    // Evita error si aún no migras la columna:
                    if (! Schema::hasColumn('documentos', 'obligatorio')) {
                        return;
                    }

                    // IDs de documentos obligatorios:
                    $ids = Documento::where('obligatorio', true)->pluck('id')->all();

                    // Si el estado viene vacío, pre-cárgalo:
                    if (empty($state)) {
                        $component->state($ids);
                    }
                }),

        ]);
    }
    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('solicitante')->label('Solicitante')->sortable()->searchable(),
                TextColumn::make('siniestro.id_interno')->label('ID Siniestro')->sortable()->badge(),
                TextColumn::make('perito.nombre')->label('Perito')->sortable()->searchable(),
                TextColumn::make('fecha_siniestro')->label('Fecha Siniestro')->date('d/m/Y')->sortable(),
                BadgeColumn::make('avance_tareas')
                    ->label('Avance tareas')
                    ->getStateUsing(fn (Peritaje $record) =>
                        ($record->tareas_total ?? 0)
                            ? intdiv(($record->tareas_completadas ?? 0) * 100, $record->tareas_total)
                            : 0
                    )
                    ->formatStateUsing(fn ($state) => $state . '%')
                    ->colors([
                        'success' => fn ($state) => $state >= 100,
                        'info'    => fn ($state) => $state >= 50 && $state < 100,
                        'warning' => fn ($state) => $state < 50,
                    ]),
                BadgeColumn::make('avance_global')
                    ->label('Avance global')
                    ->getStateUsing(function (Peritaje $record) {
                        $hechos = (int) ($record->tareas_completadas ?? 0) + (int) ($record->docs_cargados ?? 0);
                        $total  = (int) ($record->tareas_total ?? 0) + (int) ($record->docs_total ?? 0);
                        return $total ? intdiv($hechos * 100, $total) : 0;
                    })
                    ->formatStateUsing(fn ($state) => $state . '%')
                    ->colors([
                        'success' => fn ($state) => $state >= 100,
                        'info'    => fn ($state) => $state >= 50 && $state < 100,
                        'warning' => fn ($state) => $state < 50,
                    ]),
            ])
            ->filters([
                Filters\Filter::make('ultimos_30_dias')
                    ->label('Últimos 30 días')
                    ->query(fn (Builder $query) => $query->whereDate('fecha_siniestro', '>=', now()->subDays(30))),
                Filters\SelectFilter::make('perito_id')->label('Perito')->relationship('perito', 'nombre'),
                Filters\SelectFilter::make('siniestro_id')->label('Siniestro')->relationship('siniestro', 'id_interno'),
            ])
            ->actions([
                Actions\EditAction::make(),

                Action::make('iniciar')
                    ->label('Iniciar peritaje')
                    ->icon('heroicon-o-play')
                    ->color('success')
                    ->requiresConfirmation()
                    ->action(function (Peritaje $record) {
                        $siniestro = $record->siniestro;

                        if (! $siniestro || empty($siniestro->correo_contacto)) {
                            Notification::make()
                                ->title('No se puede iniciar')
                                ->body('El siniestro no tiene correo de contacto.')
                                ->danger()
                                ->send();
                            return;
                        }

                        // 1) Enviar correo inicial
                        Mail::to($siniestro->correo_contacto)
                            ->send(new SiniestroPendienteMail($siniestro));

                        // 2) Programar reenvío (1 min en pruebas; luego addHours(24))
                        ReenviarCorreoPeritajeJob::dispatch($siniestro->id)
                            ->onConnection(config('queue.default')) // p.ej. "database"
                            ->onQueue('default')
                            ->delay(now()->addMinute());

                        Notification::make()
                            ->title('Peritaje iniciado')
                            ->body('Correo enviado y reenvío programado en 1 minuto.')
                            ->success()
                            ->send();
                    }),
            ])
            ->bulkActions([
                Actions\BulkActionGroup::make([
                    Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('fecha_siniestro', 'desc');
    }

    public static function getRelations(): array
    {
        return [
            \App\Filament\Resources\PeritajeResource\RelationManagers\DocumentosRelationManager::class, // <-- nuevo
            \App\Filament\Resources\PeritajeResource\RelationManagers\ChecklistDocumentosRelationManager::class,
            \App\Filament\Resources\PeritajeResource\RelationManagers\ChecklistTareasRelationManager::class,

        ];
    }

    public static function getPages(): array
    {
        return [
            'index'  => Pages\ListPeritajes::route('/'),
            'create' => Pages\CreatePeritaje::route('/create'),
            'edit'   => Pages\EditPeritaje::route('/{record}/edit'),
        ];
    }
}
