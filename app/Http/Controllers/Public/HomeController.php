<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use Illuminate\View\View;
use App\Models\Banner;
use App\Models\Package;
use App\Models\WhyCard;
use App\Models\SiteSetting;
use App\Services\PackageRecommendationService;

class HomeController extends Controller
{
    public function index(): View
    {
        // Banner hero
        $banners = Banner::query()
            ->where('is_active', 1)
            ->where('position', 'home_hero')
            ->orderBy('sort_order')
            ->get();

        // Paket untuk ditampilkan di home -> hanya 2 paket aktif
        $packages = Package::query()
            ->where('is_active', 1)
            ->orderByDesc('is_best_seller')
            ->orderByDesc('is_featured')
            ->orderBy('price_monthly')
            ->limit(2)
            ->get();

        // Why cards dari CMS + style otomatis
        $whyCards = WhyCard::query()
            ->where('is_active', 1)
            ->orderBy('sort_order')
            ->get()
            ->values()
            ->map(function ($card, $index) {
                $styles = [
                    [
                        'bg' => 'linear-gradient(135deg, #eff6ff, #dbeafe)',
                        'text' => '#1e3a8a',
                        'icon' => '💡',
                    ],
                    [
                        'bg' => 'linear-gradient(135deg, #ecfeff, #cffafe)',
                        'text' => '#0f766e',
                        'icon' => '⚡',
                    ],
                    [
                        'bg' => 'linear-gradient(135deg, #f0fdf4, #dcfce7)',
                        'text' => '#166534',
                        'icon' => '🚀',
                    ],
                    [
                        'bg' => 'linear-gradient(135deg, #f8fafc, #e2e8f0)',
                        'text' => '#334155',
                        'icon' => '✨',
                    ],
                ];

                $style = $styles[$index % count($styles)];

                $card->bg_style = $style['bg'];
                $card->text_style = $style['text'];
                $card->icon_emoji = $style['icon'];

                return $card;
            });

        $settings = SiteSetting::pluck('value', 'key');
        $siteName = !empty($settings['site_name']) ? $settings['site_name'] : 'FibermediaPlay';
        $rawWa = !empty($settings['contact_whatsapp']) ? $settings['contact_whatsapp'] : '6289638881777';
        $whatsApp = preg_replace('/[^0-9]/', '', $rawWa);
        $contactEmail = !empty($settings['contact_email']) ? $settings['contact_email'] : 'info@fibermediaplay.net';
        $contactAddress = !empty($settings['contact_address']) ? $settings['contact_address'] : 'Gadang, Kec. Sukun, Kota Malang, Jawa Timur';

        $recommendedPackages = collect();

        if (
            request()->filled('usage') ||
            request()->filled('users') ||
            request()->filled('extra')
        ) {
            /** @var PackageRecommendationService $recoService */
            $recoService = app(PackageRecommendationService::class);

            $recommendedPackages = $recoService->recommend(request(), 3);
        }

        return view('public.home', compact(
            'banners',
            'packages',
            'whyCards',
            'siteName',
            'whatsApp',
            'contactEmail',
            'contactAddress',
            'settings',
            'recommendedPackages'
        ));
    }
}