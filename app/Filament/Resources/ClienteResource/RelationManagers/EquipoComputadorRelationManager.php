<?php

namespace App\Filament\Resources\ClienteResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class EquipoComputadorRelationManager extends RelationManager
{
    protected static string $relationship = 'equipoComputador';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('marca')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('modelo')
                    ->maxLength(255),
                Forms\Components\Select::make('tipo')
                    ->options([
                        'Escritorio' => 'Escritorio',
                        'Todo en uno' => 'Todo en uno',
                        'Portatil' => 'Portatil',
                    ])
                    ->required(),
                Forms\Components\Select::make('sistema_operativo')
                    ->options([
                        'Windows' => 'Windows',
                        'Linux' => 'Linux',
                        'macOs' => 'macOs',
                        'ChoreOs' => 'ChoreOs',
                    ]),
                Forms\Components\TextInput::make('procesador')
                    ->maxLength(255),
                Forms\Components\TextInput::make('ram')
                    ->maxLength(255),
                Forms\Components\Select::make('tipo_disco')
                    ->options([
                        'HDD' => 'HDD',
                        'SSD' => 'SSD',
                        'SSHD' => 'SSHD',
                    ]),
                Forms\Components\TextInput::make('capacidad_disco')
                    ->maxlength(255),
                Forms\Components\TextInput::make('fallo_reportado')
                    ->required()
                    ->maxlength(255),
                Forms\Components\TextInput::make('diagnostico_tecnico')
                    ->maxlength(255),
                Forms\Components\DatePicker::make('fecha_entrega')
                    ->visible(fn(Forms\Get $get, ?Model $record) => $record !== null),
                Forms\Components\Select::make('cargador')
                    ->options([
                        '1' => 'Si',
                        '0' => 'No',
                    ]),
                Forms\Components\Select::make('estado')
                    ->options([
                        '0' => 'Recibido',
                        '1' => 'En revisión',
                        '2' => 'Entregada',
                    ]),
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
                Tables\Columns\TextColumn::make('serie'),
                Tables\Columns\TextColumn::make('sistema_operativo'),
                Tables\Columns\TextColumn::make('procesador'),
                Tables\Columns\TextColumn::make('ram'),
                Tables\Columns\TextColumn::make('tipo_disco'),
                Tables\Columns\TextColumn::make('capacidad_disco'),
                Tables\Columns\TextColumn::make('fallo_reportado')
                    ->limit(20)
                    ->tooltip(fn($record) => $record->fallo_reportado),
                Tables\Columns\TextColumn::make('diagnostico_tecnico')
                    ->limit(20)
                    ->tooltip(fn($record) => $record->fallo_reportado),
                Tables\Columns\TextColumn::make('fecha_entrega'),
                Tables\Columns\TextColumn::make('cargador')
                    ->formatStateUsing(function ($state) {
                        return match ($state) {
                            0 => 'No',
                            1 => 'Si',
                        };
                    }),
                Tables\Columns\TextColumn::make('estado')
                    ->formatStateUsing(function ($state) {
                        return match ($state) {
                            0 => 'Recibido',
                            1 => 'En revisión',
                            2 => 'Entregada',
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
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}
