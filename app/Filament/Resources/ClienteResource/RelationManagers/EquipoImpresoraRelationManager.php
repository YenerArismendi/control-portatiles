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
                Forms\Components\Select::make('tipo')
                    ->options([
                        'Impresora de inyección de tinta' => 'Impresora de inyección de tinta',
                        'Impresora láser' => 'Impresora láser',
                    ])
                    ->required(),
                Forms\Components\TextInput::make('fallo_reportado')
                    ->required()
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
                Tables\Columns\TextColumn::make('fallo_reportado'),
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
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}
