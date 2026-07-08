<?php

namespace Tests\Feature\Member\Pages;

use App\Enums\OrganizationVerificationState;
use App\Filament\Member\Pages\ApplyToJobListing;
use App\Filament\Member\Pages\JobBoardHome;
use App\Filament\Member\Resources\CandidateProfileResource;
use App\Filament\Member\Resources\JobListingResource;
use App\Filament\Member\Resources\OrganizationResource;
use App\Models\JobListing;
use App\Models\Member;
use App\Models\Organization;
use App\Models\Role;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class JobBoardHomeTest extends TestCase
{
    use RefreshDatabase;

    protected Member $member;

    protected function setUp(): void
    {
        parent::setUp();

        $memberRole = Role::create([
            'name' => 'member',
            'title' => 'Member',
            'is_active' => true,
            'is_admin' => false,
            'perm' => [],
        ]);

        $this->member = Member::factory()->create([
            'is_active' => true,
            'is_blocked' => false,
            'role_id' => $memberRole->id,
            'email_verified_at' => now(),
        ]);

        Livewire::actingAs($this->member, 'member');
        $this->get(JobBoardHome::getUrl(panel: 'member'));
    }

    public function test_hub_renders_for_member_without_profile_or_org(): void
    {
        Livewire::test(JobBoardHome::class)
            ->assertSuccessful()
            ->assertSee(__('pages/job-board-home.candidate.title'))
            ->assertSee(__('pages/job-board-home.employer.title'))
            ->assertSee(__('pages/job-board-home.candidate.cta.create_profile'))
            ->assertSee(__('pages/job-board-home.employer.cta.create_org'));
    }

    public function test_create_job_listing_without_org_redirects_to_org_create(): void
    {
        Livewire::test(JobListingResource\Pages\CreateJobListing::class)
            ->assertRedirect(OrganizationResource::getUrl('create'));
    }

    public function test_create_job_listing_with_unverified_org_redirects_to_org_edit(): void
    {
        $org = Organization::factory()->create([
            'member_id' => $this->member->id,
            'verification_state' => OrganizationVerificationState::PENDING,
        ]);

        Livewire::test(JobListingResource\Pages\CreateJobListing::class)
            ->assertRedirect(OrganizationResource::getUrl('edit', ['record' => $org]));
    }

    public function test_apply_without_profile_redirects_to_profile_create(): void
    {
        $employer = Member::factory()->create([
            'is_active' => true,
            'is_blocked' => false,
            'role_id' => $this->member->role_id,
            'email_verified_at' => now(),
        ]);
        $org = Organization::factory()->verified()->create([
            'member_id' => $employer->id,
        ]);
        $listing = JobListing::factory()->create([
            'organization_id' => $org->id,
            'member_id' => $employer->id,
            'state' => \App\Enums\JobListingState::ACTIVE,
        ]);

        Livewire::test(ApplyToJobListing::class, ['offer' => $listing->slug])
            ->assertRedirect(CandidateProfileResource::getUrl('create'));
    }

    public function test_dashboard_redirects_to_hub(): void
    {
        $this->actingAs($this->member, 'member')
            ->get('/member')
            ->assertRedirect(JobBoardHome::getUrl(panel: 'member'));
    }
}
