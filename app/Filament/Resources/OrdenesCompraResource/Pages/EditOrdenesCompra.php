<?php

namespace App\Filament\Resources\OrdenesCompraResource\Pages;

use App\Filament\Resources\OrdenesCompraResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditOrdenesCompra extends EditRecord
{
    protected static string $resource = OrdenesCompraResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
