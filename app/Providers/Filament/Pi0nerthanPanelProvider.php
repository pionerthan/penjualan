<?php

namespace App\Providers\Filament;

use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\AuthenticateSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Pages;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Filament\Widgets;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;

// Import semua resource
use App\Filament\Resources\ProdukResource;
use App\Filament\Resources\PenjualanResource;
use App\Filament\Resources\PelangganResource;
use App\Filament\Resources\SupplierResource;
use App\Filament\Resources\PromoResource;
use App\Filament\Resources\VoucherResource;

class Pi0nerthanPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->default()
            ->id('pi0nerthan')
            ->path('pi0nerthan')
            ->login()
            ->colors([
                'primary' => Color::Amber,
            ])
            ->discoverResources(
                in: app_path('Filament/Resources'),
                for: 'App\\Filament\\Resources'
            )
            ->discoverPages(
                in: app_path('Filament/Pages'),
                for: 'App\\Filament\\Pages'
            )
            ->pages([
                Pages\Dashboard::class,
            ])
            ->discoverWidgets(
                in: app_path('Filament/Widgets'),
                for: 'App\\Filament\\Widgets'
            )
            ->widgets([
                Widgets\AccountWidget::class,
                Widgets\FilamentInfoWidget::class,
                \App\Filament\Widgets\PenjualanChart::class,
                \App\Filament\Widgets\ProdukTerlarisChart::class,
                \App\Filament\Widgets\BestSellingTime::class,
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
            ->navigationGroups([
                'Penjualan',
                'Inventaris',
                'Customer',
                'Promosi',
                'Mail',
            ])
            ->resources([
                PenjualanResource::class,
                ProdukResource::class,
                PelangganResource::class,
                SupplierResource::class,
   
                VoucherResource::class,
            ])
            ->authMiddleware([
                Authenticate::class,
            ]);
    }
}
