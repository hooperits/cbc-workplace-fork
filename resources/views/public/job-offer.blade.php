@php
    $hasSalary = $offer->salary_min !== null || $offer->salary_max !== null;
    $detailUrl = url('/bolsa-de-trabajo/'.$offer->slug);
@endphp

<x-public.layout
    :title="$offer->title"
    :description="\Illuminate\Support\Str::limit(strip_tags((string) $offer->description), 155)"
    :canonical="$detailUrl"
>
    @push('head')
        @include('public.partials.json-ld', ['offer' => $offer])
        @include('public.partials.og-tags', ['offer' => $offer, 'detailUrl' => $detailUrl])
    @endpush

    <article class="bg-white border border-gray-200 rounded-lg p-6">
        <header class="mb-6 pb-4 border-b border-gray-200">
            <p class="text-sm text-gray-600 mb-2">
                <a
                    href="{{ url('/bolsa-de-trabajo') }}"
                    class="text-blue-700 hover:text-blue-900 focus:outline-none focus-visible:ring-2 focus-visible:ring-blue-500 rounded"
                >
                    ← {{ __('public.listing.title') }}
                </a>
            </p>
            <h1 class="text-3xl font-bold text-gray-900">{{ $offer->title }}</h1>
            @if ($offer->organization)
                <p class="text-lg text-gray-700 mt-2">{{ $offer->organization->display_name }}</p>
            @endif
        </header>

        <dl class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-6 text-sm">
            @if ($offer->city)
                <div>
                    <dt class="font-semibold text-gray-900">{{ __('public.detail.location') }}</dt>
                    <dd class="text-gray-700">{{ $offer->city }}{{ $offer->province ? ', '.$offer->province : '' }}</dd>
                </div>
            @endif

            @if ($offer->work_modality)
                <div>
                    <dt class="font-semibold text-gray-900">{{ __('public.detail.work_mode') }}</dt>
                    <dd class="text-gray-700">{{ $offer->work_modality->getLabel() }}</dd>
                </div>
            @endif

            @if ($offer->contract_type)
                <div>
                    <dt class="font-semibold text-gray-900">{{ __('public.detail.contract_type') }}</dt>
                    <dd class="text-gray-700">{{ $offer->contract_type->getLabel() }}</dd>
                </div>
            @endif

            @if ($offer->categories->isNotEmpty())
                <div>
                    <dt class="font-semibold text-gray-900">{{ __('public.detail.category') }}</dt>
                    <dd class="text-gray-700">{{ $offer->categories->pluck('name')->join(', ') }}</dd>
                </div>
            @endif

            <div>
                <dt class="font-semibold text-gray-900">{{ __('public.detail.salary') }}</dt>
                <dd class="text-gray-700">
                    @if ($hasSalary)
                        {{ $offer->currency }}
                        {{ $offer->salary_min ? number_format((float) $offer->salary_min, 2) : '—' }}
                        @if ($offer->salary_max)
                            – {{ number_format((float) $offer->salary_max, 2) }}
                        @endif
                    @else
                        <span class="text-gray-500 italic">{{ __('public.detail.salary_unspecified') }}</span>
                    @endif
                </dd>
            </div>

            @if ($offer->published_at)
                <div>
                    <dt class="font-semibold text-gray-900">{{ __('public.detail.publication_date') }}</dt>
                    <dd class="text-gray-700">
                        <time datetime="{{ $offer->published_at->toIso8601String() }}">
                            {{ $offer->published_at->isoFormat('LL') }}
                        </time>
                    </dd>
                </div>
            @endif

            @if ($offer->application_deadline)
                <div>
                    <dt class="font-semibold text-gray-900">{{ __('public.detail.application_deadline') }}</dt>
                    <dd class="text-gray-700">
                        <time datetime="{{ $offer->application_deadline->toDateString() }}">
                            {{ $offer->application_deadline->isoFormat('LL') }}
                        </time>
                    </dd>
                </div>
            @endif
        </dl>

        @if ($offer->description)
            <section class="mb-6">
                <h2 class="text-xl font-semibold text-gray-900 mb-2">{{ __('public.detail.description') }}</h2>
                <div class="prose prose-sm max-w-none text-gray-800 whitespace-pre-wrap">{{ $offer->description }}</div>
            </section>
        @endif

        @if ($offer->requirements)
            <section class="mb-6">
                <h2 class="text-xl font-semibold text-gray-900 mb-2">{{ __('public.detail.requirements') }}</h2>
                <div class="prose prose-sm max-w-none text-gray-800 whitespace-pre-wrap">{{ $offer->requirements }}</div>
            </section>
        @endif

        @if ($offer->organization)
            <section class="mb-6 pt-4 border-t border-gray-200">
                <h2 class="text-xl font-semibold text-gray-900 mb-2">{{ __('public.detail.organization') }}</h2>
                <div class="flex gap-4 items-start">
                    @if ($offer->organization->logo)
                        <img
                            src="{{ \Illuminate\Support\Facades\Storage::url($offer->organization->logo) }}"
                            alt="{{ $offer->organization->display_name }}"
                            class="w-20 h-20 object-contain rounded border border-gray-200"
                            loading="lazy"
                        >
                    @endif
                    <div class="flex-1">
                        <h3 class="font-semibold text-gray-900">{{ $offer->organization->display_name }}</h3>
                        @if ($offer->organization->description)
                            <p class="text-gray-700 mt-1">{{ $offer->organization->description }}</p>
                        @endif
                        @if ($offer->organization->website)
                            <p class="mt-2">
                                <a
                                    href="{{ $offer->organization->website }}"
                                    target="_blank"
                                    rel="noopener noreferrer"
                                    class="text-blue-700 hover:text-blue-900 focus:outline-none focus-visible:ring-2 focus-visible:ring-blue-500 rounded"
                                >
                                    {{ __('public.detail.organization_website') }} ↗
                                </a>
                            </p>
                        @endif
                    </div>
                </div>
            </section>
        @endif

        {{-- Apply CTA — variant-aware per FR-019. --}}
        <x-public.apply-cta :variant="$variant" :offer="$offer" />
    </article>
</x-public.layout>
