<?php

namespace App\Filament\Resources\PlanSubscriptionResource\Pages;

use App\Filament\Resources\PlanSubscriptionResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;

class EditPlanSubscription extends EditRecord
{
    protected static string $resource = PlanSubscriptionResource::class;

    protected function getActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
