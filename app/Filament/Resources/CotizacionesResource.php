<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CotizacionesResource\Pages;
use App\Models\Cotizacion;
use App\Models\EquipoComputador;
use App\Models\EquipoImpresora;
use Filament\Forms;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\Action;
use Filament\Tables\Table;
use Barryvdh\DomPDF\Facade\Pdf;

class CotizacionesResource extends Resource
{
    protected static ?string $model = Cotizacion::class;

    protected static ?string $navigationIcon = 'heroicon-o-document-text';
    protected static ?string $navigationLabel = 'Cotizacion';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('numero')
                    ->label('Número')
                    ->disabled()
                    ->default(function () {
                        $last = \App\Models\Cotizacion::orderBy('id', 'desc')->first();
                        $nextNumber = $last ? ((int)filter_var($last->numero, FILTER_SANITIZE_NUMBER_INT)) + 1 : 1;
                        return 'COT' . str_pad($nextNumber, 4, '0', STR_PAD_LEFT);
                    }),
                Forms\Components\Select::make('cliente_id')
                    ->label('Cliente')
                    ->relationship('cliente', 'nombre')
                    ->searchable()
                    ->required()
                    ->reactive(),
                Forms\Components\Select::make('equipo')
                    ->label('Equipo')
                    ->required()
                    ->reactive()
                    ->options(function ($get, $state, $livewire) {
                        // Obtener cliente actual
                        $clienteId = $get('cliente_id') ?? $livewire->record?->cliente_id;

                        if (!$clienteId) {
                            return [];
                        }

                        $portatiles = \App\Models\EquipoComputador::where('cliente_id', $clienteId)->get();
                        $impresoras = \App\Models\EquipoImpresora::where('cliente_id', $clienteId)->get();

                        $options = [];

                        foreach ($portatiles as $p) {
                            $options["portatil-{$p->id}"] = 'Portátil - ' . $p->modelo;
                        }

                        foreach ($impresoras as $i) {
                            $options["impresora-{$i->id}"] = 'Impresora - ' . $i->modelo;
                        }

                        return $options;
                    })
                    ->afterStateHydrated(function ($set, $record) {
                        if (!$record) return;

                        $tipo = $record->equipo_type;
                        $id = $record->equipo_id;

                        if ($tipo === \App\Models\EquipoComputador::class) {
                            $set('equipo', "portatil-{$id}");
                        }

                        if ($tipo === \App\Models\EquipoImpresora::class) {
                            $set('equipo', "impresora-{$id}");
                        }
                    })
                    ->afterStateUpdated(function ($set, $state) {
                        if (!$state) return;

                        [$tipo, $id] = explode('-', $state);

                        $set('equipo_type', $tipo === 'portatil' ? \App\Models\EquipoComputador::class : \App\Models\EquipoImpresora::class);
                        $set('equipo_id', $id);
                    }),

                Hidden::make('equipo_id')->dehydrated(),
                Hidden::make('equipo_type')->dehydrated(),

                Forms\Components\DatePicker::make('fecha')
                    ->label('Fecha')
                    ->required(),

                Forms\Components\Textarea::make('diagnostico')
                    ->label('Diagnóstico'),

                Forms\Components\Select::make('estado')
                    ->options([
                        'pendiente' => 'Pendiente',
                        'aceptada' => 'Aceptada',
                        'rechazada' => 'Rechazada',
                    ])
                    ->default('pendiente')
                    ->required(),

                // Campo TOTAL reactivo y automático
                Forms\Components\TextInput::make('total')
                    ->numeric()
                    ->prefix('$')
                    ->default(0)
                    ->disabled()
                    ->dehydrated()
                    ->reactive(),

                Forms\Components\Repeater::make('items')
                    ->relationship('items')
                    ->columnSpanFull()
                    ->schema([
                        Select::make('repuesto_id')
                            ->label('Repuesto/Servicio')
                            ->relationship('repuesto', 'nombre')
                            ->searchable()
                            ->preload()
                            ->required()
                            ->reactive()
                            ->afterStateUpdated(function ($state, callable $set) {
                                $repuesto = \App\Models\Repuestos::find($state);
                                if ($repuesto) {
                                    $set('precio_unitario', $repuesto->precio_sugerido);
                                }
                            }),

                        TextInput::make('cantidad')
                            ->numeric()
                            ->default(0)
                            ->reactive()
                            ->afterStateUpdated(function ($state, callable $set, callable $get) {
                                $set('subtotal', $state * $get('precio_unitario'));

                                // Actualiza el total sumando subtotales
                                $items = $get('../../items');
                                $total = collect($items)->sum(fn($item) => (float)($item['subtotal'] ?? 0));
                                $set('../../total', $total);
                            }),

                        TextInput::make('precio_unitario')
                            ->numeric()
                            ->prefix('$')
                            ->required()
                            ->reactive()
                            ->afterStateUpdated(function ($state, callable $set, callable $get) {
                                $set('subtotal', $get('cantidad') * $state);

                                // Actualiza el total sumando subtotales
                                $items = $get('../../items');
                                $total = collect($items)->sum(fn($item) => (float)($item['subtotal'] ?? 0));
                                $set('../../total', $total);
                            }),

                        TextInput::make('subtotal')
                            ->numeric()
                            ->prefix('$')
                            ->disabled()
                            ->dehydrated(),

                        Forms\Components\Textarea::make('descripcion')
                            ->rows(3)
                            ->required()
                            ->extraAttributes([
                                'oninput' => 'this.style.height = ""; this.style.height = this.scrollHeight + "px"',
                                'class' => 'overflow-hidden resize-none',
                            ]),
                    ])
                    ->createItemButtonLabel('Agregar repuesto/servicio')
                    ->columns(5)
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('numero')->label('Número de Cotización'),
                Tables\Columns\TextColumn::make('cliente.nombre')->label('Cliente'),
                Tables\Columns\TextColumn::make('fecha')->date(),
                Tables\Columns\TextColumn::make('estado')->badge()->colors([
                    'gray' => 'pendiente',
                    'success' => 'aceptada',
                    'danger' => 'rechazada',
                ]),
                Tables\Columns\TextColumn::make('total')->money('COP'),

            ])
            ->query(
                static::getEloquentQuery()
                    ->orderByRaw("FIELD(estado, 'pendiente', 'aceptada', 'rechazada')")
            )
            ->filters([])
            ->actions([
                Tables\Actions\EditAction::make(),
                Action::make('descargar_pdf')
                    ->icon('heroicon-o-document-arrow-down')
                    ->label('Descargar PDF')
                    ->url(fn(Cotizacion $record) => route('cotizaciones.pdf', $record))
                    ->openUrlInNewTab()
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
            'index' => Pages\ListCotizaciones::route('/'),
            'create' => Pages\CreateCotizaciones::route('/create'),
            'edit' => Pages\EditCotizaciones::route('/{record}/edit'),
        ];
    }
}
