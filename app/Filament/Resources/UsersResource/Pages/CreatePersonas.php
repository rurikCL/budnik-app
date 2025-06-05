<?php

namespace App\Filament\Resources\UsersResource\Pages;

use App\Filament\Resources\UsersResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreatePersonas extends CreateRecord
{
    protected static string $resource = UsersResource::class;
}
