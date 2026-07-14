<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\SiteSetting;

class ViewServiceProvider extends ServiceProvider
{
    public function register(): void {}

    public function boot(): void
    {
        View::composer('layouts.app', function ($view) {
            $siteName = SiteSetting::where('key', 'site_name')->value('value') ?? 'FibermediaPlay';
            $whatsApp = SiteSetting::where('key', 'contact_whatsapp')->value('value') ?? '6281234567890';

            $view->with(compact('siteName', 'whatsApp'));
        });
    }
}
