<?php

namespace App\Filament\Resources;

use App\Filament\Resources\RepuestosResource\Pages;
use App\Filament\Resources\RepuestosResource\RelationManagers;
use App\Models\Repuestos;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class RepuestosResource extends Resource
{
    protected static ?string $model = Repuestos::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('nombre'),
                Forms\Components\TextInput::make('descripcion'),
                Forms\Components\TextInput::make('precio_sugerido')
                    ->numeric()
                    ->prefix('$')
                    ->default(0),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('nombre'),
                Tables\Columns\TextColumn::make('descripcion'),
                Tables\Columns\TextColumn::make('precio_sugerido')
                    ->money('COP', true),
            ])
            ->filters([
                //
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
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListRepuestos::route('/'),
            'create' => Pages\CreateRepuestos::route('/create'),
            'edit' => Pages\EditRepuestos::route('/{record}/edit'),
        ];
    }
}
