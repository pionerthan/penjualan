<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Filament\Facades\Filament;

class FilamentServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        Filament::serving(function () {
        Auth::shouldUse('kasir'); // ⬅️ ini penting!
        if (!auth()->check() || !auth()->user()->isKasir()) {
            abort(403, 'Hanya untuk kasir');
        }
        });
    }
}
