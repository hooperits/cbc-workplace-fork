@php
    $currentPage = $paginator->currentPage();
    $lastPage = $paginator->lastPage();

    // Compact page-window: always show first, last, current, and neighbors.
    $window = collect(range(max(1, $currentPage - 2), min($lastPage, $currentPage + 2)))
        ->prepend($currentPage > 4 ? 1 : null)
        ->push($currentPage < $lastPage - 3 ? $lastPage : null)
        ->filter()
        ->unique()
        ->sort()
        ->values();
@endphp

<nav
    aria-label="{{ __('Paginación de resultados') }}"
    class="flex flex-wrap items-center justify-center gap-1 mt-8"
    role="navigation"
>
    @if ($paginator->onFirstPage())
        <span class="px-3 py-2 text-slate-500 cursor-default" aria-disabled="true">
            ‹ {{ __('Anterior') }}
        </span>
    @else
        <a
            href="{{ $paginator->previousPageUrl() }}"
            rel="prev"
            aria-label="{{ __('Página anterior') }}"
            class="px-3 py-2 text-cyan-400 hover:text-cyan-300 focus:outline-none focus-visible:ring-2 focus-visible:ring-cyan-500 rounded"
        >
            ‹ {{ __('Anterior') }}
        </a>
    @endif

    @php $previous = null; @endphp
    @foreach ($window as $page)
        @if ($previous !== null && $page !== $previous + 1)
            <span class="px-2 text-slate-500" aria-hidden="true">…</span>
        @endif

        @if ($page === $currentPage)
            <span
                aria-current="page"
                class="px-3 py-2 bg-cyan-600 text-white rounded-lg font-semibold shadow-sm"
            >
                {{ $page }}
            </span>
        @else
            <a
                href="{{ $paginator->url($page) }}"
                aria-label="{{ __('Página :n', ['n' => $page]) }}"
                class="px-3 py-2 text-cyan-400 hover:text-cyan-300 hover:bg-cyan-500/10 focus:outline-none focus-visible:ring-2 focus-visible:ring-cyan-500 rounded-lg"
            >
                {{ $page }}
            </a>
        @endif

        @php $previous = $page; @endphp
    @endforeach

    @if ($paginator->hasMorePages())
        <a
            href="{{ $paginator->nextPageUrl() }}"
            rel="next"
            aria-label="{{ __('Página siguiente') }}"
            class="px-3 py-2 text-cyan-400 hover:text-cyan-300 focus:outline-none focus-visible:ring-2 focus-visible:ring-cyan-500 rounded"
        >
            {{ __('Siguiente') }} ›
        </a>
    @else
        <span class="px-3 py-2 text-slate-500 cursor-default" aria-disabled="true">
            {{ __('Siguiente') }} ›
        </span>
    @endif
</nav>
