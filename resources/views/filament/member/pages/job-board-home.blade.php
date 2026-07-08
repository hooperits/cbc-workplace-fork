<x-filament-panels::page>
    <div class="space-y-8">
        @if (! empty($statusMessages))
            <div class="rounded-xl border border-slate-800/80 bg-slate-900/40 p-4 space-y-2">
                @foreach ($statusMessages as $message)
                    <p class="text-sm text-slate-300 flex items-start gap-2">
                        <span class="mt-1.5 h-1.5 w-1.5 shrink-0 rounded-full bg-cyan-400"></span>
                        <span>{{ $message }}</span>
                    </p>
                @endforeach
            </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            {{-- Candidato --}}
            <section class="rounded-2xl border border-slate-800/80 bg-slate-900/40 p-6 flex flex-col gap-5 shadow-sm">
                <header>
                    <h2 class="text-xl font-bold text-slate-100 tracking-tight">
                        {{ __('pages/job-board-home.candidate.title') }}
                    </h2>
                    <p class="mt-1 text-sm text-slate-400">
                        {{ __('pages/job-board-home.candidate.description') }}
                    </p>
                </header>

                <ol class="space-y-3 text-sm">
                    <li class="flex items-start gap-3">
                        @include('filament.member.pages.partials.checklist-icon', ['done' => $candidate['has_profile']])
                        <span class="{{ $candidate['has_profile'] ? 'text-slate-300' : 'text-slate-100 font-medium' }}">
                            {{ $candidate['has_profile']
                                ? __('pages/job-board-home.candidate.steps.profile_done')
                                : __('pages/job-board-home.candidate.steps.profile') }}
                        </span>
                    </li>
                    <li class="flex items-start gap-3">
                        @include('filament.member.pages.partials.checklist-icon', ['done' => $candidate['profile_complete']])
                        <span class="{{ $candidate['profile_complete'] ? 'text-slate-300' : 'text-slate-100 font-medium' }}">
                            {{ $candidate['profile_complete']
                                ? __('pages/job-board-home.candidate.steps.complete_done')
                                : __('pages/job-board-home.candidate.steps.complete') }}
                        </span>
                    </li>
                    <li class="flex items-start gap-3">
                        @include('filament.member.pages.partials.checklist-icon', ['done' => false, 'neutral' => true])
                        <span class="text-slate-300">{{ __('pages/job-board-home.candidate.steps.browse') }}</span>
                    </li>
                    @if ($candidate['applications_count'] > 0)
                        <li class="flex items-start gap-3">
                            @include('filament.member.pages.partials.checklist-icon', ['done' => true])
                            <span class="text-slate-300">
                                {{ __('pages/job-board-home.candidate.steps.applications') }}
                                ({{ $candidate['applications_count'] }})
                            </span>
                        </li>
                    @endif
                </ol>

                <div class="mt-auto flex flex-wrap gap-3 pt-2">
                    <x-filament::button
                        tag="a"
                        :href="$candidate['profile_url']"
                        color="primary"
                        icon="heroicon-o-document-text"
                    >
                        {{ $candidate['has_profile']
                            ? __('pages/job-board-home.candidate.cta.edit_profile')
                            : __('pages/job-board-home.candidate.cta.create_profile') }}
                    </x-filament::button>

                    <x-filament::button
                        tag="a"
                        :href="$candidate['browse_url']"
                        color="gray"
                        icon="heroicon-o-magnifying-glass"
                    >
                        {{ __('pages/job-board-home.candidate.cta.browse') }}
                    </x-filament::button>

                    @if ($candidate['applications_count'] > 0)
                        <x-filament::button
                            tag="a"
                            :href="$candidate['applications_url']"
                            color="gray"
                            icon="heroicon-o-paper-airplane"
                        >
                            {{ __('pages/job-board-home.candidate.cta.applications') }}
                        </x-filament::button>
                    @endif
                </div>
            </section>

            {{-- Empleador --}}
            <section class="rounded-2xl border border-slate-800/80 bg-slate-900/40 p-6 flex flex-col gap-5 shadow-sm">
                <header>
                    <h2 class="text-xl font-bold text-slate-100 tracking-tight">
                        {{ __('pages/job-board-home.employer.title') }}
                    </h2>
                    <p class="mt-1 text-sm text-slate-400">
                        {{ __('pages/job-board-home.employer.description') }}
                    </p>
                </header>

                <ol class="space-y-3 text-sm">
                    <li class="flex items-start gap-3">
                        @include('filament.member.pages.partials.checklist-icon', ['done' => $employer['has_org']])
                        <span class="{{ $employer['has_org'] ? 'text-slate-300' : 'text-slate-100 font-medium' }}">
                            {{ $employer['has_org']
                                ? __('pages/job-board-home.employer.steps.org_done')
                                : __('pages/job-board-home.employer.steps.org') }}
                        </span>
                    </li>
                    <li class="flex items-start gap-3">
                        @include('filament.member.pages.partials.checklist-icon', [
                            'done' => $employer['org_verified'],
                            'pending' => $employer['org_pending'],
                        ])
                        <span class="{{ $employer['org_verified'] ? 'text-slate-300' : 'text-slate-100 font-medium' }}">
                            @if ($employer['org_verified'])
                                {{ __('pages/job-board-home.employer.steps.verify_done') }}
                            @elseif ($employer['org_pending'])
                                {{ __('pages/job-board-home.employer.steps.verify_pending') }}
                            @else
                                {{ __('pages/job-board-home.employer.steps.verify') }}
                            @endif
                        </span>
                    </li>
                    <li class="flex items-start gap-3">
                        @include('filament.member.pages.partials.checklist-icon', ['done' => $employer['listings_count'] > 0])
                        <span class="text-slate-300">{{ __('pages/job-board-home.employer.steps.publish') }}</span>
                    </li>
                    @if ($employer['listings_count'] > 0)
                        <li class="flex items-start gap-3">
                            @include('filament.member.pages.partials.checklist-icon', ['done' => true])
                            <span class="text-slate-300">
                                {{ __('pages/job-board-home.employer.steps.manage') }}
                                ({{ $employer['listings_count'] }})
                            </span>
                        </li>
                    @endif
                </ol>

                <div class="mt-auto flex flex-wrap gap-3 pt-2">
                    <x-filament::button
                        tag="a"
                        :href="$employer['org_url']"
                        color="{{ $employer['has_org'] ? 'gray' : 'primary' }}"
                        icon="heroicon-o-building-office"
                    >
                        {{ $employer['has_org']
                            ? __('pages/job-board-home.employer.cta.view_org')
                            : __('pages/job-board-home.employer.cta.create_org') }}
                    </x-filament::button>

                    @if ($employer['can_publish'])
                        <x-filament::button
                            tag="a"
                            :href="$employer['create_listing_url']"
                            color="primary"
                            icon="heroicon-o-plus"
                        >
                            {{ __('pages/job-board-home.employer.cta.create_listing') }}
                        </x-filament::button>
                    @endif

                    @if ($employer['has_org'])
                        <x-filament::button
                            tag="a"
                            :href="$employer['listings_url']"
                            color="gray"
                            icon="heroicon-o-briefcase"
                        >
                            {{ __('pages/job-board-home.employer.cta.listings') }}
                        </x-filament::button>
                    @endif
                </div>
            </section>
        </div>
    </div>
</x-filament-panels::page>
