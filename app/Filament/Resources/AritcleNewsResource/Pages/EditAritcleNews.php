<?php

namespace App\Filament\Resources\AritcleNewsResource\Pages;

use App\Filament\Resources\AritcleNewsResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditAritcleNews extends EditRecord
{
    protected static string $resource = AritcleNewsResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
