<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\SiteSetting;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Cache;

class AppServiceProvider extends ServiceProvider
{

    public function register(): void
    {
        
    }

    public function boot(): void
    {
        // View::composer('layouts.app', function ($view) {
        //     $siteName = SiteSetting::where('key', 'site_name')->value('value') ?? 'FibermediaPlay';
        //     $whatsApp = SiteSetting::where('key', 'contact_whatsapp')->value('value') ?? '6281234567890';

        //     $view->with(compact('siteName', 'whatsApp'));
        // });

        // View::composer('*', function ($view) {
        //     $settings = SiteSetting::allKeyValue();
        //     $view->with('settings', $settings);
        // });

        // Paginator::useBootstrapFive();
            View::composer('*', function ($view) {
        $settings = SiteSetting::allKeyValue();

        $siteTitle = ($settings['site_name'] ?? null) ?: 'FibermediaPlay';
        $wa = preg_replace('/\D+/', '', $settings['contact_whatsapp'] ?? '6281234567890');

        $view->with([
                'settings'  => $settings,
                'siteTitle' => $siteTitle,
                'wa'        => $wa,
            ]);
        });

        Paginator::useBootstrapFive();

        View::composer('public.*', function ($view) {
                $settings = Cache::rememberForever('fibermediaplay-cache-site_settings.all', function () {
                    return SiteSetting::allKeyValue();
                });

                $view->with('settings', $settings);

                // optional: biar layout kamu tetap bisa pakai $siteName / $whatsApp tanpa ubah banyak
                $view->with('siteName', $settings['site_name'] ?? config('app.name', 'FibermediaPlay'));
                $view->with('whatsApp', $settings['contact_whatsapp'] ?? null);
                $view->with('faviconPath', $settings['favicon'] ?? null);
            });
    }
}
