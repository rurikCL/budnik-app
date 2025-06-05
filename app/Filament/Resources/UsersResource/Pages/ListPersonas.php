<?php

namespace App\Filament\Resources\UsersResource\Pages;

use App\Filament\Resources\UsersResource;
use Filament\Actions;
use Filament\Resources\Components\Tab;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Database\Eloquent\Builder;

class ListPersonas extends ListRecords
{
    protected static string $resource = UsersResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }

    public function getTabs(): array
    {
        return [
            'Todos' => Tab::make(),

            'Activos' => Tab::make()
                ->modifyQueryUsing(fn(Builder $query) => $query->where('Activo', 1)),
            'Inactivos' => Tab::make()
                ->modifyQueryUsing(fn(Builder $query) => $query->where('Activo', 0)),

        ];
    }
}
