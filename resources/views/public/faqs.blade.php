@php
    use App\Enums\FaqModule;

    $moduleTabs = collect([
        ['value' => 'all', 'label' => __('public-faq.filters.all')],
        ...collect(FaqModule::cases())->map(fn (FaqModule $m) => [
            'value' => $m->value,
            'label' => $m->getLabel(),
        ])->all(),
    ]);

    // When a single module is filtered, hide per-item module labels.
    $showModuleOnItems = $activeModule === 'all';
@endphp

<x-public.layout
    :title="__('public-faq.title')"
    :description="__('public-faq.subtitle')"
    :canonical="url('/preguntas-frecuentes')"
    :noindex="$searchQuery !== '' || $activeModule !== 'all' || request()->integer('page', 1) > 1"
    active="faq"
>
    <div class="max-w-3xl mx-auto">
        <header class="mb-10 text-center sm:text-left">
            <h1
                class="text-3xl sm:text-4xl font-bold tracking-tight text-white"
                style="line-height: 1.3;"
            >
                {{ __('public-faq.title') }}
            </h1>
            <p class="mt-3 text-slate-400 text-base sm:text-lg font-light max-w-xl">
                {{ __('public-faq.subtitle') }}
            </p>
        </header>

        <form
            method="GET"
            action="{{ url('/preguntas-frecuentes') }}"
            class="mb-8 space-y-4"
            role="search"
            aria-label="{{ __('public-faq.title') }}"
            id="faq-search-form"
        >
            <div class="flex gap-2">
                <label class="flex-1 block min-w-0">
                    <span class="sr-only">{{ __('public-faq.search_placeholder') }}</span>
                    <input
                        type="search"
                        name="q"
                        value="{{ $searchQuery }}"
                        placeholder="{{ __('public-faq.search_placeholder') }}"
                        maxlength="200"
                        class="w-full px-4 py-2.5 bg-transparent border border-slate-800 text-slate-100 rounded-lg placeholder-slate-500 focus:outline-none focus:ring-1 focus:ring-cyan-500/60 focus:border-cyan-500/60 transition-colors text-sm"
                    >
                </label>
                <button
                    type="submit"
                    class="shrink-0 px-4 py-2.5 text-sm font-medium text-slate-200 border border-slate-800 rounded-lg hover:border-slate-600 hover:text-white transition-colors"
                >
                    {{ __('public-faq.search_submit') }}
                </button>
            </div>

            @if ($activeModule !== 'all')
                <input type="hidden" name="module" value="{{ $activeModule }}">
            @endif

            <div
                class="flex flex-wrap gap-1.5"
                role="group"
                aria-label="{{ __('public-faq.filters.aria') }}"
            >
                @foreach ($moduleTabs as $tab)
                    @php
                        $isActive = $activeModule === $tab['value'];
                        $href = url('/preguntas-frecuentes').'?'.http_build_query(array_filter([
                            'module' => $tab['value'] === 'all' ? null : $tab['value'],
                            'q' => $searchQuery !== '' ? $searchQuery : null,
                        ]));
                    @endphp
                    <a
                        href="{{ $href }}"
                        class="px-3 py-1.5 rounded-md text-sm transition-colors {{ $isActive
                            ? 'bg-slate-100 text-slate-900 font-medium'
                            : 'text-slate-400 hover:text-slate-200 hover:bg-slate-800/60' }}"
                        @if ($isActive) aria-current="page" @endif
                    >
                        {{ $tab['label'] }}
                    </a>
                @endforeach
            </div>
        </form>

        <p class="text-xs text-slate-500 mb-4" role="status" aria-live="polite">
            {{ trans_choice('public-faq.result_count', $faqs->total(), ['count' => $faqs->total()]) }}
        </p>

        @if ($faqs->isEmpty())
            <div class="py-16 text-center border border-dashed border-slate-800 rounded-xl" role="status">
                <p class="text-slate-300 font-medium mb-1">{{ __('public-faq.empty.title') }}</p>
                <p class="text-slate-500 text-sm mb-6">{{ __('public-faq.empty.message') }}</p>
                <a
                    href="{{ url('/preguntas-frecuentes') }}"
                    class="text-sm text-cyan-400 hover:text-cyan-300 font-medium"
                >
                    {{ __('public-faq.empty.cta') }} →
                </a>
            </div>
        @else
            <div class="rounded-xl border border-slate-800/80 bg-slate-950/40 px-4 sm:px-6 mb-10">
                @foreach ($faqs as $faq)
                    @include('public.partials.faq-item', [
                        'faq' => $faq,
                        'showModule' => $showModuleOnItems,
                    ])
                @endforeach
            </div>

            @if ($faqs->hasPages())
                <x-public.pagination-nav :paginator="$faqs" />
            @endif
        @endif
    </div>
</x-public.layout>
