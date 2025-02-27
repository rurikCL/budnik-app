<?php

namespace App\Filament\Resources\OrdenesCompraResource\Pages;

use App\Filament\Resources\OrdenesCompraResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListOrdenesCompras extends ListRecords
{
    protected static string $resource = OrdenesCompraResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
