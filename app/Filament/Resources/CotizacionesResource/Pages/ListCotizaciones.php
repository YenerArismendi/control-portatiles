<?php

namespace App\Filament\Resources\CotizacionesResource\Pages;

use App\Filament\Resources\CotizacionesResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListCotizaciones extends ListRecords
{
    protected static string $resource = CotizacionesResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
