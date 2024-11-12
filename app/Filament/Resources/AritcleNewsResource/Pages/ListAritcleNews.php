<?php

namespace App\Filament\Resources\AritcleNewsResource\Pages;

use App\Filament\Resources\AritcleNewsResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListAritcleNews extends ListRecords
{
    protected static string $resource = AritcleNewsResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
