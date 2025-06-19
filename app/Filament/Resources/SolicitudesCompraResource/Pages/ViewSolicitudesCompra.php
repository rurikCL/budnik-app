<?php

namespace App\Filament\Resources\SolicitudesCompraResource\Pages;

use App\Filament\Resources\SolicitudesCompraResource;
use App\Models\aprobaciones_solicitud;
use App\Models\aprobadores_solicitud;
use Filament\Actions;
use Filament\Forms\Components\Fieldset;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Pages\ViewRecord;
use Illuminate\Support\Facades\Auth;

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
                ->modalDescription('Esta seguro que desea aprobar esta solicitud?')
                ->action(function ($record, $livewire) {
                    $aprobacion = aprobaciones_solicitud::where('IDExterno', $record['POPRequisitionNumber'])
                        ->where('IDAprobador', Auth::user()->id)->first();

                    if ($aprobacion) {
                        $aprobacion->Estado = 1;
                        $aprobacion->save();
                        if(aprobaciones_solicitud::where('IDExterno', $record['POPRequisitionNumber'])
                            ->where('Estado', 0)->count() == 0) {
                            //TODO: codigo de actualizacion de solicitud, y creacion de orden de compra
                            //
                        }

                        $livewire->dispatch('refreshRelation');
                    }
                }),

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
                ->modalDescription('Esta seguro que desea rechazar esta solicitud?')
                ->action(function ($record, $livewire) {
                    $aprobacion = aprobaciones_solicitud::where('IDExterno', $record['POPRequisitionNumber'])
                        ->where('IDAprobador', Auth::user()->id)->first();

                    if ($aprobacion) {
                        $aprobacion->Estado = 2;
                        $aprobacion->save();
                        if(aprobaciones_solicitud::where('IDExterno', $record['POPRequisitionNumber'])
                                ->where('Estado', 0)->count() == 0) {
                            //TODO: codigo de actualizacion de solicitud, y creacion de orden de compra
                            //
                        }
                        $livewire->dispatch('refreshRelation');

                    }
                }),
        ];
    }

    protected function mutateFormDataBeforeFill(array $data): array
    {
        if (!aprobaciones_solicitud::where('IDExterno', $data['POPRequisitionNumber'])->exists()) {
            $aprobadores = aprobadores_solicitud::all();
            foreach ($aprobadores as $aprobador) {
                $aprobadorNew = aprobaciones_solicitud::create([
                    'IDAprobador' => $aprobador->IDAprobador,
                    'Nivel' => $aprobador->Nivel,
                    'Estado' => 0,
                    'IDExterno' => $data['POPRequisitionNumber'],
                ]);
//                dump($aprobadorNew);
            }
        }
        return $data;
    }

}
