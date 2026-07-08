<?php

namespace App\Filament\Member\Pages;

use App\Enums\OrganizationVerificationState;
use App\Filament\Member\Resources\ApplicationResource;
use App\Filament\Member\Resources\CandidateProfileResource;
use App\Filament\Member\Resources\JobListingResource;
use App\Filament\Member\Resources\OrganizationResource;
use App\Models\Application;
use App\Models\CandidateProfile;
use App\Models\JobListing;
use App\Models\Member;
use App\Models\Organization;
use Filament\Pages\Page;

class JobBoardHome extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-home';

    protected static string $view = 'filament.member.pages.job-board-home';

    protected static ?int $navigationSort = -20;

    protected static ?string $slug = 'bolsa-de-trabajo';

    public static function getNavigationLabel(): string
    {
        return __('pages/job-board-home.navigation');
    }

    public static function getNavigationGroup(): ?string
    {
        return __('navigation.bolsa-de-trabajo');
    }

    public function getTitle(): string
    {
        return __('pages/job-board-home.title');
    }

    public function getHeading(): string
    {
        return __('pages/job-board-home.title');
    }

    public function getSubheading(): ?string
    {
        return __('pages/job-board-home.subtitle');
    }

    /**
     * @return array<string, mixed>
     */
    protected function getViewData(): array
    {
        $member = auth('member')->user();
        if (! $member instanceof Member) {
            return $this->emptyState();
        }

        $profile = $member->candidateProfile;
        $organization = $member->organization;
        $applicationsCount = Application::query()->where('member_id', $member->id)->count();
        $listingsCount = $organization
            ? JobListing::query()->where('organization_id', $organization->id)->count()
            : 0;

        $profileComplete = $this->isProfileComplete($profile);
        $orgVerified = $organization
            && $organization->verification_state === OrganizationVerificationState::VERIFIED
            && ! $organization->is_suspended();
        $orgPending = $organization
            && $organization->verification_state === OrganizationVerificationState::PENDING
            && ! $organization->is_suspended();
        $orgSuspended = (bool) ($organization?->is_suspended());

        return [
            'statusMessages' => $this->statusMessages($profile, $profileComplete, $organization, $orgVerified, $orgPending, $orgSuspended),
            'candidate' => [
                'has_profile' => (bool) $profile,
                'profile_complete' => $profileComplete,
                'applications_count' => $applicationsCount,
                'profile_url' => $profile
                    ? CandidateProfileResource::getUrl('edit', ['record' => $profile])
                    : CandidateProfileResource::getUrl('create'),
                'browse_url' => url('/bolsa-de-trabajo'),
                'applications_url' => ApplicationResource::getUrl('index'),
            ],
            'employer' => [
                'has_org' => (bool) $organization,
                'org_verified' => $orgVerified,
                'org_pending' => $orgPending,
                'org_suspended' => $orgSuspended,
                'listings_count' => $listingsCount,
                'org_url' => $organization
                    ? OrganizationResource::getUrl('edit', ['record' => $organization])
                    : OrganizationResource::getUrl('create'),
                'listings_url' => JobListingResource::getUrl('index'),
                'create_listing_url' => JobListingResource::getUrl('create'),
                'can_publish' => $orgVerified,
            ],
        ];
    }

    protected function isProfileComplete(?CandidateProfile $profile): bool
    {
        if (! $profile) {
            return false;
        }

        return filled($profile->headline)
            && filled($profile->city)
            && filled($profile->phone)
            && filled($profile->summary);
    }

    /**
     * @return list<string>
     */
    protected function statusMessages(
        ?CandidateProfile $profile,
        bool $profileComplete,
        ?Organization $organization,
        bool $orgVerified,
        bool $orgPending,
        bool $orgSuspended,
    ): array {
        $messages = [];

        if (! $profile) {
            $messages[] = __('pages/job-board-home.status.no_profile');
        } elseif (! $profileComplete) {
            $messages[] = __('pages/job-board-home.status.profile_incomplete');
        } else {
            $messages[] = __('pages/job-board-home.status.ready_to_apply');
        }

        if ($orgSuspended) {
            $messages[] = __('pages/job-board-home.status.org_suspended');
        } elseif (! $organization) {
            $messages[] = __('pages/job-board-home.status.no_org');
        } elseif ($orgPending) {
            $messages[] = __('pages/job-board-home.status.org_pending');
        } elseif ($orgVerified) {
            $messages[] = __('pages/job-board-home.status.org_ready');
        }

        return $messages;
    }

    /**
     * @return array<string, mixed>
     */
    protected function emptyState(): array
    {
        return [
            'statusMessages' => [],
            'candidate' => [
                'has_profile' => false,
                'profile_complete' => false,
                'applications_count' => 0,
                'profile_url' => CandidateProfileResource::getUrl('create'),
                'browse_url' => url('/bolsa-de-trabajo'),
                'applications_url' => ApplicationResource::getUrl('index'),
            ],
            'employer' => [
                'has_org' => false,
                'org_verified' => false,
                'org_pending' => false,
                'org_suspended' => false,
                'listings_count' => 0,
                'org_url' => OrganizationResource::getUrl('create'),
                'listings_url' => JobListingResource::getUrl('index'),
                'create_listing_url' => JobListingResource::getUrl('create'),
                'can_publish' => false,
            ],
        ];
    }
}
