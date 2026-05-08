@php
    use App\Enums\ContractType;
    use App\Enums\WorkModality;

    // Per FR-024 + FR-027 the unfiltered, page-1 listing is the only
    // canonically-indexable variant. Any active filter or page>1 sets
    // `noindex,follow` so duplicate-content variants don't pollute the index.
    $hasFilters = collect($activeFilters)->some(fn ($values) => $values !== [])
        || ($activeKeyword !== null);
    $isPaginatedDeep = request()->integer('page', 1) > 1;
    $shouldNoindex = $hasFilters || $isPaginatedDeep;

    $countActiveFilters = collect($activeFilters)->sum(fn ($values) => count($values))
        + ($activeKeyword !== null ? 1 : 0);
@endphp

<x-public.layout
    :title="__('public.listing.title')"
    :description="__('public.listing.subtitle')"
    :canonical="url('/bolsa-de-trabajo')"
    :noindex="$shouldNoindex"
>
    <header class="mb-6">
        <h1 class="text-3xl font-bold text-gray-900">{{ __('public.listing.title') }}</h1>
        <p class="text-gray-600 mt-1">{{ __('public.listing.subtitle') }}</p>
    </header>

    <form
        method="GET"
        action="{{ url('/bolsa-de-trabajo') }}"
        class="mb-6"
        id="public-search-form"
        role="search"
        aria-label="{{ __('public.filters.title') }}"
    >
        <div class="flex flex-col md:flex-row gap-3 mb-4">
            <label class="flex-1 block">
                <span class="sr-only">{{ __('public.filters.search_placeholder') }}</span>
                <input
                    type="search"
                    name="q"
                    id="public-search-input"
                    value="{{ $activeKeyword ?? '' }}"
                    placeholder="{{ __('public.filters.search_placeholder') }}"
                    autocomplete="off"
                    inputmode="search"
                    maxlength="200"
                    class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus-visible:ring-2 focus-visible:ring-blue-500 focus-visible:border-blue-500"
                >
            </label>

            <label class="block md:w-56">
                <span class="sr-only">{{ __('public.filters.sort.label') }}</span>
                <select
                    name="sort"
                    onchange="document.getElementById('public-search-form').submit()"
                    class="w-full px-3 py-2 border border-gray-300 rounded-md bg-white focus:outline-none focus-visible:ring-2 focus-visible:ring-blue-500"
                >
                    <option value="recent" @selected($currentSort === 'recent')>{{ __('public.filters.sort.recent') }}</option>
                    <option value="deadline" @selected($currentSort === 'deadline')>{{ __('public.filters.sort.deadline') }}</option>
                </select>
            </label>
        </div>

        <details class="mb-4 border border-gray-200 rounded-md bg-white" @if ($countActiveFilters > 0) open @endif>
            <summary class="cursor-pointer px-4 py-3 font-medium text-gray-900 select-none">
                {{ __('public.filters.title') }}
                @if ($countActiveFilters > 0)
                    <span class="ml-2 text-sm font-normal text-blue-700">({{ $countActiveFilters }})</span>
                @endif
            </summary>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 px-4 py-4 border-t border-gray-200">
                {{-- Category --}}
                @if ($jobCategories->isNotEmpty())
                    <fieldset>
                        <legend class="font-semibold text-gray-900 mb-2">{{ __('public.filters.category') }}</legend>
                        @foreach ($jobCategories as $cat)
                            <label class="flex items-center gap-2 mb-1 cursor-pointer">
                                <input
                                    type="checkbox"
                                    name="category[]"
                                    value="{{ $cat->id }}"
                                    @checked(in_array($cat->id, $activeFilters['category'] ?? [], true))
                                    onchange="document.getElementById('public-search-form').submit()"
                                    class="rounded border-gray-300 text-blue-600 focus:ring-blue-500"
                                >
                                <span class="text-sm text-gray-800">{{ $cat->name }}</span>
                            </label>
                        @endforeach
                    </fieldset>
                @endif

                {{-- Work Modality --}}
                <fieldset>
                    <legend class="font-semibold text-gray-900 mb-2">{{ __('public.filters.work_mode') }}</legend>
                    @foreach (WorkModality::cases() as $mode)
                        <label class="flex items-center gap-2 mb-1 cursor-pointer">
                            <input
                                type="checkbox"
                                name="work_mode[]"
                                value="{{ $mode->value }}"
                                @checked(in_array($mode->value, $activeFilters['work_mode'] ?? [], true))
                                onchange="document.getElementById('public-search-form').submit()"
                                class="rounded border-gray-300 text-blue-600 focus:ring-blue-500"
                            >
                            <span class="text-sm text-gray-800">{{ $mode->getLabel() }}</span>
                        </label>
                    @endforeach
                </fieldset>

                {{-- Contract Type --}}
                <fieldset>
                    <legend class="font-semibold text-gray-900 mb-2">{{ __('public.filters.contract') }}</legend>
                    @foreach (ContractType::cases() as $type)
                        <label class="flex items-center gap-2 mb-1 cursor-pointer">
                            <input
                                type="checkbox"
                                name="contract[]"
                                value="{{ $type->value }}"
                                @checked(in_array($type->value, $activeFilters['contract'] ?? [], true))
                                onchange="document.getElementById('public-search-form').submit()"
                                class="rounded border-gray-300 text-blue-600 focus:ring-blue-500"
                            >
                            <span class="text-sm text-gray-800">{{ $type->getLabel() }}</span>
                        </label>
                    @endforeach
                </fieldset>

                {{-- City (dynamic per FR-010b) --}}
                @if (! empty($cities))
                    <fieldset>
                        <legend class="font-semibold text-gray-900 mb-2">{{ __('public.filters.city') }}</legend>
                        <div class="max-h-40 overflow-y-auto pr-2">
                            @foreach ($cities as $city)
                                <label class="flex items-center gap-2 mb-1 cursor-pointer">
                                    <input
                                        type="checkbox"
                                        name="city[]"
                                        value="{{ $city }}"
                                        @checked(in_array($city, $activeFilters['city'] ?? [], true))
                                        onchange="document.getElementById('public-search-form').submit()"
                                        class="rounded border-gray-300 text-blue-600 focus:ring-blue-500"
                                    >
                                    <span class="text-sm text-gray-800">{{ $city }}</span>
                                </label>
                            @endforeach
                        </div>
                    </fieldset>
                @endif
            </div>

            @if ($countActiveFilters > 0)
                <div class="px-4 py-3 border-t border-gray-200 bg-gray-50 rounded-b-md">
                    <a
                        href="{{ url('/bolsa-de-trabajo') }}"
                        class="text-sm text-blue-700 hover:text-blue-900 focus:outline-none focus-visible:ring-2 focus-visible:ring-blue-500 rounded"
                    >
                        ✕ {{ __('public.filters.clear_all') }}
                    </a>
                </div>
            @endif
        </details>

        <noscript>
            <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-md">
                {{ __('public.filters.apply') }}
            </button>
        </noscript>
    </form>

    <div
        class="text-sm text-gray-700 mb-4"
        role="status"
        aria-live="polite"
        id="result-count"
    >
        {{ trans_choice('public.listing.result_count', $offers->total(), ['count' => $offers->total()]) }}
    </div>

    @if ($offers->isEmpty())
        @if ($countActiveFilters > 0)
            <x-public.empty-state
                :title="__('public.listing.empty.with_filters.title')"
                :message="__('public.listing.empty.with_filters.message')"
                :ctaLabel="__('public.listing.empty.with_filters.cta')"
                :ctaUrl="url('/bolsa-de-trabajo')"
            />
        @else
            <x-public.empty-state
                :title="__('public.listing.empty.title')"
                :message="__('public.listing.empty.message')"
            />
        @endif
    @else
        <ul class="space-y-4 mb-8 list-none p-0" role="list">
            @foreach ($offers as $offer)
                <li>
                    <x-public.offer-card :offer="$offer" />
                </li>
            @endforeach
        </ul>

        @if ($offers->hasPages())
            <x-public.pagination-nav :paginator="$offers" />
        @endif
    @endif

    @push('head')
        <script>
            // Debounced live search per FR-009a — submits the form 300 ms
            // after the visitor's last keystroke. Vanilla JS to keep the
            // public surface dependency-free.
            (function () {
                const input = document.getElementById('public-search-input');
                const form = document.getElementById('public-search-form');
                if (!input || !form) return;

                let timer = null;
                let lastValue = input.value;

                input.addEventListener('input', function () {
                    if (input.value === lastValue) return;
                    lastValue = input.value;

                    if (timer) clearTimeout(timer);
                    timer = setTimeout(function () {
                        // Drop any current page param so debounced search
                        // always starts on page 1.
                        const pageInput = form.querySelector('input[name="page"]');
                        if (pageInput) pageInput.remove();
                        form.submit();
                    }, 300);
                });
            })();
        </script>
    @endpush
</x-public.layout>
