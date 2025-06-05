<?php

namespace App\Filament\Resources\AprobadoresSolicitudResource\Pages;

use App\Filament\Resources\AprobadoresSolicitudResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListAprobadoresSolicituds extends ListRecords
{
    protected static string $resource = AprobadoresSolicitudResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
