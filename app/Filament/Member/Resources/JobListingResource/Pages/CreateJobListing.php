<?php

namespace App\Filament\Member\Resources\JobListingResource\Pages;

use App\Enums\OrganizationVerificationState;
use App\Filament\Member\Pages\JobBoardHome;
use App\Filament\Member\Resources\JobListingResource;
use App\Filament\Member\Resources\OrganizationResource;
use App\Helpers\Util;
use App\Models\Organization;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Database\Eloquent\Model;

class CreateJobListing extends CreateRecord
{
    protected static string $resource = JobListingResource::class;

    public static function canCreateAnother(): bool
    {
        return false;
    }

    public function mount(): void
    {
        $organization = Organization::where('member_id', auth('member')->id())->first();

        if (! $organization) {
            Util::filamentNotification(__('pages/job-board-home.gates.publish_need_org'), 'warning');
            $this->redirect(OrganizationResource::getUrl('create'));

            return;
        }

        if ($organization->is_suspended()) {
            Util::filamentNotification(__('pages/job-board-home.gates.publish_suspended'), 'danger');
            $this->redirect(JobBoardHome::getUrl(panel: 'member'));

            return;
        }

        if ($organization->verification_state !== OrganizationVerificationState::VERIFIED) {
            Util::filamentNotification(__('pages/job-board-home.gates.publish_need_verification'), 'warning');
            $this->redirect(OrganizationResource::getUrl('edit', ['record' => $organization]));

            return;
        }

        parent::mount();
    }

    protected function handleRecordCreation(array $data): Model
    {
        $organization = Organization::where('member_id', auth('member')->id())->first();
        $model = static::getModel();
        $instance = new $model;
        $instance->fill($data);
        $instance->organization_id = $organization->id;
        $instance->member_id = auth('member')->id();
        $instance->save();

        return $instance;
    }

    protected function getRedirectUrl(): string
    {
        return JobListingResource::getUrl('edit', ['record' => $this->record]);
    }
}
