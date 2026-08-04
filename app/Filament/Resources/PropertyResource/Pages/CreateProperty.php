<?php

namespace App\Filament\Resources\PropertyResource\Pages;

use App\Filament\Resources\PropertyResource;
use App\Services\UniversityDistanceService;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateProperty extends CreateRecord
{
    protected static string $resource = PropertyResource::class;

    protected function getRedirectUrl(): string
    {
        return self::getResource()::getUrl('index');
    }

    protected function afterCreate(): void
    {
        resolve(UniversityDistanceService::class)
            ->sync($this->record);
    }
}
