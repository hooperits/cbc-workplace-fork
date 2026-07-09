{{--
  Colored icon tile for job-board hub quick links.
  Vars: $icon (string), $withBg (bool, default true)
--}}
@php
    $icon = $icon ?? 'search';
    $withBg = $withBg ?? true;

    $palette = match ($icon) {
        'document' => [
            'fg' => 'text-cyan-300',
            'bg' => 'bg-cyan-500/15 border-cyan-500/30',
        ],
        'plane' => [
            'fg' => 'text-sky-300',
            'bg' => 'bg-sky-500/15 border-sky-500/30',
        ],
        'bell' => [
            'fg' => 'text-violet-300',
            'bg' => 'bg-violet-500/15 border-violet-500/30',
        ],
        'building' => [
            'fg' => 'text-amber-300',
            'bg' => 'bg-amber-500/15 border-amber-500/30',
        ],
        'briefcase' => [
            'fg' => 'text-orange-300',
            'bg' => 'bg-orange-500/15 border-orange-500/30',
        ],
        default => [
            'fg' => 'text-teal-300',
            'bg' => 'bg-teal-500/15 border-teal-500/30',
        ],
    };

    $wrap = $withBg
        ? "inline-flex h-10 w-10 items-center justify-center rounded-xl border {$palette['bg']} {$palette['fg']}"
        : "inline-flex {$palette['fg']}";
@endphp

<span class="{{ $wrap }}" aria-hidden="true">
    @switch($icon)
        @case('document')
            <svg class="h-5.5 w-5.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.75">
                <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" />
                <path fill="currentColor" fill-opacity="0.15" d="M9 11.25h6v1.5H9zm0 3h3v1.5H9z" />
            </svg>
            @break
        @case('plane')
            <svg class="h-5.5 w-5.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.75">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6 12L3.269 3.126A59.768 59.768 0 0121.485 12 59.77 59.77 0 013.27 20.876L5.999 12zm0 0h7.5" />
                <path fill="currentColor" fill-opacity="0.12" d="M21.485 12L3.269 3.126L5.999 12H13.5z" />
            </svg>
            @break
        @case('bell')
            <svg class="h-5.5 w-5.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.75">
                <path stroke-linecap="round" stroke-linejoin="round" d="M14.857 17.082a23.848 23.848 0 005.454-1.31A8.967 8.967 0 0118 9.75V9A6 6 0 006 9v.75a8.967 8.967 0 01-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 01-5.714 0m5.714 0a3 3 0 11-5.714 0" />
                <path fill="currentColor" fill-opacity="0.15" d="M12 3a6 6 0 00-6 6v.75a8.967 8.967 0 01-2.312 6.022h16.624A8.967 8.967 0 0118 9.75V9a6 6 0 00-6-6z" />
            </svg>
            @break
        @case('building')
            <svg class="h-5.5 w-5.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.75">
                <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 21h19.5m-18-18v18m10.5-18v18m6-13.5V21M6.75 6.75h.75m-.75 3h.75m-.75 3h.75m3-6h.75m-.75 3h.75m-.75 3h.75M6.75 21v-3.375c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21M3 3h12m-.75 4.5H21m-3.75 3.75h.008v.008h-.008v-.008zm0 3h.008v.008h-.008v-.008zm0 3h.008v.008h-.008v-.008z" />
                <path fill="currentColor" fill-opacity="0.12" d="M3 3h12v18H3zm13.5 4.5H21V21h-4.5z" />
            </svg>
            @break
        @case('briefcase')
            <svg class="h-5.5 w-5.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.75">
                <path stroke-linecap="round" stroke-linejoin="round" d="M20.25 14.15v4.25c0 1.094-.787 2.036-1.872 2.18-2.087.277-4.216.42-6.378.42s-4.291-.143-6.378-.42c-1.085-.144-1.872-1.086-1.872-2.18v-4.25m16.5 0a2.18 2.18 0 00.75-1.661V8.706c0-1.081-.768-2.015-1.837-2.175a48.114 48.114 0 00-3.413-.387m4.5 2.006L16.5 8.706m0 0V4.875c0-.621-.504-1.125-1.125-1.125H8.625c-.621 0-1.125.504-1.125 1.125v3.831m9 0a48.667 48.667 0 00-9 0m9 0h-9" />
                <path fill="currentColor" fill-opacity="0.12" d="M3.75 8.706V14.15h16.5V8.706a48.114 48.114 0 01-16.5 0z" />
            </svg>
            @break
        @default
            <svg class="h-5.5 w-5.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.75">
                <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" />
                <circle cx="10.5" cy="10.5" r="6" fill="currentColor" fill-opacity="0.15" />
            </svg>
    @endswitch
</span>
