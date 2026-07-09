@props([
    'faq',
    'open' => false,
    'showModule' => true,
])

@php
    $moduleValue = $faq->module?->value ?? 'general';
    $moduleLabel = $faq->module?->getLabel() ?? '';
    $accent = match ($moduleValue) {
        'venture' => 'border-l-amber-400/80',
        'job_board' => 'border-l-cyan-400/80',
        default => 'border-l-violet-400/70',
    };
@endphp

<details
    class="group border-b border-slate-800/80 last:border-b-0 border-l-2 {{ $accent }} pl-4 sm:pl-5 transition-colors open:bg-slate-900/25"
    @if ($open) open @endif
>
    <summary class="flex items-center gap-3 sm:gap-4 py-4 sm:py-5 cursor-pointer list-none select-none [&::-webkit-details-marker]:hidden">
        <div class="min-w-0 flex-1">
            @if ($showModule && $moduleLabel)
                <p class="text-[11px] font-medium uppercase tracking-wider text-slate-500 mb-1">
                    {{ $moduleLabel }}
                    @if ($faq->hasVideo())
                        <span class="text-slate-600">·</span>
                        <span class="text-slate-500 normal-case tracking-normal">Video</span>
                    @endif
                </p>
            @elseif ($faq->hasVideo())
                <p class="text-[11px] font-medium text-slate-500 mb-1">Video</p>
            @endif
            <span class="block text-[15px] sm:text-base font-medium text-slate-100 leading-snug group-hover:text-white transition-colors">
                {{ $faq->question }}
            </span>
        </div>

        <span
            class="shrink-0 flex h-8 w-8 items-center justify-center rounded-full text-slate-500 group-hover:text-slate-300 group-open:text-cyan-400 group-open:rotate-180 transition-all duration-200"
            aria-hidden="true"
        >
            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.75">
                <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
            </svg>
        </span>
    </summary>

    <div class="pb-5 pr-2 sm:pr-10 -mt-1">
        <div class="prose prose-invert prose-sm max-w-none text-slate-400 leading-relaxed prose-p:my-2 prose-a:text-cyan-400">
            {!! $faq->answer !!}
        </div>

        @if ($faq->hasVideo())
            <div class="mt-5 aspect-video w-full max-w-xl rounded-lg overflow-hidden border border-slate-800 bg-black">
                <iframe
                    class="w-full h-full border-0"
                    src="https://www.youtube-nocookie.com/embed/{{ $faq->youtube_id }}?rel=0"
                    title="{{ $faq->question }}"
                    loading="lazy"
                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                    referrerpolicy="strict-origin-when-cross-origin"
                    allowfullscreen>
                </iframe>
            </div>
        @endif
    </div>
</details>
