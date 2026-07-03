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
                    [$versiculoRef, $versiculoText] = \App\Models\Text::getText('versiculo-de-inspiracion');
                    if (empty($versiculoText)) {
                        $versiculoRef = 'Proverbios 16:3';
                        $versiculoText = 'Pon en manos del Señor todas tus obras, y tus proyectos se cumplirán.';
                    }
                @endphp
                <blockquote class="text-2xl md:text-3xl font-medium text-white leading-snug tracking-tight">
                    “{{ $versiculoText }}”
                </blockquote>
                <cite class="block mt-5 text-amber-300 font-medium text-sm tracking-wider">{{ $versiculoRef }}</cite>
            </div>
        </div>
    </section>

    {{-- Preguntas Frecuentes --}}
    <section class="py-20 border-t border-slate-800/60">
        <div class="max-w-4xl mx-auto">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-semibold text-white tracking-tight">Preguntas Frecuentes</h2>
                <p class="mt-4 text-slate-400 text-[15px]">Respuestas a las dudas más comunes sobre Lazos de Fe</p>
            </div>

            <div class="space-y-3">
                @forelse($faqs as $faq)
                    <details class="group bg-slate-900/50 border border-slate-800/70 rounded-2xl overflow-hidden transition-all hover:border-slate-700">
                        <summary class="flex items-center justify-between px-6 py-5 cursor-pointer list-none select-none hover:bg-slate-900/30 transition-colors">
                            <div class="flex items-start gap-3 pr-4">
                                <div class="mt-0.5 shrink-0 text-amber-400">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 4.01V8" />
                                    </svg>
                                </div>
                                <span class="font-semibold text-white text-[15px] leading-snug">{{ $faq->question }}</span>
                            </div>
                            <div class="ml-auto shrink-0 text-slate-400 group-open:rotate-180 transition-transform">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                                </svg>
                            </div>
                        </summary>
                        <div class="px-6 pb-7 pt-4 border-t border-slate-800/60">
                            <div class="prose prose-invert prose-[15px] max-w-none text-slate-300 leading-relaxed">
                                {!! $faq->answer !!}
                            </div>

                            @if($faq->hasVideo())
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
                @empty
                    <div class="text-center py-8 text-slate-400">
                        Aún no hay preguntas frecuentes publicadas.
                    </div>
                @endforelse
            </div>
        </div>
    </section>
</x-public.layout>