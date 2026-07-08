@props([
    'active' => null, // 'bolsa' | 'emprendimientos' | null
])

@php
    $linkBase = 'ldf-nav-link';
    $linkIdle = 'ldf-nav-link--idle';
    $linkActive = 'ldf-nav-link--active';
@endphp

<header class="ldf-site-header sticky top-0 z-50 bg-slate-950/80 backdrop-blur-md border-b border-slate-900" role="banner">
    <div class="ldf-site-header__inner max-w-6xl mx-auto px-6 py-5 flex items-center justify-between">
        <a href="{{ url('/') }}" class="brand-logo ldf-site-header__brand flex items-center hover:opacity-90 transition-opacity">
            <img src="{{ asset('images/logo.png') }}" alt="Lazos de Fe" class="ldf-site-header__logo h-12 md:h-16 w-auto">
        </a>
        <div class="ldf-site-header__actions flex items-center gap-10">
            <nav aria-label="{{ __('Navegación principal') }}" class="ldf-site-header__nav text-sm flex gap-12 items-center">
                <a
                    href="{{ url('/bolsa-de-trabajo') }}"
                    class="{{ $linkBase }} {{ $active === 'bolsa' ? $linkActive : $linkIdle }} text-slate-300 hover:text-cyan-400 font-medium transition-colors relative after:absolute after:-bottom-1 after:left-0 after:h-px after:bg-cyan-400 after:transition-all {{ $active === 'bolsa' ? 'text-cyan-400 after:w-full' : 'after:w-0 hover:after:w-full' }}"
                    @if ($active === 'bolsa') aria-current="page" @endif
                >
                    {{ __('public.listing.title') }}
                </a>
                <a
                    href="{{ url('/app') }}"
                    class="{{ $linkBase }} {{ $active === 'emprendimientos' ? $linkActive : $linkIdle }} text-slate-300 hover:text-cyan-400 font-medium transition-colors relative after:absolute after:-bottom-1 after:left-0 after:h-px after:bg-cyan-400 after:transition-all {{ $active === 'emprendimientos' ? 'text-cyan-400 after:w-full' : 'after:w-0 hover:after:w-full' }}"
                    @if ($active === 'emprendimientos') aria-current="page" @endif
                >
                    {{ __('Emprendimientos') }}
                </a>
                <a
                    href="{{ url('/preguntas-frecuentes') }}"
                    class="{{ $linkBase }} {{ $active === 'faq' ? $linkActive : $linkIdle }} text-slate-300 hover:text-cyan-400 font-medium transition-colors relative after:absolute after:-bottom-1 after:left-0 after:h-px after:bg-cyan-400 after:transition-all {{ $active === 'faq' ? 'text-cyan-400 after:w-full' : 'after:w-0 hover:after:w-full' }}"
                    @if ($active === 'faq') aria-current="page" @endif
                >
                    {{ __('public-faq.nav') }}
                </a>
                @auth('member')
                    <a
                        href="{{ url()->route('filament.member.resources.favorites.index') }}"
                        class="{{ $linkBase }} {{ $linkIdle }} text-slate-300 hover:text-cyan-400 font-medium transition-colors relative after:absolute after:-bottom-1 after:left-0 after:h-px after:w-0 after:bg-cyan-400 hover:after:w-full after:transition-all"
                    >
                        {{ __('Mis Favoritos') }}
                    </a>
                @endauth
            </nav>
            <a href="{{ url('/member') }}"
               class="ldf-site-header__member text-slate-300 hover:text-cyan-400 transition-all hover:scale-110"
               title="Acceso Miembros"
               aria-label="Acceso a Miembros">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                </svg>
            </a>
        </div>
    </div>
</header>
