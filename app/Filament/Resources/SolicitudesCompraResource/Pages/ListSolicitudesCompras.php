<?php

namespace App\Filament\Resources\SolicitudesCompraResource\Pages;

use App\Filament\Resources\SolicitudesCompraResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListSolicitudesCompras extends ListRecords
{
    protected static string $resource = SolicitudesCompraResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
