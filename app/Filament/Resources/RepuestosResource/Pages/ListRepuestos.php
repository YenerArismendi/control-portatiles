<?php

namespace App\Filament\Resources\RepuestosResource\Pages;

use App\Filament\Resources\RepuestosResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListRepuestos extends ListRecords
{
    protected static string $resource = RepuestosResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
