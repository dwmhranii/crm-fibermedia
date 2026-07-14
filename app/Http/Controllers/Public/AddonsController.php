<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Addon;
use App\Models\SiteSetting;
use Illuminate\Http\Request;

class AddonsController extends Controller
{
    public function index(Request $request)
    {
        $allowedTypes = ['home', 'business'];
        $allowedCategories = [
            'cctv',
            'network-device',
            'smart-home',
            'stb-android',
            'streaming',
        ];
        $allowedSorts = ['price_asc', 'price_desc'];

        $type = $request->filled('type') && in_array($request->get('type'), $allowedTypes, true)
            ? $request->get('type')
            : 'home';

        $category = $request->filled('category') && in_array($request->get('category'), $allowedCategories, true)
            ? $request->get('category')
            : null;

        $sort = $request->filled('sort') && in_array($request->get('sort'), $allowedSorts, true)
            ? $request->get('sort')
            : null;

        $q = trim((string) $request->get('q', ''));

        $addons = Addon::query()
            ->where('is_active', 1)
            ->where('type', $type)
            ->when($category, fn ($query) => $query->where('category', $category))
            ->when($q !== '', function ($query) use ($q) {
                $query->where(function ($subQuery) use ($q) {
                    $subQuery->where('name', 'like', "%{$q}%")
                        ->orWhere('best_for', 'like', "%{$q}%")
                        ->orWhere('short_description', 'like', "%{$q}%")
                        ->orWhere('device_ideal', 'like', "%{$q}%")
                        ->orWhere('description', 'like', "%{$q}%")
                        ->orWhere('features', 'like', "%{$q}%");
                });
            })
            ->when($sort === 'price_asc', fn ($query) => $query->orderBy('price', 'asc'))
            ->when($sort === 'price_desc', fn ($query) => $query->orderBy('price', 'desc'))
            ->when(!$sort, function ($query) {
                $query->orderByDesc('is_best_seller')
                    ->orderByDesc('is_featured')
                    ->orderBy('sort_order', 'asc')
                    ->orderBy('price', 'asc')
                    ->orderBy('name', 'asc');
            })
            ->paginate(12)
            ->withQueryString();

        $settings = SiteSetting::pluck('value', 'key');

        return view('public.addons.index', compact(
            'addons',
            'settings',
            'type',
            'category',
            'sort',
            'q'
        ));
    }
}