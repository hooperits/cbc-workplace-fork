{{--
  Module-aware icon for FAQ UI.
  Vars: $module (string|FaqModule), $size (sm|md), $withBg (bool)
--}}
@php
    $module = $module ?? 'general';
    $size = $size ?? 'md';
    $withBg = $withBg ?? true;

    $value = $module instanceof \App\Enums\FaqModule
        ? $module->value
        : (string) $module;

    $sizeClass = $size === 'sm' ? 'h-4 w-4' : 'h-5 w-5';
    $boxClass = $size === 'sm' ? 'h-7 w-7 rounded-lg' : 'h-10 w-10 rounded-xl';

    $theme = match ($value) {
        'venture' => [
            'fg' => 'text-amber-300',
            'bg' => 'bg-amber-500/15 border-amber-500/25',
        ],
        'job_board' => [
            'fg' => 'text-cyan-300',
            'bg' => 'bg-cyan-500/15 border-cyan-500/25',
        ],
        'all' => [
            'fg' => 'text-slate-200',
            'bg' => 'bg-slate-700/40 border-slate-600/40',
        ],
        default => [
            'fg' => 'text-violet-300',
            'bg' => 'bg-violet-500/15 border-violet-500/25',
        ],
    };

    $wrapperClass = $withBg
        ? "inline-flex shrink-0 items-center justify-center border shadow-sm {$boxClass} {$theme['bg']} {$theme['fg']}"
        : "inline-flex shrink-0 {$theme['fg']}";
@endphp

<span class="{{ $wrapperClass }}" aria-hidden="true">
    @switch($value)
        @case('venture')
            {{-- Light bulb --}}
            <svg class="{{ $sizeClass }}" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.75">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 18v-5.25m0 0a6.01 6.01 0 001.5-.189m-1.5.189a6.01 6.01 0 01-1.5-.189m3.75 7.478a12.06 12.06 0 01-4.5 0m3.75 2.383a14.406 14.406 0 01-3 0M14.25 18v-.192c0-.983.658-1.823 1.508-2.316a7.5 7.5 0 10-7.517 0c.85.493 1.509 1.333 1.509 2.316V18" />
            </svg>
            @break

        @case('job_board')
            {{-- Briefcase --}}
            <svg class="{{ $sizeClass }}" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.75">
                <path stroke-linecap="round" stroke-linejoin="round" d="M20.25 14.15v4.25c0 1.094-.787 2.036-1.872 2.18-2.087.277-4.216.42-6.378.42s-4.291-.143-6.378-.42c-1.085-.144-1.872-1.086-1.872-2.18v-4.25m16.5 0a2.18 2.18 0 00.75-1.661V8.706c0-1.081-.768-2.015-1.837-2.175a48.114 48.114 0 00-3.413-.387m4.5 2.006L16.5 8.706m0 0V4.875c0-.621-.504-1.125-1.125-1.125H8.625c-.621 0-1.125.504-1.125 1.125v3.831m9 0a48.667 48.667 0 00-9 0m9 0h-9" />
            </svg>
            @break

        @case('all')
            {{-- Grid --}}
            <svg class="{{ $sizeClass }}" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.75">
                <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6A2.25 2.25 0 016 3.75h2.25A2.25 2.25 0 0110.5 6v2.25a2.25 2.25 0 01-2.25 2.25H6a2.25 2.25 0 01-2.25-2.25V6zM3.75 15.75A2.25 2.25 0 016 13.5h2.25a2.25 2.25 0 012.25 2.25V18a2.25 2.25 0 01-2.25 2.25H6A2.25 2.25 0 013.75 18v-2.25zM13.5 6a2.25 2.25 0 012.25-2.25H18A2.25 2.25 0 0120.25 6v2.25A2.25 2.25 0 0118 10.5h-2.25a2.25 2.25 0 01-2.25-2.25V6zM13.5 15.75a2.25 2.25 0 012.25-2.25H18a2.25 2.25 0 012.25 2.25V18A2.25 2.25 0 0118 20.25h-2.25A2.25 2.25 0 0113.5 18v-2.25z" />
            </svg>
            @break

        @default
            {{-- Question mark circle --}}
            <svg class="{{ $sizeClass }}" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.75">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9.879 7.519c1.171-1.025 3.071-1.025 4.242 0 1.172 1.025 1.172 2.687 0 3.712-.203.179-.43.326-.67.442-.745.361-1.45.999-1.45 1.827v.75M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9 5.25h.008v.008H12v-.008z" />
            </svg>
    @endswitch
</span>
