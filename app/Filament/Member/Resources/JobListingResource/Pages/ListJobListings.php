<?php

declare(strict_types=1);

namespace App\Filament\Member\Resources\JobListingResource\Pages;

use App\Enums\OrganizationVerificationState;
use App\Filament\Member\Resources\JobListingResource;
use App\Filament\Member\Resources\OrganizationResource;
use App\Models\Organization;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Filament\Tables;
use Filament\Tables\Table;

class ListJobListings extends ListRecords
{
    protected static string $resource = JobListingResource::class;

    protected function getHeaderActions(): array
    {
        $organization = auth('member')->user()?->organization;
        $canCreate = $organization
            && $organization->verification_state === OrganizationVerificationState::VERIFIED
            && ! $organization->is_suspended();

        return [
            Actions\CreateAction::make()
                ->visible(fn (): bool => (bool) $canCreate),
        ];
    }

    public function table(Table $table): Table
    {
        $table = parent::table($table);
        $organization = Organization::where('member_id', auth('member')->id())->first();

        if (! $organization) {
            return $table
                ->emptyStateHeading(__('pages/job-board-home.empty.listings.no_org_heading'))
                ->emptyStateDescription(__('pages/job-board-home.empty.listings.no_org_description'))
                ->emptyStateActions([
                    Tables\Actions\Action::make('register_org')
                        ->label(__('pages/job-board-home.empty.listings.no_org_action'))
                        ->url(OrganizationResource::getUrl('create'))
                        ->icon('heroicon-o-building-office')
                        ->button(),
                ]);
        }

        if ($organization->is_suspended()) {
            return $table
                ->emptyStateHeading(__('pages/job-board-home.status.org_suspended'))
                ->emptyStateDescription(__('models/organization.banner.suspended.body'));
        }

        if ($organization->verification_state !== OrganizationVerificationState::VERIFIED) {
            return $table
                ->emptyStateHeading(__('pages/job-board-home.empty.listings.pending_heading'))
                ->emptyStateDescription(__('pages/job-board-home.empty.listings.pending_description'))
                ->emptyStateActions([
                    Tables\Actions\Action::make('view_org')
                        ->label(__('pages/job-board-home.empty.listings.pending_action'))
                        ->url(OrganizationResource::getUrl('edit', ['record' => $organization]))
                        ->icon('heroicon-o-building-office')
                        ->button(),
                ]);
        }

        return $table
            ->emptyStateHeading(__('pages/job-board-home.empty.listings.ready_heading'))
            ->emptyStateDescription(__('pages/job-board-home.empty.listings.ready_description'))
            ->emptyStateActions([
                Tables\Actions\Action::make('create_listing')
                    ->label(__('pages/job-board-home.empty.listings.ready_action'))
                    ->url(JobListingResource::getUrl('create'))
                    ->icon('heroicon-o-plus')
                    ->button(),
            ]);
    }
}
