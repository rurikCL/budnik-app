<?php

namespace App\Filament\Resources\AprobadoresSolicitudResource\Pages;

use App\Filament\Resources\AprobadoresSolicitudResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateAprobadoresSolicitud extends CreateRecord
{
    protected static string $resource = AprobadoresSolicitudResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['idSolicitudTipo'] = 1;

        return $data;
    }
}
