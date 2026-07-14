<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Package;
use App\Models\SiteSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class PackageOrderController extends Controller
{
    private const SESSION_KEY = 'package_order_flow';

    public function step1(Request $request)
    {
        $type = $request->get('type', 'home');
        $category = $request->get('category');
        $sort = $request->get('sort');
        $q = trim((string) $request->get('q', ''));

        $packages = Package::query()
            ->where('is_active', 1)
            ->when($type, fn ($query) => $query->where('type', $type))
            ->when($category, fn ($query) => $query->where('category', $category))
            ->when($q !== '', function ($query) use ($q) {
                $query->where(function ($subQuery) use ($q) {
                    $subQuery->where('name', 'like', "%{$q}%")
                        ->orWhere('best_for', 'like', "%{$q}%")
                        ->orWhere('short_description', 'like', "%{$q}%")
                        ->orWhere('device_ideal', 'like', "%{$q}%");
                });
            })
            ->when($sort === 'price_asc', fn ($query) => $query->orderBy('price_monthly', 'asc'))
            ->when($sort === 'price_desc', fn ($query) => $query->orderBy('price_monthly', 'desc'))
            ->when($sort === 'speed_desc', fn ($query) => $query->orderBy('speed_mbps', 'desc'))
            ->when(!$sort, function ($query) {
                $query->orderByDesc('is_best_seller')
                    ->orderByDesc('is_featured')
                    ->orderBy('price_monthly', 'asc');
            })
            ->get();

        $session = Session::get(self::SESSION_KEY, []);
        $selectedPackageId = data_get($session, 'package_id');

        if ($request->filled('package')) {
            $package = Package::query()
                ->where('is_active', 1)
                ->where(function ($query) use ($request) {
                    $query->where('id', $request->package)
                        ->orWhere('slug', $request->package);
                })
                ->first();

            if ($package) {
                $selectedPackageId = $package->id;
            }
        }

        return view('public.packages.order.step1', compact(
            'packages',
            'selectedPackageId',
            'type',
            'category',
            'sort',
            'q'
        ));
    }

    public function storeStep1(Request $request)
    {
        $data = $request->validate([
            'package_id' => ['required', 'integer', 'exists:packages,id'],
        ]);

        $package = Package::query()
            ->where('is_active', 1)
            ->findOrFail($data['package_id']);

        $session = Session::get(self::SESSION_KEY, []);
        $session['package_id'] = $package->id;

        Session::put(self::SESSION_KEY, $session);

        return redirect()->route('public.order.step2');
    }

    public function step2()
    {
        $session = Session::get(self::SESSION_KEY, []);
        $packageId = data_get($session, 'package_id');

        if (!$packageId) {
            return redirect()->route('public.order.step1');
        }

        $package = Package::query()
            ->where('is_active', 1)
            ->findOrFail($packageId);

        $formData = [
            'customer_name'    => data_get($session, 'customer_name', ''),
            'customer_phone'   => data_get($session, 'customer_phone', ''),
            'customer_address' => data_get($session, 'customer_address', ''),
            'customer_note'    => data_get($session, 'customer_note', ''),
        ];

        return view('public.packages.order.step2', compact('package', 'formData'));
    }

    public function storeStep2(Request $request)
    {
        $session = Session::get(self::SESSION_KEY, []);
        $packageId = data_get($session, 'package_id');

        if (!$packageId) {
            return redirect()->route('public.order.step1');
        }

        $data = $request->validate([
            'customer_name'    => ['required', 'string', 'max:100'],
            'customer_phone'   => ['required', 'string', 'max:30'],
            'customer_address' => ['required', 'string', 'max:500'],
            'customer_note'    => ['nullable', 'string', 'max:500'],
        ]);

        $session = array_merge($session, $data);
        Session::put(self::SESSION_KEY, $session);

        return redirect()->route('public.order.step3');
    }

    public function step3()
    {
        $session = Session::get(self::SESSION_KEY, []);
        $packageId = data_get($session, 'package_id');

        if (!$packageId) {
            return redirect()->route('public.order.step1');
        }

        $package = Package::query()
            ->where('is_active', 1)
            ->findOrFail($packageId);

        $formData = [
            'customer_name'    => data_get($session, 'customer_name', ''),
            'customer_phone'   => data_get($session, 'customer_phone', ''),
            'customer_address' => data_get($session, 'customer_address', ''),
            'customer_note'    => data_get($session, 'customer_note', ''),
        ];

        $settings = SiteSetting::pluck('value', 'key');
        $wa = preg_replace('/\D+/', '', $settings['contact_whatsapp'] ?? '6281234567890');

        $whatsappUrl = 'https://wa.me/' . $wa . '?text=' . urlencode(
            $this->buildWhatsappMessage($package, $formData)
        );

        return view('public.packages.order.step3', compact(
            'package',
            'formData',
            'whatsappUrl'
        ));
    }

    private function buildWhatsappMessage(Package $package, array $data): string
    {
        $price = 'Rp ' . number_format((float) $package->price_monthly, 0, ',', '.');
        $duration = !empty($package->duration_months) ? $package->duration_months . ' bulan' : '1 bulan';

        return implode("\n", [
            'Halo Admin FiberMedia Play, saya ingin memesan paket berikut:',
            '',
            '=== DATA PAKET ===',
            'Nama Paket: ' . $package->name,
            'Tipe: ' . ($package->type === 'business' ? 'Bisnis' : 'Home Retail'),
            'Kecepatan: ' . $package->speed_mbps . ' Mbps',
            'Harga: ' . $price,
            'Durasi: ' . $duration,
            '',
            '=== DATA PELANGGAN ===',
            'Nama Lengkap: ' . $data['customer_name'],
            'Nomor HP/WhatsApp: ' . $data['customer_phone'],
            'Alamat Lengkap: ' . $data['customer_address'],
            'Catatan Tambahan: ' . (!empty($data['customer_note']) ? $data['customer_note'] : '-'),
        ]);
    }
}