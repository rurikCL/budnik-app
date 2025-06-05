<?php

namespace App\Filament\Resources\SolicitudesCompraResource\Pages;

use App\Filament\Resources\SolicitudesCompraResource;
use Filament\Actions;
use Filament\Forms\Components\Fieldset;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Pages\ViewRecord;

class ViewSolicitudesCompra extends ViewRecord
{
    protected static string $resource = SolicitudesCompraResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\Action::make('Aprobar')
                ->form([
                    Section::make([
                        TextInput::make('Comentario'),
                    ])
                ])
                ->button()
                ->color('success')
                ->requiresConfirmation()
                ->modalHeading('Aprobar Solicitud')
                ->modalDescription('Esta seguro que desea aprobar esta solicitud?'),

            Actions\Action::make('Rechazar')
                ->form([
                    Section::make([
                        TextInput::make('Comentario'),
                    ])
                ])
                ->button()
                ->color('danger')
                ->requiresConfirmation()
                ->modalHeading('Rechazar Solicitud')
                ->modalDescription('Esta seguro que desea rechazar esta solicitud?'),
        ];
    }

}
