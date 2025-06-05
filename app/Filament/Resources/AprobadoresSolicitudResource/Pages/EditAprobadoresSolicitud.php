<?php

namespace App\Filament\Resources\AprobadoresSolicitudResource\Pages;

use App\Filament\Resources\AprobadoresSolicitudResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditAprobadoresSolicitud extends EditRecord
{
    protected static string $resource = AprobadoresSolicitudResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
