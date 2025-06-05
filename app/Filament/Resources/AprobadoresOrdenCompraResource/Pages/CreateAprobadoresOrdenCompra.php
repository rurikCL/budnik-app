<?php

namespace App\Filament\Resources\AprobadoresOrdenCompraResource\Pages;

use App\Filament\Resources\AprobadoresOrdenCompraResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateAprobadoresOrdenCompra extends CreateRecord
{
    protected static string $resource = AprobadoresOrdenCompraResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['idSolicitudTipo'] = 2;

        return $data;
    }
}
