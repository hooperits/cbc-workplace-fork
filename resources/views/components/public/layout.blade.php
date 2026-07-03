<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title }} — Lazos de Fe</title>

    <!-- Favicons generated from the Lazos de Fe logo -->
    <link rel="icon" href="/favicon.ico">
    <link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="48x48" href="/favicon-48x48.png">
    <link rel="apple-touch-icon" sizes="180x180" href="/favicon-180x180.png">

    @if ($description)
        <meta name="description" content="{{ $description }}">
    @endif

    @if ($canonical)
        <link rel="canonical" href="{{ $canonical }}">
    @endif

    @if ($noindex)
        <meta name="robots" content="noindex,follow">
    @endif

    {{-- Google Fonts: Outfit for headings, Inter for body --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Outfit:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    {{ $head ?? '' }}
    @stack('head')

    @if (file_exists(public_path('build/manifest.json')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @endif

    <style>
        body {
            font-family: 'Inter', sans-serif;
            font-size: 15px;
            line-height: 1.65;
        }
        h1, h2, h3, .brand-logo {
            font-family: 'Outfit', sans-serif;
            line-height: 1.15;
        }
        :focus-visible { 
            outline: 3px solid #06b6d4; 
            outline-offset: 2px; 
        }
        .skip-link {
            position: absolute; left: -9999px; top: auto; width: 1px; height: 1px; overflow: hidden;
        }
        .skip-link:focus {
            position: static; width: auto; height: auto;
            background: #0891b2; color: #ffffff; padding: 0.5rem 1rem; display: inline-block;
            border-radius: 0.375rem;
        }
        /* Custom scrollbar for premium look */
        ::-webkit-scrollbar {
            width: 8px;
        }
        ::-webkit-scrollbar-track {
            background: #0f172a;
        }
        ::-webkit-scrollbar-thumb {
            background: #334155;
            border-radius: 9999px;
        }
        ::-webkit-scrollbar-thumb:hover {
            background: #475569;
        }
    </style>
</head>
<body class="min-h-screen bg-slate-950 bg-gradient-to-br from-slate-900 via-slate-950 to-black text-slate-100 antialiased selection:bg-cyan-500 selection:text-white">
    <a href="#main" class="skip-link">{{ __('Saltar al contenido principal') }}</a>

    <header class="sticky top-0 z-50 bg-slate-950/80 backdrop-blur-md border-b border-slate-900" role="banner">
        <div class="max-w-6xl mx-auto px-6 py-5 flex items-center justify-between">
            <a href="{{ url('/') }}" class="brand-logo flex items-center hover:opacity-90 transition-opacity">
                <img src="{{ asset('images/logo.png') }}" alt="Lazos de Fe" class="h-12 md:h-16 w-auto">
            </a>
            <div class="flex items-center gap-10">
                <nav aria-label="{{ __('Navegación principal') }}" class="text-sm flex gap-12 items-center">
                    <a href="{{ url('/bolsa-de-trabajo') }}" class="text-slate-300 hover:text-cyan-400 font-medium transition-colors relative after:absolute after:-bottom-1 after:left-0 after:h-px after:w-0 after:bg-cyan-400 hover:after:w-full after:transition-all">
                        {{ __('public.listing.title') }}
                    </a>
                    <a href="{{ url('/app') }}" class="text-slate-300 hover:text-cyan-400 font-medium transition-colors relative after:absolute after:-bottom-1 after:left-0 after:h-px after:w-0 after:bg-cyan-400 hover:after:w-full after:transition-all">
                        {{ __('Emprendimientos') }}
                    </a>
                </nav>
                <a href="{{ url('/member') }}"
                   class="text-slate-300 hover:text-cyan-400 transition-all hover:scale-110"
                   title="Acceso Miembros"
                   aria-label="Acceso a Miembros">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                    </svg>
                </a>
            </div>
        </div>
    </header>

    <main id="main" role="main" class="max-w-6xl mx-auto px-6 py-16">
        {{ $slot }}
    </main>

    <footer role="contentinfo" class="border-t border-slate-800/60 bg-slate-950/40 mt-20 py-10 text-center text-xs text-slate-500">
        <div class="max-w-6xl mx-auto px-6">
            &copy; {{ date('Y') }} Lazos de Fe. Todos los derechos reservados.
        </div>
    </footer>
</body>
</html>
