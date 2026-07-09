<?php

namespace App\Filament\Member\Pages;

use App\Enums\OrganizationVerificationState;
use App\Filament\Member\Resources\ApplicationResource;
use App\Filament\Member\Resources\CandidateProfileResource;
use App\Filament\Member\Resources\JobAlertResource;
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
        return '';
    }

    public function getSubheading(): ?string
    {
        return null;
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

        $hasProfile = (bool) $profile;
        $profileUrl = $hasProfile
            ? CandidateProfileResource::getUrl('edit', ['record' => $profile])
            : CandidateProfileResource::getUrl('create');
        $browseUrl = url('/bolsa-de-trabajo');
        $applicationsUrl = ApplicationResource::getUrl('index');
        $orgUrl = $organization
            ? OrganizationResource::getUrl('edit', ['record' => $organization])
            : OrganizationResource::getUrl('create');
        $listingsUrl = JobListingResource::getUrl('index');
        $createListingUrl = JobListingResource::getUrl('create');

        // Candidate progress: profile exists + profile complete + (optional browse always available)
        // Count profile + complete as 2 required steps; applications is bonus.
        $candidateDone = (int) $hasProfile + (int) $profileComplete;
        $candidateTotal = 2;

        $employerDone = (int) (bool) $organization + (int) $orgVerified + (int) ($listingsCount > 0);
        $employerTotal = 3;

        return [
            'memberName' => $member->name,
            'statusChips' => $this->statusChips($hasProfile, $profileComplete, $organization, $orgVerified, $orgPending, $orgSuspended),
            'candidate' => [
                'has_profile' => $hasProfile,
                'profile_complete' => $profileComplete,
                'applications_count' => $applicationsCount,
                'profile_url' => $profileUrl,
                'browse_url' => $browseUrl,
                'applications_url' => $applicationsUrl,
                'progress' => [
                    'done' => $candidateDone,
                    'total' => $candidateTotal,
                    'percent' => $candidateTotal > 0 ? (int) round(($candidateDone / $candidateTotal) * 100) : 0,
                ],
                'primary_cta' => $this->candidatePrimaryCta($hasProfile, $profileComplete, $profileUrl, $browseUrl),
                'secondary_links' => array_values(array_filter([
                    $hasProfile ? [
                        'label' => __('pages/job-board-home.candidate.cta.edit_profile'),
                        'url' => $profileUrl,
                    ] : null,
                    $applicationsCount > 0 ? [
                        'label' => __('pages/job-board-home.candidate.cta.applications')." ({$applicationsCount})",
                        'url' => $applicationsUrl,
                    ] : null,
                    [
                        'label' => __('pages/job-board-home.candidate.cta.browse'),
                        'url' => $browseUrl,
                    ],
                ])),
            ],
            'employer' => [
                'has_org' => (bool) $organization,
                'org_verified' => $orgVerified,
                'org_pending' => $orgPending,
                'org_suspended' => $orgSuspended,
                'listings_count' => $listingsCount,
                'org_url' => $orgUrl,
                'listings_url' => $listingsUrl,
                'create_listing_url' => $createListingUrl,
                'can_publish' => $orgVerified,
                'progress' => [
                    'done' => min($employerDone, $employerTotal),
                    'total' => $employerTotal,
                    'percent' => (int) round((min($employerDone, $employerTotal) / $employerTotal) * 100),
                ],
                'primary_cta' => $this->employerPrimaryCta(
                    (bool) $organization,
                    $orgVerified,
                    $orgSuspended,
                    $orgUrl,
                    $createListingUrl,
                    $listingsUrl,
                    $listingsCount,
                ),
                'secondary_links' => array_values(array_filter([
                    $organization ? [
                        'label' => __('pages/job-board-home.employer.cta.view_org'),
                        'url' => $orgUrl,
                    ] : null,
                    $organization ? [
                        'label' => __('pages/job-board-home.employer.cta.listings').($listingsCount ? " ({$listingsCount})" : ''),
                        'url' => $listingsUrl,
                    ] : null,
                ])),
            ],
            'quickLinks' => [
                [
                    'label' => __('pages/job-board-home.quick.profile'),
                    'url' => $profileUrl,
                    'icon' => 'document',
                    'tone' => 'cyan',
                ],
                [
                    'label' => __('pages/job-board-home.quick.applications'),
                    'url' => $applicationsUrl,
                    'icon' => 'plane',
                    'tone' => 'cyan',
                    'badge' => $applicationsCount > 0 ? (string) $applicationsCount : null,
                ],
                [
                    'label' => __('pages/job-board-home.quick.alerts'),
                    'url' => JobAlertResource::getUrl('index'),
                    'icon' => 'bell',
                    'tone' => 'slate',
                ],
                [
                    'label' => __('pages/job-board-home.quick.org'),
                    'url' => $orgUrl,
                    'icon' => 'building',
                    'tone' => 'amber',
                ],
                [
                    'label' => __('pages/job-board-home.quick.listings'),
                    'url' => $listingsUrl,
                    'icon' => 'briefcase',
                    'tone' => 'amber',
                    'badge' => $listingsCount > 0 ? (string) $listingsCount : null,
                ],
                [
                    'label' => __('pages/job-board-home.quick.browse'),
                    'url' => $browseUrl,
                    'icon' => 'search',
                    'tone' => 'slate',
                ],
            ],
        ];
    }

    /**
     * @return array{label: string, url: string}
     */
    protected function candidatePrimaryCta(bool $hasProfile, bool $profileComplete, string $profileUrl, string $browseUrl): array
    {
        if (! $hasProfile) {
            return [
                'label' => __('pages/job-board-home.candidate.cta.create_profile'),
                'url' => $profileUrl,
            ];
        }
        if (! $profileComplete) {
            return [
                'label' => __('pages/job-board-home.candidate.cta.complete_profile'),
                'url' => $profileUrl,
            ];
        }

        return [
            'label' => __('pages/job-board-home.candidate.cta.browse'),
            'url' => $browseUrl,
        ];
    }

    /**
     * @return array{label: string, url: string}
     */
    protected function employerPrimaryCta(
        bool $hasOrg,
        bool $orgVerified,
        bool $orgSuspended,
        string $orgUrl,
        string $createListingUrl,
        string $listingsUrl,
        int $listingsCount,
    ): array {
        if (! $hasOrg) {
            return [
                'label' => __('pages/job-board-home.employer.cta.create_org'),
                'url' => $orgUrl,
            ];
        }
        if ($orgSuspended) {
            return [
                'label' => __('pages/job-board-home.employer.cta.view_org'),
                'url' => $orgUrl,
            ];
        }
        if (! $orgVerified) {
            return [
                'label' => __('pages/job-board-home.employer.cta.view_org'),
                'url' => $orgUrl,
            ];
        }
        if ($listingsCount === 0) {
            return [
                'label' => __('pages/job-board-home.employer.cta.create_listing'),
                'url' => $createListingUrl,
            ];
        }

        return [
            'label' => __('pages/job-board-home.employer.cta.listings'),
            'url' => $listingsUrl,
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
     * @return list<array{label: string, tone: string}>
     */
    protected function statusChips(
        bool $hasProfile,
        bool $profileComplete,
        ?Organization $organization,
        bool $orgVerified,
        bool $orgPending,
        bool $orgSuspended,
    ): array {
        $chips = [];

        if (! $hasProfile) {
            $chips[] = ['label' => __('pages/job-board-home.status.no_profile'), 'tone' => 'warning'];
        } elseif (! $profileComplete) {
            $chips[] = ['label' => __('pages/job-board-home.status.profile_incomplete'), 'tone' => 'warning'];
        } else {
            $chips[] = ['label' => __('pages/job-board-home.status.ready_to_apply'), 'tone' => 'success'];
        }

        if ($orgSuspended) {
            $chips[] = ['label' => __('pages/job-board-home.status.org_suspended'), 'tone' => 'danger'];
        } elseif (! $organization) {
            $chips[] = ['label' => __('pages/job-board-home.status.no_org'), 'tone' => 'muted'];
        } elseif ($orgPending) {
            $chips[] = ['label' => __('pages/job-board-home.status.org_pending'), 'tone' => 'warning'];
        } elseif ($orgVerified) {
            $chips[] = ['label' => __('pages/job-board-home.status.org_ready'), 'tone' => 'success'];
        }

        return $chips;
    }

    /**
     * @return array<string, mixed>
     */
    protected function emptyState(): array
    {
        $profileUrl = CandidateProfileResource::getUrl('create');
        $orgUrl = OrganizationResource::getUrl('create');
        $browseUrl = url('/bolsa-de-trabajo');

        return [
            'memberName' => '',
            'statusChips' => [],
            'candidate' => [
                'has_profile' => false,
                'profile_complete' => false,
                'applications_count' => 0,
                'profile_url' => $profileUrl,
                'browse_url' => $browseUrl,
                'applications_url' => ApplicationResource::getUrl('index'),
                'progress' => ['done' => 0, 'total' => 2, 'percent' => 0],
                'primary_cta' => [
                    'label' => __('pages/job-board-home.candidate.cta.create_profile'),
                    'url' => $profileUrl,
                ],
                'secondary_links' => [
                    ['label' => __('pages/job-board-home.candidate.cta.browse'), 'url' => $browseUrl],
                ],
            ],
            'employer' => [
                'has_org' => false,
                'org_verified' => false,
                'org_pending' => false,
                'org_suspended' => false,
                'listings_count' => 0,
                'org_url' => $orgUrl,
                'listings_url' => JobListingResource::getUrl('index'),
                'create_listing_url' => JobListingResource::getUrl('create'),
                'can_publish' => false,
                'progress' => ['done' => 0, 'total' => 3, 'percent' => 0],
                'primary_cta' => [
                    'label' => __('pages/job-board-home.employer.cta.create_org'),
                    'url' => $orgUrl,
                ],
                'secondary_links' => [],
            ],
            'quickLinks' => [],
        ];
    }
}
