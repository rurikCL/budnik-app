<?php

namespace App\Filament\Resources\SolicitudesCompraResource\Pages;

use App\Filament\Resources\SolicitudesCompraResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Support\Facades\Auth;

class EditSolicitudesCompra extends EditRecord
{
    protected static string $resource = SolicitudesCompraResource::class;

    public function getFormActions(): array
    {
        return [];
    }

    protected function getHeaderActions(): array
    {
        return [
            $this->getSaveFormAction()
                ->submit(null)
                ->action(fn() => $this->save()),
            $this->getCancelFormAction(),
        ];
    }
}
