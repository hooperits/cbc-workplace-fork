<x-filament-panels::page.simple>
    {{-- Scoped Styles for Welcome Page --}}
    <style>
        .welcome-card-pending {
            background-color: #1e293b !important;
            border: 1px solid rgba(6, 182, 212, 0.3) !important;
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.5), 0 0 15px 1px rgba(6, 182, 212, 0.05) !important;
        }
        .welcome-card-verified {
            background-color: #1e293b !important;
            border: 1px solid rgba(20, 184, 166, 0.3) !important;
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.5), 0 0 15px 1px rgba(20, 184, 166, 0.05) !important;
        }
        .welcome-icon-circle-pending {
            background: linear-gradient(135deg, rgba(6, 182, 212, 0.2) 0%, rgba(20, 184, 166, 0.1) 100%) !important;
            border: 1px solid rgba(6, 182, 212, 0.3) !important;
        }
        .welcome-icon-circle-verified {
            background: linear-gradient(135deg, rgba(20, 184, 166, 0.2) 0%, rgba(16, 185, 129, 0.1) 100%) !important;
            border: 1px solid rgba(20, 184, 166, 0.3) !important;
        }
    </style>

    <div class="flex flex-col gap-y-6">
        @if($this->getText())
            <div class="prose max-w-none text-center dark:prose-invert text-gray-300">
                {!! $this->getText() !!}
            </div>
        @endif

        @if(auth('member')->check())
            @php
                $member = auth('member')->user();
            @endphp

            @if(! $member->hasVerifiedEmail())
                <!-- Tarjeta de Confirmación de Correo Pendiente -->
                <div class="welcome-card-pending rounded-2xl p-6 sm:p-8 relative overflow-hidden">
                    {{-- Decorative gradient border --}}
                    <div class="absolute inset-x-0 top-0 h-1 bg-gradient-to-r from-cyan-500 to-teal-500"></div>

                    <div class="flex items-start gap-4">
                        <div class="welcome-icon-circle-pending rounded-xl p-2.5 text-cyan-300 shrink-0">
                            <!-- Dual-tone Envelope Icon -->
                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 0 1-2.25 2.25h-15a2.25 2.25 0 0 1-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0 0 19.5 4.5h-15a2.25 2.25 0 0 0-2.25 2.25m19.5 0v.243a2.25 2.25 0 0 1-1.07 1.916l-7.5 4.615a2.25 2.25 0 0 1-2.36 0L3.32 8.91a2.25 2.25 0 0 1-1.07-1.916V6.75" />
                                <path fill="currentColor" fill-opacity="0.12" d="M12 12.75L3.32 8.91a2.25 2.25 0 0 1-1.07-1.916V6.75L12 12.75z" />
                            </svg>
                        </div>
                        <div class="flex-1 space-y-2.5 text-left">
                            <h3 class="text-xl font-bold text-white tracking-tight">
                                {{ __('Confirma tu correo electrónico') }}
                            </h3>
                            <p class="text-sm text-slate-300 leading-relaxed font-light">
                                {{ __('Para continuar y acceder al portal, debes verificar tu cuenta. Hemos enviado un correo de confirmación a:') }}
                            </p>
                            <div class="inline-block px-3 py-1.5 bg-slate-900/60 border border-slate-700/60 rounded-xl font-mono text-sm font-semibold text-cyan-400 select-all shadow-inner">
                                {{ $member->email }}
                            </div>
                            <div class="text-xs text-slate-400 pt-2 space-y-1.5 border-t border-slate-700/50 mt-4">
                                <p class="flex items-center gap-1.5">• {{ __('¿No lo encuentras? Revisa tu carpeta de correo no deseado (Spam).') }}</p>
                                <p class="flex items-center gap-1.5">• {{ __('El enlace expira en 60 minutos.') }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="mt-6 flex flex-col sm:flex-row gap-3 justify-end border-t border-slate-700/50 pt-5">
                        <x-filament::button
                            wire:click="resendVerification"
                            wire:loading.attr="disabled"
                            color="warning"
                            icon="heroicon-m-arrow-path"
                            tag="button"
                            size="md"
                            class="rounded-xl font-semibold shadow-md transition-all duration-200"
                        >
                            <span wire:loading.remove wire:target="resendVerification">
                                {{ __('Reenviar correo') }}
                            </span>
                            <span wire:loading wire:target="resendVerification">
                                {{ __('Reenviando...') }}
                            </span>
                        </x-filament::button>

                        <x-filament::button
                            href="/member"
                            color="primary"
                            icon="heroicon-m-arrow-right"
                            tag="a"
                            size="md"
                            class="rounded-xl font-semibold shadow-md transition-all duration-200"
                        >
                            {{ __('Ir al Panel') }}
                        </x-filament::button>
                    </div>
                </div>
            @else
                <!-- Tarjeta de Cuenta Verificada -->
                <div class="welcome-card-verified rounded-2xl p-6 sm:p-8 relative overflow-hidden">
                    {{-- Decorative gradient border --}}
                    <div class="absolute inset-x-0 top-0 h-1 bg-gradient-to-r from-teal-500 to-emerald-500"></div>

                    <div class="flex items-start gap-4">
                        <div class="welcome-icon-circle-verified rounded-xl p-2.5 text-teal-300 shrink-0">
                            <!-- Dual-tone Check Circle Icon -->
                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                                <circle cx="12" cy="12" r="9" fill="currentColor" fill-opacity="0.12" />
                            </svg>
                        </div>
                        <div class="flex-1 space-y-1.5 text-left">
                            <h3 class="text-xl font-bold text-white tracking-tight">
                                {{ __('¡Cuenta verificada!') }}
                            </h3>
                            <p class="text-sm text-slate-300 leading-relaxed font-light">
                                {{ __('Tu dirección de correo ya ha sido confirmada con éxito. Ya puedes acceder al portal completo.') }}
                            </p>
                        </div>
                    </div>

                    <div class="mt-6 flex justify-end border-t border-slate-700/50 pt-5">
                        <x-filament::button
                            href="/member"
                            color="success"
                            icon="heroicon-m-arrow-right"
                            tag="a"
                            size="md"
                            class="rounded-xl font-semibold shadow-md transition-all duration-200"
                        >
                            {{ __('Entrar al Panel') }}
                        </x-filament::button>
                    </div>
                </div>
            @endif

            <!-- Enlace de Cierre de Sesión -->
            <div class="flex justify-center mt-4">
                <button
                    wire:click="logout"
                    class="text-xs text-slate-400 hover:text-rose-400 flex items-center gap-1.5 transition duration-150 ease-in-out font-medium"
                >
                    <!-- Heroicon-o-arrow-left-on-rectangle -->
                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0 0 13.5 3h-6a2.25 2.25 0 0 0-2.25 2.25v13.5A2.25 2.25 0 0 0 7.5 21h6a2.25 2.25 0 0 0 2.25-2.25V15M12 9l-3 3m0 0 3 3m-3-3h12.75" />
                    </svg>
                    {{ __('Cerrar sesión o registrarse con otra cuenta') }}
                </button>
            </div>
        @else
            <!-- Fallback para no autenticados -->
            <div class="mt-6 flex justify-center gap-4">
                <x-filament::button
                    :href="route('filament.member.auth.login')"
                    tag="a"
                    size="md"
                    class="rounded-xl font-semibold shadow-md transition-all duration-200"
                >
                    {{ __('Iniciar sesión') }}
                </x-filament::button>
            </div>
        @endif
    </div>
</x-filament-panels::page.simple>
