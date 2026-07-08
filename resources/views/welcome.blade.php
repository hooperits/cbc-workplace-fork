<x-public.layout
    title="Conectando Propósito y Talento"
    description="Lazos de Fe es la plataforma de empleo y colaboración que une a profesionales comprometidos con organizaciones y emprendimientos alineados con valores y principios éticos compartidos."
>
    {{-- Hero Section --}}
    <section class="relative overflow-hidden py-20 md:py-28 text-center md:text-left">
        <div class="absolute inset-0 bg-gradient-to-tr from-cyan-500/10 via-teal-500/5 to-transparent blur-3xl pointer-events-none"></div>

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 items-center">
            <div class="lg:col-span-7 space-y-6">
                <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full text-sm font-semibold bg-cyan-500/10 text-cyan-300 border border-cyan-500/20 shadow-sm">
                    ✨ Plataforma Oficial de Empleo y Emprendimiento
                </div>
                <h1 class="mt-2 text-4xl sm:text-5xl lg:text-6xl font-extrabold tracking-tight text-white leading-tight">
                    Conectando el <span class="bg-gradient-to-r from-cyan-400 via-teal-400 to-amber-400 bg-clip-text text-transparent">talento</span> con el propósito eterno
                </h1>
                <p class="text-slate-200 text-[17px] max-w-2xl font-light leading-relaxed">
                    Lazos de Fé es una plataforma impulsada por la comunidad de Crossroads Bible Church (CBC) que permite publicar, descubrir y conectar con emprendimientos (productos y servicios) de hermanos y hermanas que comparten los mismos valores de fe.
                </p>
                <p class="mt-4 text-slate-400 text-[15px] max-w-2xl font-light leading-relaxed">
                    El propósito es fortalecer la economía colaborativa dentro de la congregación y más allá, ofreciendo un espacio seguro, moderado y alineado con los principios cristianos que promovemos en CBC. Aquí puedes encontrar desde servicios profesionales hasta productos artesanales, todos ofrecidos por personas que desean honrar a Dios con su trabajo.
                </p>
                <div class="pt-8 flex flex-wrap gap-4 justify-center md:justify-start">
                    <a
                        href="{{ url('/bolsa-de-trabajo') }}"
                        class="inline-flex items-center justify-center px-6 py-3.5 bg-gradient-to-r from-cyan-600 to-teal-600 hover:from-cyan-500 hover:to-teal-500 text-white font-bold rounded-xl hover:-translate-y-0.5 transition-all duration-300 shadow-lg hover:shadow-cyan-500/25 active:scale-95 text-sm"
                    >
                        Explorar Bolsa de Trabajo <span class="ml-2">→</span>
                    </a>
                    <a
                        href="{{ url('/app') }}"
                        class="inline-flex items-center justify-center px-6 py-3.5 border border-amber-500/30 bg-amber-500/5 text-amber-300 font-bold rounded-xl hover:bg-amber-500/10 hover:text-amber-200 transition-all duration-300 active:scale-95 shadow-sm text-sm"
                    >
                        Directorio de Emprendimientos
                    </a>
                </div>
            </div>

            <div class="lg:col-span-5 relative">
                <div class="absolute -inset-1 bg-gradient-to-r from-cyan-500 to-teal-600 rounded-2xl blur opacity-25 group-hover:opacity-100 transition duration-1000 group-hover:duration-200"></div>
                <div class="relative bg-slate-900/60 border border-slate-800/80 p-8 rounded-2xl backdrop-blur-md shadow-2xl transition-all hover:border-slate-700">
                    <div class="flex items-center justify-between pb-5 border-b border-slate-700/60 mb-6">
                        <span class="font-semibold text-slate-100 text-lg">Actividad de la Comunidad</span>
                        <span class="w-3.5 h-3.5 rounded-full bg-emerald-500 animate-ping"></span>
                    </div>
                    <div class="space-y-5">
                        <div class="flex items-center justify-between">
                            <span class="text-slate-400 text-[13px]">Emprendimientos activos</span>
                            <span class="font-semibold text-cyan-300 bg-cyan-500/10 border border-cyan-500/20 px-3.5 py-1 rounded-lg text-xl tabular-nums tracking-tighter">{{ $venturesCount }}</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-slate-400 text-[13px]">Ofertas laborales abiertas</span>
                            <span class="font-semibold text-amber-300 bg-amber-500/10 border border-amber-500/20 px-3.5 py-1 rounded-lg text-xl tabular-nums tracking-tighter">{{ $jobsCount }}</span>
                        </div>
                    </div>

                    <div class="pt-5 mt-6 border-t border-slate-700/50 text-[12px] tracking-wider text-slate-500">
                        Impulsado por la comunidad de Crossroads Bible Church
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Versículo de Inspiración --}}
    <section class="py-16 border-t border-slate-800/60">
        <div class="max-w-4xl mx-auto">
            <div class="bg-slate-900/30 border border-slate-800/60 rounded-2xl px-10 py-12 text-center">
                <div class="inline-flex items-center gap-2 mb-5 px-4 py-1 rounded-full bg-amber-500/10 text-amber-300 text-sm font-semibold border border-amber-500/20">
                    ✨ Versículo de Inspiración
                </div>
                @php
                    $versiculo = \App\Models\Text::getText('versiculo-de-inspiracion');
                    $versiculoRef = $versiculo[0] ?? 'Proverbios 16:3';
                    $versiculoText = $versiculo[1] ?? 'Pon en manos del Señor todas tus obras, y tus proyectos se cumplirán.';
                @endphp
                <blockquote class="text-2xl md:text-3xl font-medium text-white leading-snug tracking-tight">
                    “{{ $versiculoText }}”
                </blockquote>
                <cite class="block mt-5 text-amber-300 font-medium text-sm tracking-wider">{{ $versiculoRef }}</cite>
            </div>
        </div>
    </section>

    {{-- Preguntas Frecuentes (preview por módulo) --}}
    <section class="py-20 border-t border-slate-800/60">
        <div class="max-w-6xl mx-auto">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-semibold text-white tracking-tight">{{ __('public-faq.home.title') }}</h2>
                <p class="mt-4 text-slate-400 text-[15px]">{{ __('public-faq.home.subtitle') }}</p>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                <div>
                    <h3 class="text-sm font-semibold uppercase tracking-wider text-amber-300 mb-4 flex items-center gap-2">
                        <span class="w-2 h-2 rounded-full bg-amber-400"></span>
                        {{ __('public-faq.home.venture_heading') }}
                    </h3>
                    <div class="space-y-3">
                        @forelse($ventureFaqs as $faq)
                            @include('public.partials.faq-item', ['faq' => $faq])
                        @empty
                            <p class="text-sm text-slate-500 py-4">—</p>
                        @endforelse
                    </div>
                </div>
                <div>
                    <h3 class="text-sm font-semibold uppercase tracking-wider text-cyan-300 mb-4 flex items-center gap-2">
                        <span class="w-2 h-2 rounded-full bg-cyan-400"></span>
                        {{ __('public-faq.home.job_board_heading') }}
                    </h3>
                    <div class="space-y-3">
                        @forelse($jobBoardFaqs as $faq)
                            @include('public.partials.faq-item', ['faq' => $faq])
                        @empty
                            <p class="text-sm text-slate-500 py-4">—</p>
                        @endforelse
                    </div>
                </div>
            </div>

            <div class="mt-12 text-center">
                <a
                    href="{{ url('/preguntas-frecuentes') }}"
                    class="inline-flex items-center justify-center px-6 py-3.5 border border-cyan-500/30 bg-cyan-500/10 text-cyan-300 font-bold rounded-xl hover:bg-cyan-500/20 transition-all duration-300 text-sm"
                >
                    {{ __('public-faq.home.view_all') }} <span class="ml-2">→</span>
                </a>
            </div>
        </div>
    </section>
</x-public.layout>