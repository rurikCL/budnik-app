<?php

namespace App\Filament\Resources\SolicitudesCompraResource\Pages;

use App\Filament\Resources\SolicitudesCompraResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Support\Facades\Auth;

class EditSolicitudesCompra extends EditRecord
{
    protected static string $resource = SolicitudesCompraResource::class;


    protected function getHeaderActions(): array
    {
        return [
//            Actions\DeleteAction::make(),
        ];
    }
}
