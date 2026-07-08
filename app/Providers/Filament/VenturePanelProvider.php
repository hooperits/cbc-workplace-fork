<?php

namespace App\Providers\Filament;

use App\Filament\Venture\Resources\VentureResource;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Navigation\NavigationBuilder;
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
            ->brandLogo(fn () => view('filament.venture.logo'))
            ->brandLogoHeight('4rem')
            ->topNavigation()
            ->discoverResources(in: app_path('Filament/Venture/Resources'), for: 'App\\Filament\\Venture\\Resources')
            ->discoverPages(in: app_path('Filament/Venture/Pages'), for: 'App\\Filament\\Venture\\Pages')
            ->pages([
                VentureResource\Pages\ListVentures::class,
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
            // Empty builder: public header provides site navigation (same as bolsa-de-trabajo).
            ->navigation(fn (NavigationBuilder $builder): NavigationBuilder => $builder->items([]))
            ->renderHook(
                PanelsRenderHook::HEAD_START,
                fn (): string => view('filament.venture.shell-styles')->render()
            )
            ->renderHook(
                PanelsRenderHook::BODY_START,
                fn (): string => view('filament.venture.shell-chrome-start')->render()
            )
            ->renderHook(
                PanelsRenderHook::BODY_END,
                fn (): string => view('filament.venture.shell-chrome-end')->render()
            );
    }
}
