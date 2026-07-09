<x-filament-panels::page>
    {{-- Scoped Styles for Premium Polish, Fixed Colors, and Layout Fallbacks --}}
    <style>
        /* Scoped styles for the Job Board Hub */
        .hub-gradient-hero {
            background: linear-gradient(135deg, #1e293b 0%, #0f172a 100%) !important;
            border: 1px solid #334155 !important;
        }

        /* Responsive Grid Fallbacks */
        .flow-grid {
            display: grid;
            grid-template-columns: repeat(1, minmax(0, 1fr));
            gap: 1.5rem;
        }
        @media (min-width: 1024px) {
            .flow-grid {
                grid-template-columns: repeat(2, minmax(0, 1fr));
                gap: 2rem;
            }
        }

        .quick-links-grid {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 1rem;
        }
        @media (min-width: 640px) {
            .quick-links-grid {
                grid-template-columns: repeat(3, minmax(0, 1fr));
            }
        }
        @media (min-width: 1024px) {
            .quick-links-grid {
                grid-template-columns: repeat(6, minmax(0, 1fr));
            }
        }

        /* Flow path cards */
        .flow-path-card {
            background-color: #1e293b !important; /* Visible slate-800 background for clear contrast */
            border: 1px solid #334155 !important;
            transition: all 0.4s cubic-bezier(0.16, 1, 0.3, 1) !important;
        }
        
        .flow-path-card-candidate {
            border-color: rgba(0, 181, 210, 0.35) !important;
        }
        .flow-path-card-candidate:hover {
            transform: translateY(-4px) !important;
            border-color: rgba(0, 181, 210, 0.8) !important;
            box-shadow: 0 20px 30px -10px rgba(0, 0, 0, 0.7), 0 0 20px 2px rgba(0, 181, 210, 0.25) !important;
        }

        .flow-path-card-employer {
            border-color: rgba(245, 130, 32, 0.35) !important;
        }
        .flow-path-card-employer:hover {
            transform: translateY(-4px) !important;
            border-color: rgba(245, 130, 32, 0.8) !important;
            box-shadow: 0 20px 30px -10px rgba(0, 0, 0, 0.7), 0 0 20px 2px rgba(245, 130, 32, 0.25) !important;
        }

        /* Dynamic icon scaling and arrow slide transitions on hover */
        .flow-path-card:hover .flow-icon-circle {
            transform: scale(1.08) !important;
        }
        .flow-path-card:hover .cta-arrow {
            transform: translateX(4px) !important;
        }

        /* Progress bars with realistic glass cylinders */
        .progress-bar-track {
            background-color: #0f172a !important; /* slate-900 track */
            border: 1px solid rgba(255, 255, 255, 0.05) !important;
        }
        .progress-bar-fill-candidate {
            background: linear-gradient(90deg, #00b5d2, #14b8a6) !important;
            box-shadow: 0 0 8px rgba(0, 181, 210, 0.4) !important;
            position: relative;
        }
        .progress-bar-fill-candidate::after {
            content: '';
            position: absolute;
            inset: 0;
            background: linear-gradient(to bottom, rgba(255,255,255,0.25) 0%, rgba(255,255,255,0) 50%, rgba(0,0,0,0.15) 100%);
        }
        .progress-bar-fill-employer {
            background: linear-gradient(90deg, #f58220, #f97316) !important;
            box-shadow: 0 0 8px rgba(245, 130, 32, 0.4) !important;
            position: relative;
        }
        .progress-bar-fill-employer::after {
            content: '';
            position: absolute;
            inset: 0;
            background: linear-gradient(to bottom, rgba(255,255,255,0.25) 0%, rgba(255,255,255,0) 50%, rgba(0,0,0,0.15) 100%);
        }

        /* Status Chips */
        .chip-success {
            background-color: rgba(20, 184, 166, 0.1) !important;
            color: #5eead4 !important;
            border-color: rgba(20, 184, 166, 0.3) !important;
            box-shadow: 0 0 12px rgba(20, 184, 166, 0.15) !important;
        }
        .chip-warning {
            background-color: rgba(245, 158, 11, 0.1) !important;
            color: #fde047 !important;
            border-color: rgba(245, 158, 11, 0.35) !important;
            box-shadow: 0 0 12px rgba(245, 158, 11, 0.15) !important;
        }
        .chip-danger {
            background-color: rgba(244, 63, 94, 0.1) !important;
            color: #fda4af !important;
            border-color: rgba(244, 63, 94, 0.3) !important;
            box-shadow: 0 0 12px rgba(244, 63, 94, 0.15) !important;
        }
        .chip-default {
            background-color: rgba(148, 163, 184, 0.1) !important;
            color: #cbd5e1 !important;
            border-color: rgba(148, 163, 184, 0.3) !important;
        }

        /* Buttons with high-contrast gradients and required colors */
        .bg-cyan-600 {
            background: linear-gradient(135deg, #00b5d2 0%, #0c97b5 100%) !important;
            border: none !important;
            box-shadow: 0 4px 14px 0 rgba(0, 181, 210, 0.3) !important;
            transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1) !important;
        }
        .bg-cyan-600:hover {
            background: linear-gradient(135deg, #02c3e2 0%, #00b5d2 100%) !important;
            box-shadow: 0 6px 20px 0 rgba(0, 181, 210, 0.5) !important;
            transform: translateY(-1px) !important;
        }
        
        .bg-amber-600 {
            background: linear-gradient(135deg, #f58220 0%, #d86d13 100%) !important;
            border: none !important;
            box-shadow: 0 4px 14px 0 rgba(245, 130, 32, 0.3) !important;
            transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1) !important;
        }
        .bg-amber-600:hover {
            background: linear-gradient(135deg, #ff953f 0%, #f58220 100%) !important;
            box-shadow: 0 6px 20px 0 rgba(245, 130, 32, 0.5) !important;
            transform: translateY(-1px) !important;
        }

        .active-scale:active {
            transform: scale(0.98) !important;
        }

        /* Link Underlines */
        .premium-link {
            position: relative;
        }
        .premium-link::after {
            content: '';
            position: absolute;
            width: 0;
            height: 1px;
            bottom: -2px;
            left: 0;
            background-color: currentColor;
            transition: width 0.25s ease-out;
        }
        .premium-link:hover::after {
            width: 100%;
        }

        /* Quick Links */
        .quick-link-tile {
            background-color: #1e293b !important;
            border: 1px solid #334155 !important;
            transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1) !important;
        }
        .quick-link-tile:hover {
            transform: translateY(-3px) !important;
            background-color: #334155 !important;
        }
        .tile-document:hover { border-color: rgba(0, 181, 210, 0.5) !important; box-shadow: 0 8px 25px -8px rgba(0, 181, 210, 0.3) !important; }
        .tile-plane:hover { border-color: rgba(56, 189, 248, 0.5) !important; box-shadow: 0 8px 25px -8px rgba(56, 189, 248, 0.3) !important; }
        .tile-bell:hover { border-color: rgba(167, 139, 250, 0.5) !important; box-shadow: 0 8px 25px -8px rgba(167, 139, 250, 0.3) !important; }
        .tile-building:hover { border-color: rgba(245, 130, 32, 0.5) !important; box-shadow: 0 8px 25px -8px rgba(245, 130, 32, 0.3) !important; }
        .tile-briefcase:hover { border-color: rgba(251, 146, 60, 0.5) !important; box-shadow: 0 8px 25px -8px rgba(251, 146, 60, 0.3) !important; }
        .tile-search:hover { border-color: rgba(45, 212, 191, 0.5) !important; box-shadow: 0 8px 25px -8px rgba(45, 212, 191, 0.3) !important; }

        /* Floating Network Animation for Hero decoration */
        @keyframes float-gentle {
            0%, 100% { transform: translateY(0px) rotate(0deg); }
            50% { transform: translateY(-8px) rotate(1.5deg); }
        }
        .animate-float {
            animation: float-gentle 6s infinite ease-in-out;
        }
        
        /* Explicit layout settings for constellation to bypass uncompiled Tailwind */
        .constellation-wrapper {
            display: none !important;
            align-items: center !important;
            justify-content: center !important;
            flex-shrink: 0 !important;
            margin-right: 1.5rem !important;
        }
        @media (min-width: 1024px) {
            .constellation-wrapper {
                display: flex !important;
            }
        }
        .hero-constellation {
            color: rgba(6, 182, 212, 0.22) !important;
        }

        /* Ambient Glow Animations */
        @keyframes glow-pulse-cyan {
            0%, 100% { transform: scale(1); opacity: 0.6; box-shadow: 0 0 0 0 rgba(0, 181, 210, 0.4); }
            50% { transform: scale(1.15); opacity: 1; box-shadow: 0 0 10px 2px rgba(0, 181, 210, 0.7); }
        }
        @keyframes glow-pulse-amber {
            0%, 100% { transform: scale(1); opacity: 0.6; box-shadow: 0 0 0 0 rgba(245, 130, 32, 0.4); }
            50% { transform: scale(1.15); opacity: 1; box-shadow: 0 0 10px 2px rgba(245, 130, 32, 0.7); }
        }
        @keyframes glow-pulse-rose {
            0%, 100% { transform: scale(1); opacity: 0.6; box-shadow: 0 0 0 0 rgba(244, 63, 94, 0.4); }
            50% { transform: scale(1.15); opacity: 1; box-shadow: 0 0 10px 2px rgba(244, 63, 94, 0.7); }
        }
        
        .glow-cyan { animation: glow-pulse-cyan 2s infinite ease-in-out; }
        .glow-amber { animation: glow-pulse-amber 2s infinite ease-in-out; }
        .glow-rose { animation: glow-pulse-rose 2s infinite ease-in-out; }
    </style>

    <div class="ldf-jb-hub space-y-8 max-w-6xl mx-auto px-4 sm:px-6">
        {{-- Hero Header --}}
        <header class="relative overflow-hidden rounded-2xl hub-gradient-hero px-6 py-8 sm:px-8 sm:py-10 shadow-2xl">
            {{-- Technical Grid Overlay for Visual Depth --}}
            <svg class="absolute inset-0 -z-10 h-full w-full stroke-white/[0.02] [mask-image:radial-gradient(100%_100%_at_top_right,white,transparent)]" aria-hidden="true">
                <defs>
                    <pattern id="grid-pattern" width="20" height="20" patternUnits="userSpaceOnUse" x="50%" y="-1">
                        <path d="M.5 20V.5H20" fill="none" />
                    </pattern>
                </defs>
                <rect width="100%" height="100%" fill="url(#grid-pattern)" />
            </svg>

            {{-- Ambient Glowing Lights --}}
            <div class="pointer-events-none absolute -right-16 -top-16 h-56 w-56 rounded-full bg-cyan-500/10 blur-3xl" aria-hidden="true"></div>
            <div class="pointer-events-none absolute -bottom-16 -left-10 h-48 w-48 rounded-full bg-amber-500/10 blur-3xl" aria-hidden="true"></div>

            <div class="relative z-10 flex flex-col lg:flex-row lg:items-center lg:justify-between gap-6">
                <div class="max-w-2xl">
                    <p class="text-sm font-semibold tracking-wide text-cyan-400 mb-1.5">
                        {{ filled($memberName)
                            ? __('pages/job-board-home.greeting', ['name' => $memberName])
                            : __('pages/job-board-home.greeting_fallback') }}
                    </p>
                    <h1 class="text-3xl sm:text-4xl font-extrabold tracking-tight text-white">
                        {{ __('pages/job-board-home.title') }}
                    </h1>
                    <p class="mt-2 text-sm sm:text-base text-slate-355 max-w-2xl font-light leading-relaxed">
                        {{ __('pages/job-board-home.subtitle') }}
                    </p>

                    @if (! empty($statusChips))
                        <div class="mt-6 flex flex-wrap gap-2.5">
                            @foreach ($statusChips as $chip)
                                @php
                                    list($chipClass, $glowClass) = match ($chip['tone']) {
                                        'success' => ['chip-success', 'bg-teal-400 glow-cyan'],
                                        'warning' => ['chip-warning', 'bg-amber-400 glow-amber'],
                                        'danger' => ['chip-danger', 'bg-rose-400 glow-rose'],
                                        default => ['chip-default', 'bg-slate-500'],
                                    };
                                @endphp
                                <span class="inline-flex items-center gap-2 rounded-full border px-3.5 py-1 text-xs font-semibold backdrop-blur-sm transition-all duration-300 hover:scale-102 {{ $chipClass }}">
                                    <span class="h-2 w-2 rounded-full {{ $glowClass }}" aria-hidden="true"></span>
                                    {{ $chip['label'] }}
                                </span>
                            @endforeach
                        </div>
                    @endif
                </div>

                {{-- Elegant floating network decoration with inline styles --}}
                <div class="constellation-wrapper">
                    <svg style="width: 150px !important; height: 150px !important;" class="hero-constellation animate-float" viewBox="0 0 200 200" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <!-- Connecting lines -->
                        <line x1="40" y1="40" x2="100" y2="30" stroke="currentColor" stroke-width="1.5" stroke-opacity="0.15" />
                        <line x1="100" y1="30" x2="160" y2="60" stroke="currentColor" stroke-width="1.5" stroke-opacity="0.15" />
                        <line x1="160" y1="60" x2="140" y2="140" stroke="currentColor" stroke-width="1.5" stroke-opacity="0.15" />
                        <line x1="140" y1="140" x2="60" y2="160" stroke="currentColor" stroke-width="1.5" stroke-opacity="0.15" />
                        <line x1="60" y1="160" x2="40" y2="40" stroke="currentColor" stroke-width="1.5" stroke-opacity="0.15" />
                        
                        <line x1="100" y1="30" x2="100" y2="100" stroke="currentColor" stroke-width="1.2" stroke-opacity="0.15" />
                        <line x1="40" y1="40" x2="100" y2="100" stroke="currentColor" stroke-width="1.2" stroke-opacity="0.15" />
                        <line x1="160" y1="60" x2="100" y2="100" stroke="currentColor" stroke-width="1.2" stroke-opacity="0.15" />
                        <line x1="140" y1="140" x2="100" y2="100" stroke="currentColor" stroke-width="1.2" stroke-opacity="0.15" />
                        <line x1="60" y1="160" x2="100" y2="100" stroke="currentColor" stroke-width="1.2" stroke-opacity="0.15" />
                        
                        <!-- Outer nodes -->
                        <circle cx="40" cy="40" r="6" fill="#00b5d2" fill-opacity="0.75" />
                        <circle cx="40" cy="40" r="11" stroke="#00b5d2" stroke-opacity="0.3" stroke-width="1" />
                        
                        <circle cx="100" cy="30" r="5" fill="#f58220" fill-opacity="0.75" />
                        
                        <circle cx="160" cy="60" r="7" fill="#14b8a6" fill-opacity="0.75" />
                        <circle cx="160" cy="60" r="13" stroke="#14b8a6" stroke-opacity="0.3" stroke-width="1" />
                        
                        <circle cx="140" cy="140" r="6" fill="#00b5d2" fill-opacity="0.75" />
                        
                        <circle cx="60" cy="160" r="8" fill="#f58220" fill-opacity="0.75" />
                        <circle cx="60" cy="160" r="15" stroke="#f58220" stroke-opacity="0.3" stroke-width="1" />
                        
                        <!-- Center node -->
                        <circle cx="100" cy="100" r="9" fill="#38bdf8" fill-opacity="0.85" />
                        <circle cx="100" cy="100" r="20" stroke="#38bdf8" stroke-opacity="0.25" stroke-width="1" />
                    </svg>
                </div>
            </div>
        </header>

        {{-- Interactive Flow Columns (Using Responsive Grid Fallback) --}}
        <div class="flow-grid">
            {{-- Candidate flow --}}
            <section class="flow-path-card flow-path-card-candidate group relative flex flex-col rounded-2xl p-6 sm:p-8 shadow-xl overflow-hidden">
                {{-- Decorative gradient border --}}
                <div class="absolute inset-x-0 top-0 h-1 bg-gradient-to-r from-cyan-500 to-teal-500 transition-all duration-300 group-hover:h-1.5" aria-hidden="true"></div>

                <header class="flex items-start gap-4 mb-6">
                    <span class="flow-icon-circle flex h-12 w-12 shrink-0 items-center justify-center rounded-xl bg-gradient-to-br from-cyan-500/20 to-teal-500/10 border border-cyan-500/30 text-cyan-300 shadow-[0_0_15px_rgba(6,182,212,0.15)] transition-transform duration-300">
                        {{-- Candidate profile identification card (dual-tone) --}}
                        <svg class="h-5.5 w-5.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 9h3.75M15 12h3.75M15 15h3.75M4.5 19.5h15a2.25 2.25 0 002.25-2.25V6.75A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25v10.5A2.25 2.25 0 004.5 19.5zm6-10.125a1.875 1.875 0 11-3.75 0 1.875 1.875 0 013.75 0zm1.294 6.336a6.721 6.721 0 01-3.17.789 6.721 6.721 0 01-3.168-.789 3.376 3.376 0 016.338 0z" />
                            <path fill="currentColor" fill-opacity="0.15" d="M7.125 9.375a1.875 1.875 0 100-3.75 1.875 1.875 0 000 3.75z" />
                        </svg>
                    </span>
                    <div class="min-w-0">
                        <h2 class="text-xl font-bold text-white tracking-tight">
                            {{ __('pages/job-board-home.candidate.title') }}
                        </h2>
                        <p class="mt-1 text-sm text-slate-300 leading-relaxed font-light">
                            {{ __('pages/job-board-home.candidate.description') }}
                        </p>
                    </div>
                </header>

                {{-- Progress Bar --}}
                <div class="mb-7 progress-bar-track p-4 rounded-xl">
                    <div class="flex items-center justify-between text-xs text-slate-400 mb-2">
                        <span class="font-medium tracking-wide uppercase text-[10px] text-slate-500">{{ __('pages/job-board-home.next_step') }}</span>
                        <span class="tabular-nums font-bold text-cyan-400">
                            {{ __('pages/job-board-home.progress_label', [
                                'done' => $candidate['progress']['done'],
                                'total' => $candidate['progress']['total'],
                            ]) }}
                        </span>
                    </div>
                    <div class="h-1.5 w-full rounded-full bg-slate-900 overflow-hidden shadow-inner border border-white/[0.02]">
                        <div
                            class="h-full rounded-full progress-bar-fill-candidate transition-all duration-500"
                            style="width: {{ $candidate['progress']['percent'] }}%"
                        ></div>
                    </div>
                </div>

                {{-- Checklist list --}}
                <ol class="space-y-3.5 text-sm mb-8 flex-1">
                    <li class="flex items-start gap-3 hover:bg-white/[0.01] px-2 py-1.5 -mx-2 rounded-lg transition-colors duration-200">
                        @include('filament.member.pages.partials.checklist-icon', ['done' => $candidate['has_profile']])
                        <span class="leading-tight pt-0.5 {{ $candidate['has_profile'] ? 'text-slate-400' : 'text-slate-200 font-semibold' }}">
                            {{ $candidate['has_profile']
                                ? __('pages/job-board-home.candidate.steps.profile_done')
                                : __('pages/job-board-home.candidate.steps.profile') }}
                        </span>
                    </li>
                    <li class="flex items-start gap-3 hover:bg-white/[0.01] px-2 py-1.5 -mx-2 rounded-lg transition-colors duration-200">
                        @include('filament.member.pages.partials.checklist-icon', ['done' => $candidate['profile_complete']])
                        <span class="leading-tight pt-0.5 {{ $candidate['profile_complete'] ? 'text-slate-400' : 'text-slate-200 font-semibold' }}">
                            {{ $candidate['profile_complete']
                                ? __('pages/job-board-home.candidate.steps.complete_done')
                                : __('pages/job-board-home.candidate.steps.complete') }}
                        </span>
                    </li>
                    <li class="flex items-start gap-3 hover:bg-white/[0.01] px-2 py-1.5 -mx-2 rounded-lg transition-colors duration-200">
                        @include('filament.member.pages.partials.checklist-icon', ['done' => false, 'neutral' => true])
                        <span class="leading-tight pt-0.5 text-slate-455">{{ __('pages/job-board-home.candidate.steps.browse') }}</span>
                    </li>
                </ol>

                <div class="mt-auto space-y-4">
                    <a
                        href="{{ $candidate['primary_cta']['url'] }}"
                        class="flex w-full items-center justify-center gap-2 rounded-xl bg-cyan-600 px-4 py-3.5 text-sm font-bold text-white shadow-lg active-scale"
                    >
                        {{ $candidate['primary_cta']['label'] }}
                        <svg class="h-4 w-4 cta-arrow transition-transform duration-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3" />
                        </svg>
                    </a>
                    @if (! empty($candidate['secondary_links']))
                        <div class="flex flex-wrap gap-x-4 gap-y-1.5 justify-center">
                            @foreach ($candidate['secondary_links'] as $link)
                                @continue($link['url'] === $candidate['primary_cta']['url'])
                                <a href="{{ $link['url'] }}" class="text-xs font-semibold text-slate-400 hover:text-cyan-400 premium-link transition-colors duration-200">
                                    {{ $link['label'] }}
                                </a>
                            @endforeach
                        </div>
                    @endif
                </div>
            </section>

            {{-- Employer flow --}}
            <section class="flow-path-card flow-path-card-employer group relative flex flex-col rounded-2xl p-6 sm:p-8 shadow-xl overflow-hidden">
                {{-- Decorative gradient border --}}
                <div class="absolute inset-x-0 top-0 h-1 bg-gradient-to-r from-amber-500 to-orange-500 transition-all duration-300 group-hover:h-1.5" aria-hidden="true"></div>

                <header class="flex items-start gap-4 mb-6">
                    <span class="flow-icon-circle flex h-12 w-12 shrink-0 items-center justify-center rounded-xl bg-gradient-to-br from-amber-500/20 to-orange-500/10 border border-amber-500/30 text-amber-300 shadow-[0_0_15px_rgba(245,130,32,0.15)] transition-transform duration-300">
                        {{-- Employer organization building (dual-tone) --}}
                        <svg class="h-5.5 w-5.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 21h19.5m-18-18v18m10.5-18v18m6-13.5V21M6.75 6.75h.75m-.75 3h.75m-.75 3h.75m3-6h.75m-.75 3h.75m-.75 3h.75M6.75 21v-3.375c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21M3 3h12m-.75 4.5H21m-3.75 3.75h.008v.008h-.008v-.008zm0 3h.008v.008h-.008v-.008zm0 3h.008v.008h-.008v-.008z" />
                            <path fill="currentColor" fill-opacity="0.12" d="M3 3h12v18H3zm13.5 4.5H21V21h-4.5z" />
                        </svg>
                    </span>
                    <div class="min-w-0">
                        <h2 class="text-xl font-bold text-white tracking-tight">
                            {{ __('pages/job-board-home.employer.title') }}
                        </h2>
                        <p class="mt-1 text-sm text-slate-350 leading-relaxed font-light">
                            {{ __('pages/job-board-home.employer.description') }}
                        </p>
                    </div>
                </header>

                {{-- Progress Bar --}}
                <div class="mb-7 progress-bar-track p-4 rounded-xl">
                    <div class="flex items-center justify-between text-xs text-slate-400 mb-2">
                        <span class="font-medium tracking-wide uppercase text-[10px] text-slate-500">{{ __('pages/job-board-home.next_step') }}</span>
                        <span class="tabular-nums font-bold text-amber-400">
                            {{ __('pages/job-board-home.progress_label', [
                                'done' => $employer['progress']['done'],
                                'total' => $employer['progress']['total'],
                            ]) }}
                        </span>
                    </div>
                    <div class="h-1.5 w-full rounded-full bg-slate-900 overflow-hidden shadow-inner border border-white/[0.02]">
                        <div
                            class="h-full rounded-full progress-bar-fill-employer transition-all duration-500"
                            style="width: {{ $employer['progress']['percent'] }}%"
                        ></div>
                    </div>
                </div>

                {{-- Checklist list --}}
                <ol class="space-y-3.5 text-sm mb-8 flex-1">
                    <li class="flex items-start gap-3 hover:bg-white/[0.01] px-2 py-1.5 -mx-2 rounded-lg transition-colors duration-200">
                        @include('filament.member.pages.partials.checklist-icon', ['done' => $employer['has_org']])
                        <span class="leading-tight pt-0.5 {{ $employer['has_org'] ? 'text-slate-400' : 'text-slate-200 font-semibold' }}">
                            {{ $employer['has_org']
                                ? __('pages/job-board-home.employer.steps.org_done')
                                : __('pages/job-board-home.employer.steps.org') }}
                        </span>
                    </li>
                    <li class="flex items-start gap-3 hover:bg-white/[0.01] px-2 py-1.5 -mx-2 rounded-lg transition-colors duration-200">
                        @include('filament.member.pages.partials.checklist-icon', [
                            'done' => $employer['org_verified'],
                            'pending' => $employer['org_pending'],
                        ])
                        <span class="leading-tight pt-0.5 {{ $employer['org_verified'] ? 'text-slate-400' : 'text-slate-200 font-semibold' }}">
                            @if ($employer['org_verified'])
                                {{ __('pages/job-board-home.employer.steps.verify_done') }}
                            @elseif ($employer['org_pending'])
                                {{ __('pages/job-board-home.employer.steps.verify_pending') }}
                            @else
                                {{ __('pages/job-board-home.employer.steps.verify') }}
                            @endif
                        </span>
                    </li>
                    <li class="flex items-start gap-3 hover:bg-white/[0.01] px-2 py-1.5 -mx-2 rounded-lg transition-colors duration-200">
                        @include('filament.member.pages.partials.checklist-icon', ['done' => $employer['listings_count'] > 0])
                        <span class="leading-tight pt-0.5 {{ $employer['listings_count'] > 0 ? 'text-slate-400' : 'text-slate-355 font-semibold' }}">
                            {{ __('pages/job-board-home.employer.steps.publish') }}
                        </span>
                    </li>
                </ol>

                <div class="mt-auto space-y-4">
                    <a
                        href="{{ $employer['primary_cta']['url'] }}"
                        class="flex w-full items-center justify-center gap-2 rounded-xl bg-amber-600 px-4 py-3.5 text-sm font-bold text-white shadow-lg active-scale"
                    >
                        {{ $employer['primary_cta']['label'] }}
                        <svg class="h-4 w-4 cta-arrow transition-transform duration-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3" />
                        </svg>
                    </a>
                    @if (! empty($employer['secondary_links']))
                        <div class="flex flex-wrap gap-x-4 gap-y-1.5 justify-center">
                            @foreach ($employer['secondary_links'] as $link)
                                @continue($link['url'] === $employer['primary_cta']['url'])
                                <a href="{{ $link['url'] }}" class="text-xs font-semibold text-slate-400 hover:text-amber-400 premium-link transition-colors duration-200">
                                    {{ $link['label'] }}
                                </a>
                            @endforeach
                        </div>
                    @endif
                </div>
            </section>
        </div>

        {{-- Quick links Section --}}
        @if (! empty($quickLinks))
            <section class="pt-4">
                <h2 class="text-xs font-bold uppercase tracking-wider text-slate-400 mb-4 px-1">
                    {{ __('pages/job-board-home.quick.heading') }}
                </h2>
                <div class="quick-links-grid">
                    @foreach ($quickLinks as $tile)
                        @php
                            $tileType = match ($tile['icon'] ?? 'search') {
                                'document' => 'tile-document',
                                'plane' => 'tile-plane',
                                'bell' => 'tile-bell',
                                'building' => 'tile-building',
                                'briefcase' => 'tile-briefcase',
                                default => 'tile-search',
                            };
                            $badgeClass = match ($tile['icon'] ?? 'search') {
                                'plane' => 'bg-sky-500/25 text-sky-200 border-sky-400/20 shadow-[0_0_8px_rgba(56,189,248,0.2)]',
                                'briefcase' => 'bg-orange-500/25 text-orange-200 border-orange-400/20 shadow-[0_0_8px_rgba(251,146,60,0.2)]',
                                default => 'bg-cyan-500/25 text-cyan-200 border-cyan-400/20 shadow-[0_0_8px_rgba(6,182,212,0.2)]',
                            };
                        @endphp
                        <a
                            href="{{ $tile['url'] }}"
                            class="quick-link-tile relative flex flex-col items-center gap-3.5 rounded-xl px-3.5 py-5 text-center active-scale {{ $tileType }}"
                        >
                            @if (! empty($tile['badge']))
                                <span class="absolute top-2.5 right-2.5 min-w-[1.25rem] h-5 px-1.5 rounded-full text-[10px] font-extrabold flex items-center justify-center border {{ $badgeClass }}">
                                    {{ $tile['badge'] }}
                                </span>
                            @endif
                            @include('filament.member.pages.partials.quick-link-icon', [
                                'icon' => $tile['icon'],
                                'withBg' => true,
                            ])
                            <span class="text-xs font-semibold text-slate-300 leading-tight tracking-wide group-hover:text-white transition-colors duration-200">{{ $tile['label'] }}</span>
                        </a>
                    @endforeach
                </div>
            </section>
        @endif
    </div>
</x-filament-panels::page>
