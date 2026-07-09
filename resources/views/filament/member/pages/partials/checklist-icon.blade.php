@props([
    'done' => false,
    'pending' => false,
    'neutral' => false,
])

@if ($done)
    <span class="flex h-6 w-6 shrink-0 items-center justify-center rounded-lg bg-gradient-to-br from-teal-500/20 to-emerald-500/10 border border-teal-500/40 text-teal-400 shadow-[0_0_10px_rgba(20,184,166,0.1)]" aria-hidden="true">
        <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3">
            <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" />
        </svg>
    </span>
@elseif ($pending)
    <span class="flex h-6 w-6 shrink-0 items-center justify-center rounded-lg bg-gradient-to-br from-amber-500/20 to-orange-500/10 border border-amber-500/40 text-amber-400 animate-pulse shadow-[0_0_10px_rgba(245,158,11,0.15)]" aria-hidden="true">
        <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
            <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" />
        </svg>
    </span>
@elseif ($neutral)
    <span class="flex h-6 w-6 shrink-0 items-center justify-center rounded-lg bg-gradient-to-br from-cyan-500/20 to-blue-500/10 border border-cyan-500/40 text-cyan-400 shadow-[0_0_10px_rgba(6,182,212,0.1)]" aria-hidden="true">
        <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
            <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3" />
        </svg>
    </span>
@else
    <span class="flex h-6 w-6 shrink-0 items-center justify-center rounded-lg bg-slate-900/60 border border-slate-800 text-slate-600 transition-colors duration-300" aria-hidden="true">
        <span class="h-1.5 w-1.5 rounded-full bg-slate-700"></span>
    </span>
@endif

