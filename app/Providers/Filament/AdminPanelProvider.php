<?php

namespace App\Providers\Filament;

use App\Filament\Admin\Pages\Auth\Login;
use App\Filament\Admin\Pages\EditProfile;
use Filament\Facades\Filament;
use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Navigation\NavigationGroup;
use Filament\Pages;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Filament\View\PanelsRenderHook;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\AuthenticateSession;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;

class AdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->id('admin')
            ->path('admin')
            ->authGuard('admin')
            ->login(Login::class)
            ->colors([
                'primary' => Color::Cyan,
                'gray' => Color::Slate,
                'warning' => Color::Amber,
            ])
            ->brandLogo(fn () => view('filament.logo'))
            ->topNavigation()
            ->discoverResources(in: app_path('Filament/Admin/Resources'), for: 'App\\Filament\\Admin\\Resources')
            ->discoverPages(in: app_path('Filament/Admin/Pages'), for: 'App\\Filament\\Admin\\Pages')
            ->pages([
                Pages\Dashboard::class,
            ])
            ->discoverWidgets(in: app_path('Filament/Admin/Widgets'), for: 'App\\Filament\\Admin\\Widgets')
            ->widgets([])
            ->navigationGroups([
                NavigationGroup::make()
                    ->label('Sistema'),
                NavigationGroup::make()
                    ->label('Administración'),
                NavigationGroup::make()
                    ->label(__('navigation.bolsa-de-trabajo')),
                NavigationGroup::make()
                    ->label('Emprendimientos'),
            ])
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
            ->authMiddleware([
                Authenticate::class,
            ])
            ->renderHook(
                PanelsRenderHook::GLOBAL_SEARCH_AFTER,
                fn (): string => 'ADMIN - '.Filament::auth()->user()->role->name
            )
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
                    h1, h2, h3, .brand-logo { font-family: Outfit, system-ui, sans-serif; }
                    :focus-visible { outline: 3px solid #06b6d4; outline-offset: 2px; }
                    ::-webkit-scrollbar { width: 8px; }
                    ::-webkit-scrollbar-track { background: #0f172a; }
                    ::-webkit-scrollbar-thumb { background: #334155; border-radius: 9999px; }
                    ::-webkit-scrollbar-thumb:hover { background: #475569; }
                    .fi-ta-content-grid .fi-ta-record,
                    .fi-section,
                    .fi-card,
                    .fi-infolist-section {
                        background-color: rgba(15, 23, 42, 0.4) !important;
                        border: 1px solid rgba(30, 41, 59, 0.8) !important;
                        border-radius: 1rem !important;
                    }
                    .fi-main-ctn { background: #020617 !important; }
                </style>
                '
            )
            ->profile(EditProfile::class)
            ->plugin(\MarcoGermani87\FilamentCaptcha\FilamentCaptcha::make());
        //      ->navigation(function (NavigationBuilder $builder): NavigationBuilder {
        //        return $builder->items([
        //          NavigationItem::make(__('Inicio'))
        //          ->icon('heroicon-o-home')
        //          ->isActiveWhen(fn (): bool => request()->routeIs('filament.venture.pages..'))
        //          ->url('/'),
        //          NavigationItem::make('Dashboard')
        //          ->icon('heroicon-o-squares-2x2')
        //          ->isActiveWhen(fn (): bool => request()->routeIs('filament.admin.pages.dashboard'))
        //          ->url(fn (): string => Pages\Dashboard::getUrl()),
        //          ...TextResource::getNavigationItems(),
        //          ...CategoryResource::getNavigationItems(),
        //          ...MemberResource::getNavigationItems(),
        //          ...VentureResource::getNavigationItems(),
        //        ]);
        //      });
    }
}
