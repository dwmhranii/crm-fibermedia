<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Addon;
use App\Models\Package;
use App\Models\SiteSetting;
use Illuminate\Http\Request;

class SimulationController extends Controller
{
    public function index(Request $request)
    {
        $packages = Package::query()
            ->where('is_active', 1)
            ->orderBy('price_monthly', 'asc')
            ->get();

        $addons = Addon::query()
            ->where('is_active', 1)
            ->orderBy('sort_order', 'asc')
            ->orderBy('name', 'asc')
            ->get();

        // Get unique categories from active packages
        $categories = [
            'all' => 'Semua Paket'
        ];

        foreach ($packages as $pkg) {
            if ($pkg->category && !isset($categories[$pkg->category])) {
                $categories[$pkg->category] = match ($pkg->category) {
                    'internet_only' => 'Internet Saja',
                    'internet_tv' => 'Internet + TV',
                    'streaming' => 'Streaming',
                    default => ucwords(str_replace(['_', '-'], ' ', $pkg->category)),
                };
            }
        }

        // Selected package (from query or first)
        $preselectedId = null;
        if ($request->filled('package')) {
            $matched = $packages->first(function ($item) use ($request) {
                return (string) $item->id === (string) $request->package || $item->slug === $request->package;
            });
            if ($matched) {
                $preselectedId = $matched->id;
            }
        }

        if (!$preselectedId && $packages->isNotEmpty()) {
            $preselectedId = $packages->first()->id;
        }

        $addonMeta = [
            'streaming' => [
                'name' => 'Aplikasi Streaming',
                'icon' => 'bi-play-btn-fill',
                'desc' => 'Netflix, Vidio, Vision+, Catchplay, dan hiburan lainnya',
            ],
            'stb-android' => [
                'name' => 'STB & Android TV Box',
                'icon' => 'bi-display-fill',
                'desc' => 'Dekoder Android TV untuk ubah TV biasa jadi Smart TV',
            ],
            'network-device' => [
                'name' => 'Perangkat Jaringan & Router',
                'icon' => 'bi-router-fill',
                'desc' => 'Router dual band, access point mesh penguat sinyal',
            ],
            'smart-home' => [
                'name' => 'Smart Home & Otomasi',
                'icon' => 'bi-house-gear-fill',
                'desc' => 'Kamera indoor, smart plug WiFi, IR remote, sensor pintu',
            ],
            'cctv' => [
                'name' => 'CCTV & Keamanan',
                'icon' => 'bi-camera-video-fill',
                'desc' => 'Paket kamera CCTV pengawas rumah dan kantor',
            ],
            'other' => [
                'name' => 'Layanan & Aksesoris Tambahan',
                'icon' => 'bi-tools',
                'desc' => 'Kabel tambahan, instalasi paralel, dan aksesoris',
            ],
        ];

        $groupedAddons = $addons->groupBy(fn ($item) => $item->category ?: 'other');

        $settings = SiteSetting::pluck('value', 'key');
        $whatsappNumber = preg_replace('/\D+/', '', $settings['contact_whatsapp'] ?? '6281234567890');

        return view('public.simulation.index', compact(
            'packages',
            'addons',
            'categories',
            'groupedAddons',
            'addonMeta',
            'preselectedId',
            'whatsappNumber',
            'settings'
        ));
    }
}
