@php
    use App\Enums\FaqModule;

    $moduleTabs = collect([
        ['value' => 'all', 'label' => __('public-faq.filters.all')],
        ...collect(FaqModule::cases())->map(fn (FaqModule $m) => [
            'value' => $m->value,
            'label' => $m->getLabel(),
        ])->all(),
    ]);
@endphp

<x-public.layout
    :title="__('public-faq.title')"
    :description="__('public-faq.subtitle')"
    :canonical="url('/preguntas-frecuentes')"
    :noindex="$searchQuery !== '' || $activeModule !== 'all' || request()->integer('page', 1) > 1"
    active="faq"
>
    <header class="mb-10">
        <h1 class="text-4xl font-extrabold tracking-tight bg-gradient-to-r from-white via-slate-100 to-slate-400 bg-clip-text text-transparent sm:text-5xl">
            {{ __('public-faq.title') }}
        </h1>
        <p class="text-slate-400 mt-2 text-lg max-w-2xl font-light">
            {{ __('public-faq.subtitle') }}
        </p>
    </header>

    <form
        method="GET"
        action="{{ url('/preguntas-frecuentes') }}"
        class="mb-8 space-y-5"
        role="search"
        aria-label="{{ __('public-faq.title') }}"
        id="faq-search-form"
    >
        <div class="flex flex-col sm:flex-row gap-3">
            <label class="flex-1 block">
                <span class="sr-only">{{ __('public-faq.search_placeholder') }}</span>
                <input
                    type="search"
                    name="q"
                    value="{{ $searchQuery }}"
                    placeholder="{{ __('public-faq.search_placeholder') }}"
                    maxlength="200"
                    class="w-full px-4 py-3 bg-slate-900/60 border border-slate-800 text-slate-100 rounded-xl placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-cyan-500 focus:border-cyan-500 transition-all duration-300 backdrop-blur-sm shadow-sm"
                >
            </label>
            <button
                type="submit"
                class="px-5 py-3 bg-cyan-600 hover:bg-cyan-700 text-white font-medium rounded-xl transition-colors shadow-lg"
            >
                {{ __('public-faq.search_submit') }}
            </button>
        </div>

        @if ($activeModule !== 'all')
            <input type="hidden" name="module" value="{{ $activeModule }}">
        @endif

        <div
            class="flex flex-wrap gap-2"
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
                    class="px-4 py-2 rounded-full text-sm font-semibold border transition-all {{ $isActive
                        ? 'bg-cyan-500/20 text-cyan-300 border-cyan-500/40 shadow-sm'
                        : 'bg-slate-900/40 text-slate-300 border-slate-800 hover:border-slate-600 hover:text-white' }}"
                    @if ($isActive) aria-current="page" @endif
                >
                    {{ $tab['label'] }}
                </a>
            @endforeach
        </div>
    </form>

    <div
        class="text-sm text-slate-400 mb-5 bg-slate-900/30 border border-slate-800/50 rounded-lg px-4 py-2 inline-flex items-center gap-2 backdrop-blur-sm shadow-sm"
        role="status"
        aria-live="polite"
    >
        <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
        {{ trans_choice('public-faq.result_count', $faqs->total(), ['count' => $faqs->total()]) }}
    </div>

    @if ($faqs->isEmpty())
        <div class="rounded-2xl border border-slate-800/80 bg-slate-900/40 p-10 text-center" role="status">
            <h2 class="text-xl font-semibold text-white mb-2">{{ __('public-faq.empty.title') }}</h2>
            <p class="text-slate-400 mb-6">{{ __('public-faq.empty.message') }}</p>
            <a
                href="{{ url('/preguntas-frecuentes') }}"
                class="inline-flex px-5 py-2.5 bg-cyan-600 hover:bg-cyan-700 text-white font-medium rounded-xl transition-colors"
            >
                {{ __('public-faq.empty.cta') }}
            </a>
        </div>
    @else
        <ul class="space-y-3 mb-8 list-none p-0" role="list">
            @foreach ($faqs as $faq)
                <li>
                    @include('public.partials.faq-item', ['faq' => $faq])
                </li>
            @endforeach
        </ul>

        @if ($faqs->hasPages())
            <x-public.pagination-nav :paginator="$faqs" />
        @endif
    @endif
</x-public.layout>
