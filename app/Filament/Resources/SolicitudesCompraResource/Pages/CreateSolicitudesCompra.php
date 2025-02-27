<?php

namespace App\Filament\Resources\SolicitudesCompraResource\Pages;

use App\Filament\Resources\SolicitudesCompraResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Auth;

class CreateSolicitudesCompra extends CreateRecord
{
    protected static string $resource = SolicitudesCompraResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['IDSolicitante'] = Auth::user()->id;
        $data['IDProveedor'] = 1;

        return $data;
    }
}
