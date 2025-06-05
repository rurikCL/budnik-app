<?php

namespace App\Filament\Resources\AprobadoresOrdenCompraResource\Pages;

use App\Filament\Resources\AprobadoresOrdenCompraResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditAprobadoresOrdenCompra extends EditRecord
{
    protected static string $resource = AprobadoresOrdenCompraResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
