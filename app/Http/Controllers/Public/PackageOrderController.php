<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Addon;
use App\Models\Package;
use App\Models\SiteSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class PackageOrderController extends Controller
{
    private const SESSION_KEY = 'package_order_flow';

    public function step1(Request $request)
    {
        $type = $request->get('type');
        $category = $request->get('category');
        $sort = $request->get('sort');
        $q = trim((string) $request->get('q', ''));

        $session = Session::get(self::SESSION_KEY, []);
        $selectedPackageId = data_get($session, 'package_id');
        $selectedAddonIds = (array) data_get($session, 'addon_ids', []);

        if ($request->filled('package')) {
            $preselectedPackage = Package::query()
                ->where('is_active', 1)
                ->where(function ($query) use ($request) {
                    $query->where('id', $request->package)
                        ->orWhere('slug', $request->package);
                })
                ->first();

            if ($preselectedPackage) {
                $selectedPackageId = $preselectedPackage->id;
                if (!$type && !empty($preselectedPackage->type)) {
                    $type = $preselectedPackage->type;
                }
            }
        }

        if ($request->has('addon_ids')) {
            $selectedAddonIds = array_map('intval', (array) $request->input('addon_ids', []));
        }

        $type = $type ?: 'home';

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

        $addons = Addon::query()
            ->where('is_active', 1)
            ->where(function ($query) use ($type) {
                $query->where('type', $type)
                    ->orWhereNull('type')
                    ->orWhere('type', '');
            })
            ->orderBy('sort_order', 'asc')
            ->orderBy('name', 'asc')
            ->get();

        if ($addons->isEmpty()) {
            $addons = Addon::query()
                ->where('is_active', 1)
                ->orderBy('sort_order', 'asc')
                ->orderBy('name', 'asc')
                ->get();
        }

        return view('public.packages.order.step1', compact(
            'packages',
            'addons',
            'selectedPackageId',
            'selectedAddonIds',
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
            'addon_ids' => ['nullable', 'array'],
            'addon_ids.*' => ['integer', 'exists:addons,id'],
            'duration_months' => ['nullable', 'integer'],
        ]);

        $package = Package::query()
            ->where('is_active', 1)
            ->findOrFail($data['package_id']);

        $session = Session::get(self::SESSION_KEY, []);
        $session['package_id'] = $package->id;
        $session['addon_ids'] = array_map('intval', $request->input('addon_ids', []));
        if ($request->filled('duration_months')) {
            $session['duration_months'] = (int) $request->input('duration_months');
        }

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

        $addonIds = (array) data_get($session, 'addon_ids', []);
        $selectedAddons = !empty($addonIds)
            ? Addon::query()->where('is_active', 1)->whereIn('id', $addonIds)->get()
            : collect();

        $formData = [
            'customer_name'     => data_get($session, 'customer_name', ''),
            'customer_phone'    => data_get($session, 'customer_phone', ''),
            'customer_city'     => data_get($session, 'customer_city', 'Kota Malang'),
            'customer_district' => data_get($session, 'customer_district', ''),
            'customer_village'  => data_get($session, 'customer_village', ''),
            'customer_rt'       => data_get($session, 'customer_rt', ''),
            'customer_rw'       => data_get($session, 'customer_rw', ''),
            'customer_street'   => data_get($session, 'customer_street', ''),
            'customer_address'  => data_get($session, 'customer_address', ''),
            'customer_lat'      => data_get($session, 'customer_lat', ''),
            'customer_lng'      => data_get($session, 'customer_lng', ''),
            'customer_note'     => data_get($session, 'customer_note', ''),
        ];

        return view('public.packages.order.step2', compact('package', 'formData', 'selectedAddons'));
    }

    public function storeStep2(Request $request)
    {
        $session = Session::get(self::SESSION_KEY, []);
        $packageId = data_get($session, 'package_id');

        if (!$packageId) {
            return redirect()->route('public.order.step1');
        }

        $data = $request->validate([
            'customer_name'     => ['required', 'string', 'max:100'],
            'customer_phone'    => ['required', 'string', 'max:30'],
            'customer_city'     => ['required', 'string', 'max:100'],
            'customer_district' => ['required', 'string', 'max:100'],
            'customer_village'  => ['required', 'string', 'max:100'],
            'customer_rt'       => ['required', 'string', 'max:10'],
            'customer_rw'       => ['required', 'string', 'max:10'],
            'customer_street'   => ['required', 'string', 'max:300'],
            'customer_lat'      => ['nullable', 'numeric'],
            'customer_lng'      => ['nullable', 'numeric'],
            'customer_note'     => ['nullable', 'string', 'max:500'],
        ]);

        // Auto construct formatted full address
        $fullAddress = trim("{$data['customer_street']}, RT {$data['customer_rt']} / RW {$data['customer_rw']}, {$data['customer_village']}, Kec. {$data['customer_district']}, {$data['customer_city']}");
        $data['customer_address'] = $fullAddress;

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

        $addonIds = (array) data_get($session, 'addon_ids', []);
        $selectedAddons = !empty($addonIds)
            ? Addon::query()->where('is_active', 1)->whereIn('id', $addonIds)->get()
            : collect();

        $formData = [
            'customer_name'     => data_get($session, 'customer_name', ''),
            'customer_phone'    => data_get($session, 'customer_phone', ''),
            'customer_city'     => data_get($session, 'customer_city', ''),
            'customer_district' => data_get($session, 'customer_district', ''),
            'customer_village'  => data_get($session, 'customer_village', ''),
            'customer_rt'       => data_get($session, 'customer_rt', ''),
            'customer_rw'       => data_get($session, 'customer_rw', ''),
            'customer_street'   => data_get($session, 'customer_street', ''),
            'customer_address'  => data_get($session, 'customer_address', ''),
            'customer_lat'      => data_get($session, 'customer_lat', ''),
            'customer_lng'      => data_get($session, 'customer_lng', ''),
            'customer_note'     => data_get($session, 'customer_note', ''),
        ];

        $settings = SiteSetting::pluck('value', 'key');
        $wa = preg_replace('/\D+/', '', $settings['contact_whatsapp'] ?? '6281234567890');

        $whatsappUrl = 'https://wa.me/' . $wa . '?text=' . urlencode(
            $this->buildWhatsappMessage($package, $formData, $selectedAddons)
        );

        return view('public.packages.order.step3', compact(
            'package',
            'formData',
            'selectedAddons',
            'whatsappUrl'
        ));
    }

    private function buildWhatsappMessage(Package $package, array $data, $selectedAddons = null): string
    {
        $price = 'Rp ' . number_format((float) $package->price_monthly, 0, ',', '.');
        $duration = !empty($package->duration_months) ? $package->duration_months . ' bulan' : '1 bulan';

        $mapsLink = (!empty($data['customer_lat']) && !empty($data['customer_lng']))
            ? "https://maps.google.com/?q={$data['customer_lat']},{$data['customer_lng']}"
            : 'Belum ditandai di peta';

        $addonLines = [];
        $hasAddons = $selectedAddons && $selectedAddons->count() > 0;
        $packageMonthly = (float) $package->price_monthly;
        $addonMonthly = $hasAddons ? (float) $selectedAddons->where('pricing_type', 'monthly')->sum('price') : 0;
        $addonOneTime = $hasAddons ? (float) $selectedAddons->where('pricing_type', 'one_time')->sum('price') : 0;
        $totalMonthly = $packageMonthly + $addonMonthly;

        if ($hasAddons) {
            foreach ($selectedAddons as $addon) {
                $p = 'Rp ' . number_format((float) $addon->price, 0, ',', '.');
                $u = $addon->pricing_type === 'monthly' ? '/bln' : '(sekali bayar)';
                $addonLines[] = "- {$addon->name}: {$p} {$u}";
            }
        } else {
            $addonLines[] = 'Tidak ada (Hanya paket internet)';
        }

        $totalSummaryLines = [
            'Total Bulanan: Rp ' . number_format($totalMonthly, 0, ',', '.') . ' /bln',
        ];
        if ($addonOneTime > 0) {
            $totalSummaryLines[] = 'Biaya Perangkat Add-on (1x): Rp ' . number_format($addonOneTime, 0, ',', '.');
        }

        return implode("\n", [
            'Halo Admin FiberMedia Play, saya ingin memesan paket internet berikut:',
            '',
            '=== DATA PAKET ===',
            'Nama Paket: ' . $package->name,
            'Tipe: ' . ($package->type === 'business' ? 'Bisnis' : 'Home Retail'),
            'Kecepatan: ' . $package->speed_mbps . ' Mbps',
            'Harga Paket: ' . $price . '/bln',
            'Durasi: ' . $duration,
            '',
            '=== LAYANAN / ADD-ONS TAMBAHAN ===',
            implode("\n", $addonLines),
            '',
            '=== TOTAL ESTIMASI BIAYA ===',
            implode("\n", $totalSummaryLines),
            '',
            '=== DATA PELANGGAN & WILAYAH ===',
            'Nama Lengkap: ' . ($data['customer_name'] ?? '-'),
            'Nomor HP/WhatsApp: ' . ($data['customer_phone'] ?? '-'),
            'Kota/Kabupaten: ' . ($data['customer_city'] ?? '-'),
            'Kecamatan: ' . ($data['customer_district'] ?? '-'),
            'Kelurahan/Desa: ' . ($data['customer_village'] ?? '-'),
            'RT/RW: RT ' . ($data['customer_rt'] ?? '-') . ' / RW ' . ($data['customer_rw'] ?? '-'),
            'Alamat / Jalan: ' . ($data['customer_street'] ?? '-'),
            'Alamat Lengkap: ' . ($data['customer_address'] ?? '-'),
            'Titik Lokasi (Maps): ' . $mapsLink,
            'Catatan Tambahan: ' . (!empty($data['customer_note']) ? $data['customer_note'] : '-'),
        ]);
    }
}