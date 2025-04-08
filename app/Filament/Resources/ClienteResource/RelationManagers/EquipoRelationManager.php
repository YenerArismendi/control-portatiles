<?php

namespace App\Filament\Resources\ClienteResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Actions\Action;
use Filament\Tables\Table;


class EquipoRelationManager extends RelationManager
{
    protected static string $relationship = 'equipo';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('marca')
                    ->required()
                    ->maxLength(255),
                Forms\Components\Select::make('tipo_equipo')
                    ->options([
                        'Portatil' => 'Portatil',
                        'Mesa' => 'Mesa',
                        'impresora' => 'impresora',
                    ]),
                Forms\Components\TextInput::make('modelo')
                    ->maxLength(255),
                Forms\Components\TextInput::make('procesador')
                    ->maxLength(255),
                Forms\Components\TextInput::make('ram')
                    ->maxLength(255),
                Forms\Components\TextInput::make('almacenamiento')
                    ->maxLength(255),
                Forms\Components\TextInput::make('sistema_operativo')
                    ->maxLength(255),
                Forms\Components\Select::make('cargador')
                    ->options([
                        '0' => 'Si',
                        '1' => 'No',
                    ]),
                Forms\Components\Select::make('entregado')
                    ->options([
                        '0' => 'No',
                        '1' => 'Si',
                    ]),
                Forms\Components\TextInput::make('detalles')
                    ->maxLength(255),
                Forms\Components\Repeater::make('servicios')
                    ->relationship()
                    ->schema([
                        Forms\Components\Grid::make(12)
                            ->schema([
                                Forms\Components\DatePicker::make('fecha_reparacion')
                                    ->required()
                                    ->columnSpan(6),
                                Forms\Components\Select::make('tipo_servicio')
                                    ->options([
                                        '0' => 'Mantenimiento preventivo',
                                        '1' => 'Mantenimiento correctivo'
                                    ])
                                    ->required()
                                    ->columnSpan(6),
                                Forms\Components\TextInput::make('tareas_realizadas')
                                    ->maxLength(255)
                                    ->columnSpan(6),
                                Forms\Components\TextInput::make('tecnico_responsable')
                                    ->maxLength(255)
                                    ->required()
                                    ->columnSpan(6),
                                Forms\Components\TextInput::make('repuestos_usados')
                                    ->maxLength(255)
                                    ->columnSpan(6),
                                Forms\Components\Select::make('estado_final')
                                    ->options([
                                        '0' => 'Funcional',
                                        '1' => 'Devuelto sin funcionar'
                                    ])
                                    ->required()
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
                            ]),
                    ])
                    ->columnSpan('full'),
            ]);

    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('detalles')
            ->columns([
                Tables\Columns\TextColumn::make('marca')
                    ->searchable(),
                Tables\Columns\TextColumn::make('tipo_equipo'),
                Tables\Columns\TextColumn::make('modelo'),
                Tables\Columns\TextColumn::make('procesador'),
                Tables\Columns\TextColumn::make('ram')
                    ->formatStateUsing(fn($state) => $state . 'GB'),
                Tables\Columns\TextColumn::make('almacenamiento')
                    ->formatStateUsing(function ($state) {
                        if ($state >= 1000) {
                            return ($state / 1000) . 'TB';
                        }
                        return $state . 'GB';
                    }),
                Tables\Columns\TextColumn::make('sistema_operativo'),
                Tables\Columns\TextColumn::make('cargador')
                    ->formatStateUsing(function ($state) {
                        return $state == 1 ? 'No' : 'Si';
                    })
                    ->badge()
                    ->color(fn($state) => ($state == 1 ? 'danger' : 'success')),
                Tables\Columns\TextColumn::make('entregado')
                    ->formatStateUsing(function ($state) {
                        return $state == 1 ? 'Si' : 'No';
                    })
                    ->badge()
                    ->color(fn($state) => ($state == 1 ? 'success' : 'danger')),
                Tables\Columns\TextColumn::make('detalles'),
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
                Action::make('descargar_pdf_modal')
                    ->label('Descargar PDF')
                    ->icon('heroicon-o-document-arrow-down')
                    ->modalHeading('Selecciona un servicio para descargar el PDF')
                    ->modalSubmitAction(false) // No botón "Submit" del modal
                    ->modalContent(function ($record) {
                        return view('pdf.pdf-selector-modal', [
                            'equipo' => $record,
                            'servicios' => $record->servicios, // relación
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
