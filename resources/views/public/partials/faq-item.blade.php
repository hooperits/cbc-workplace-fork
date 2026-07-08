@props(['faq', 'open' => false])

@php
    $moduleLabel = $faq->module?->getLabel() ?? '';
    $moduleColor = match ($faq->module?->value) {
        'venture' => 'bg-amber-500/10 text-amber-300 border-amber-500/20',
        'job_board' => 'bg-cyan-500/10 text-cyan-300 border-cyan-500/20',
        default => 'bg-slate-800/80 text-slate-300 border-slate-700/50',
    };
@endphp

<details
    class="group bg-slate-900/50 border border-slate-800/70 rounded-2xl overflow-hidden transition-all hover:border-slate-700/90 shadow-sm"
    @if ($open) open @endif
>
    <summary class="flex items-center justify-between gap-4 px-5 sm:px-6 py-5 cursor-pointer list-none select-none hover:bg-slate-900/40 transition-colors">
        <div class="flex items-start gap-3 pr-2 min-w-0">
            <div class="mt-0.5 shrink-0 text-cyan-400" aria-hidden="true">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 4.01V8" />
                </svg>
            </div>
            <div class="min-w-0 space-y-2">
                @if ($moduleLabel)
                    <span class="inline-flex items-center px-2 py-0.5 rounded-md text-[11px] font-semibold border {{ $moduleColor }}">
                        {{ $moduleLabel }}
                    </span>
                @endif
                <span class="block font-semibold text-white text-[15px] leading-snug">{{ $faq->question }}</span>
            </div>
        </div>
        <div class="ml-auto shrink-0 text-slate-400 group-open:rotate-180 transition-transform" aria-hidden="true">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
            </svg>
        </div>
    </summary>
    <div class="px-5 sm:px-6 pb-7 pt-4 border-t border-slate-800/60">
        <div class="prose prose-invert prose-sm sm:prose-base max-w-none text-slate-300 leading-relaxed">
            {!! $faq->answer !!}
        </div>

        @if ($faq->hasVideo())
            <div class="mt-6">
                <div class="aspect-video w-full max-w-2xl rounded-xl overflow-hidden border border-slate-700 shadow-lg bg-black">
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
            </div>
        @endif
    </div>
</details>
