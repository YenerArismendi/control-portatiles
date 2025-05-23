<?php

namespace App\Filament\Resources\ClienteResource\RelationManagers;

use App\Models\Servicio;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Actions\Action;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class EquipoImpresoraRelationManager extends RelationManager
{
    protected static string $relationship = 'equipoImpresora';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('marca')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('modelo')
                    ->maxLength(255),
                Forms\Components\TextInput::make('serie')
                    ->maxLength(255),
                Forms\Components\Select::make('tipo')
                    ->options([
                        'Impresora de inyección de tinta' => 'Impresora de inyección de tinta',
                        'Impresora láser' => 'Impresora láser',
                    ])
                    ->required(),
                Forms\Components\TextInput::make('fallo_reportado')
                    ->required()
                    ->maxlength(255),
                Forms\Components\TextInput::make('diagnostico_tecnico')
                    ->maxlength(255),
                Forms\Components\Select::make('estado')
                    ->options([
                        '0' => 'Recibida',
                        '1' => 'En revisión',
                        '2' => 'Entregada',
                    ]),
                Forms\Components\DatePicker::make('fecha_entrega')
                    ->visible(fn(Forms\Get $get, ?Model $record) => $record !== null),
                Forms\Components\Select::make('cargador')
                    ->options([
                        '1' => 'Si',
                        '0' => 'No',
                    ]),
                Forms\Components\Repeater::make('servicio')
                    ->relationship('servicio')
                    ->schema([
                        Forms\Components\Grid::make(12)
                            ->schema([
                                Forms\Components\Placeholder::make('cotizacion')
                                    ->label('Cotización')
                                    ->content(fn($record) => $record?->cotizacion?->numero ?? 'Sin cotización')
                                    ->columnSpan(6),
                                Forms\Components\TextInput::make('tecnico_responsable')
                                    ->maxLength(255)
                                    ->columnSpan(6),
                                Forms\Components\TextInput::make('fallo_reportado')
                                    ->maxLength(255)
                                    ->columnSpan(6),
                                Forms\Components\TextInput::make('diagnostico')
                                    ->maxLength(255)
                                    ->required()
                                    ->columnSpan(6),
                                Forms\Components\Select::make('estado')
                                    ->options([
                                        '0' => 'Funcional',
                                        '1' => 'Devuelto sin funcionar'
                                    ])
                                    ->required()
                                    ->columnSpan(6),
                                Forms\Components\TextInput::make('descripcion_servicio')
                                    ->maxLength(255)
                                    ->columnSpan(6),
                                Forms\Components\Select::make('garantia')
                                    ->options([
                                        '0' => 'Si',
                                        '1' => 'No'
                                    ])
                                    ->required()
                                    ->columnSpan(6),
                                Forms\Components\TextInput::make('recomendaciones')
                                    ->maxLength(255)
                                    ->columnSpan(6),
                                Forms\Components\TextInput::make('total_servicio')
                                    ->label('Total del servicio')
                                    ->disabled() // lo hace no editable
                                    ->dehydrated(false) // evita que el valor se envíe al guardar
                                    ->formatStateUsing(fn($state) => '$' . number_format($state, 0, ',', '.'))
                                    ->columnSpan(6),
                                Forms\Components\DatePicker::make('fecha_reparacion')
                                    ->columnSpan(6),
                                Forms\Components\DatePicker::make('fecha_entrega')
                                    ->columnSpan(6),
                            ]),


                    ])
                    ->columnSpan('full'),

            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('estado')
            ->columns([
                Tables\Columns\TextColumn::make('marca'),
                Tables\Columns\TextColumn::make('modelo'),
                Tables\Columns\TextColumn::make('tipo'),
                Tables\Columns\TextColumn::make('serie')
                    ->limit(10)
                    ->tooltip(fn($record) => $record->serie),
                Tables\Columns\TextColumn::make('fallo_reportado')
                    ->limit(20)
                    ->tooltip(fn($record) => $record->fallo_reportado),
                Tables\Columns\TextColumn::make('diagnostico_tecnico')
                    ->limit(20)
                    ->tooltip(fn($record) => $record->diagnostico_tecnico),
                Tables\Columns\TextColumn::make('estado')
                    ->formatStateUsing(function ($state) {
                        return match ($state) {
                            0 => 'Recibido',
                            1 => 'En revisión',
                            2 => 'Entregada',
                        };
                    }),
                Tables\Columns\TextColumn::make('fecha_entrega'),
                Tables\Columns\TextColumn::make('cargador')
                    ->formatStateUsing(function ($state) {
                        return match ($state) {
                            0 => 'No',
                            1 => 'Si',
                        };
                    }),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
                Action::make('ver_servicios')
                    ->label('Ver Servicios')
                    ->icon('heroicon-o-document-text')
                    ->modalHeading('Servicios realizados')
                    ->modalSubmitAction(false)
                    ->modalContent(function ($record) {
                        // Obtenemos los servicios para este equipo usando la relación polimórfica
                        $servicios = Servicio::where('equipo_type', get_class($record))
                            ->where('equipo_id', $record->id)
                            ->get();

                        return view('pdf.pdf-selector-modal', [
                            'equipo' => $record,
                            'servicios' => $servicios,
                        ]);
                    }),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}
