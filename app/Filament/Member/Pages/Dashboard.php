<?php

namespace App\Filament\Member\Pages;

use Filament\Pages\Dashboard as BaseDashboard;

/**
 * Panel home: redirect to the Bolsa de Trabajo hub so members land on
 * intent-based onboarding instead of an empty widgets dashboard.
 */
class Dashboard extends BaseDashboard
{
    protected static bool $shouldRegisterNavigation = false;

    public function mount(): void
    {
        $this->redirect(JobBoardHome::getUrl(panel: 'member'));
    }
}
