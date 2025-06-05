<?php

namespace App\Filament\Resources\AprobadoresOrdenCompraResource\Pages;

use App\Filament\Resources\AprobadoresOrdenCompraResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListAprobadoresOrdenCompras extends ListRecords
{
    protected static string $resource = AprobadoresOrdenCompraResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
