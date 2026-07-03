<?php

namespace App\Providers\Filament;

use App\Filament\Venture\Resources\VentureResource;
use Filament\Facades\Filament;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Navigation\NavigationBuilder;
use Filament\Navigation\NavigationItem;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Filament\View\PanelsRenderHook;
use Filament\Widgets;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\AuthenticateSession;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;

class VenturePanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->id('app')
            ->path('/app')
            ->default()
            ->darkMode(true)
            ->colors([
                'primary' => Color::Cyan,
                'gray' => Color::Slate,
                'warning' => Color::Amber,
                'success' => Color::Teal,
            ])
            ->brandLogo(fn () => view('filament.logo'))
            ->topNavigation()
            ->discoverResources(in: app_path('Filament/Venture/Resources'), for: 'App\\Filament\\Venture\\Resources')
            ->discoverPages(in: app_path('Filament/Venture/Pages'), for: 'App\\Filament\\Venture\\Pages')
            ->pages([
                VentureResource\Pages\ListVentures::class,
                // Pages\Dashboard::class,
            ])
            ->discoverWidgets(in: app_path('Filament/Venture/Widgets'), for: 'App\\Filament\\Venture\\Widgets')
            ->widgets([
                Widgets\FilamentInfoWidget::class,
            ])
            ->breadcrumbs(false)
            ->middleware([
                EncryptCookies::class,
                AddQueuedCookiesToResponse::class,
                StartSession::class,
                AuthenticateSession::class,
                ShareErrorsFromSession::class,
                VerifyCsrfToken::class,
                SubstituteBindings::class,
                DisableBladeIconComponents::class,
                DispatchServingFilamentEvent::class,
            ])
            ->authMiddleware([])
            ->renderHook(
                PanelsRenderHook::BODY_START,
                fn (): string => '<script>localStorage.setItem("theme", "dark"); document.documentElement.classList.add("dark");</script>'
            )
            ->renderHook(
                PanelsRenderHook::HEAD_START,
                fn (): string => '
                <style>
                    :root { color-scheme: dark; }
                    body, .fi-main-ctn { font-family: Inter, system-ui, -apple-system, sans-serif; background: #020617 !important; }
                    h1, h2, h3, .brand-logo, .fi-header-heading { font-family: Outfit, system-ui, sans-serif; }
                    :focus-visible { outline: 3px solid #06b6d4; outline-offset: 2px; }
                    ::-webkit-scrollbar { width: 8px; }
                    ::-webkit-scrollbar-track { background: #0f172a; }
                    ::-webkit-scrollbar-thumb { background: #334155; border-radius: 9999px; }
                    ::-webkit-scrollbar-thumb:hover { background: #475569; }

                    /* Premium dark cards for ventures grid and sections */
                    .fi-ta-content-grid .fi-ta-record,
                    .fi-section,
                    .fi-card,
                    .fi-infolist-section {
                        background-color: rgba(15, 23, 42, 0.4) !important; /* slate-900/40 */
                        border: 1px solid rgba(30, 41, 59, 0.8) !important; /* slate-800/80 */
                        border-radius: 1rem !important; /* rounded-2xl */
                        box-shadow: 0 10px 15px -3px rgb(0 0 0 / 0.1);
                    }
                    .fi-ta-record:hover {
                        background-color: rgba(15, 23, 42, 0.6) !important;
                        border-color: rgba(30, 41, 59, 1) !important;
                    }
                    .fi-main-ctn { background: #020617 !important; }
                    .fi-topbar, .fi-sidebar { background: #0b0f19 !important; }
                </style>
                '
            )
            ->navigation(function (NavigationBuilder $builder): NavigationBuilder {
                return $builder->items([
                    NavigationItem::make(__('Inicio'))
                        ->icon('heroicon-o-home')
                        ->url(function () {
                            return url('/');
                        }),
                    NavigationItem::make(__('Mis Favoritos'))
                        ->icon('heroicon-o-heart')
                        ->visible(fn () => auth()->guard('member')->user())
                        ->url(function () {
                            return url()->route('filament.member.resources.favorites.index');
                        }),
                    // NavigationItem::make(__('Registrar'))
                    //   ->icon('heroicon-o-user-plus')
                    //   ->url(function () {
                    //     return url(route('filament.member.auth.register'));
                    //   }),
                    // NavigationItem::make(__('Mi Cuenta'))
                    //   ->url(url(route('filament.member.pages.dashboard')))
                    //   ->icon('heroicon-o-arrow-down-circle')
                    //   ->sort(3),
                ]);
            });
    }
}
