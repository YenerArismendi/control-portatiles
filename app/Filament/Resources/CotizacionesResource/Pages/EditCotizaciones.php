<?php

namespace App\Filament\Resources\CotizacionesResource\Pages;

use App\Filament\Resources\CotizacionesResource;
use Filament\Actions;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\EditRecord;

class EditCotizaciones extends EditRecord
{
    protected static string $resource = CotizacionesResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    public function render(): \Illuminate\Contracts\View\View
    {
        if (session()->has('servicio_creado')) {
            Notification::make()
                ->title('¡Éxito!')
                ->body(session('servicio_creado'))
                ->success()
                ->send();

            // Limpiamos la sesión para que no se repita la notificación al refrescar
            session()->forget('servicio_creado');
        }

        return parent::render();
    }
}
