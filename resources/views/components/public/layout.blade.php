@props([
    'title' => '',
    'description' => null,
    'canonical' => null,
    'noindex' => false,
    'active' => null, // 'bolsa' | 'emprendimientos' | null
])

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

    @include('components.public.partials.fonts')

    {{ $head ?? '' }}
    @stack('head')

    @if (file_exists(public_path('build/manifest.json')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @endif

    @include('components.public.partials.shell-styles')
</head>
<body class="min-h-screen bg-slate-950 bg-gradient-to-br from-slate-900 via-slate-950 to-black text-slate-100 antialiased selection:bg-cyan-500 selection:text-white">
    <a href="#main" class="skip-link">{{ __('Saltar al contenido principal') }}</a>

    @include('components.public.partials.header', ['active' => $active])

    <main id="main" role="main" class="max-w-6xl mx-auto px-6 py-16">
        {{ $slot }}
    </main>

    @include('components.public.partials.footer')
</body>
</html>
