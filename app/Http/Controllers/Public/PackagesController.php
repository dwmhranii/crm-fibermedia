<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Package;
use Illuminate\Http\Request;
use App\Services\PackageRecommendationService;

class PackagesController extends Controller
{
    public function index(Request $request)
    {
        $type = $request->get('type');
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
            ->paginate(12)
            ->withQueryString();

        $recommendedPackages = collect();

        if (
            $request->filled('usage') ||
            $request->filled('users') ||
            $request->filled('extra')
        ) {
            /** @var PackageRecommendationService $recoService */
            $recoService = app(PackageRecommendationService::class);

            $recommendedPackages = $recoService->recommend($request, 3);
        }

        return view('public.packages.index', compact(
            'packages',
            'type',
            'category',
            'sort',
            'q',
            'recommendedPackages'
        ));
    }

    public function show(Package $package)
    {
        abort_unless((int) $package->is_active === 1, 404);

        $related = Package::query()
            ->where('is_active', 1)
            ->where('id', '!=', $package->id)
            ->where('type', $package->type)
            ->orderByDesc('is_best_seller')
            ->orderByDesc('is_featured')
            ->limit(6)
            ->get();

        $recommendedPackages = collect();

        /** @var PackageRecommendationService $recoService */
        $recoService = app(PackageRecommendationService::class);

        if (!empty($package->best_for)) {
            request()->merge([
                'usage' => strtolower($package->best_for),
            ]);

            $recommendedPackages = $recoService
                ->recommend(request(), 3)
                ->reject(fn ($p) => $p->id === $package->id)
                ->values();
        }

        return view('public.packages.show', compact(
            'package',
            'related',
            'recommendedPackages'
        ));
    }
}