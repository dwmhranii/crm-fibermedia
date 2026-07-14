<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Package;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class PackageController extends Controller
{
    public function index(Request $request)
    {
        $q = trim((string) $request->get('q', ''));

        $packages = Package::query()
            ->when($q !== '', function ($query) use ($q) {
                $query->where(function ($subQuery) use ($q) {
                    $subQuery->where('name', 'like', "%{$q}%")
                        ->orWhere('slug', 'like', "%{$q}%")
                        ->orWhere('type', 'like', "%{$q}%")
                        ->orWhere('category', 'like', "%{$q}%");
                });
            })
            ->orderByDesc('is_best_seller')
            ->orderByDesc('is_featured')
            ->orderByDesc('is_active')
            ->latest('id')
            ->paginate(10)
            ->withQueryString();

        return view('admin.packages.index', compact('packages', 'q'));
    }

    public function create()
    {
        return view('admin.packages.create');
    }

    public function store(Request $request)
    {
        $data = $this->validated($request);
        $data = $this->prepareData($request, $data);

        // generate slug
        if (empty($data['slug'])) {
            $data['slug'] = Str::slug($data['name']);
        }

        $data['slug'] = $this->uniqueSlug($data['slug']);

        $package = Package::create($data);

        return redirect()
            ->route('admin.packages.show', $package->id)
            ->with('success', 'Package berhasil dibuat.');
    }

    public function show(Package $package)
    {
        return view('admin.packages.show', compact('package'));
    }

    public function edit(Package $package)
    {
        return view('admin.packages.edit', compact('package'));
    }

    public function update(Request $request, Package $package)
    {
        $data = $this->validated($request);
        $data = $this->prepareData($request, $data, $package);

        if (empty($data['slug'])) {
            $data['slug'] = Str::slug($data['name']);
        }

        // 🔥 penting: ignore ID sendiri
        $data['slug'] = $this->uniqueSlug($data['slug'], $package->id);

        $package->update($data);

        return redirect()
            ->route('admin.packages.show', $package->id)
            ->with('success', 'Package berhasil diupdate.');
    }

    public function destroy(Package $package)
    {
        // hapus file thumbnail
        if (!empty($package->thumbnail)) {
            $this->deleteFromPublicDiskIfExists($package->thumbnail);
        }

        // hapus file banner
        if (!empty($package->banner_image)) {
            $this->deleteFromPublicDiskIfExists($package->banner_image);
        }

        $package->delete();

        return redirect()
            ->route('admin.packages.index')
            ->with('success', 'Package berhasil dihapus.');
    }

    // =========================
    // VALIDATION
    // =========================
    private function validated(Request $request): array
    {
        return $request->validate([
            'name' => ['required', 'string', 'max:100'],
            'slug' => ['nullable', 'string', 'max:150'],

            'type' => ['required', 'in:home,business'],
            'category' => ['nullable', 'in:internet_only,internet_tv,streaming'],

            'speed_mbps' => ['required', 'integer', 'min:1'],
            'price_monthly' => ['required', 'integer', 'min:0'],

            'duration_months' => ['nullable', 'integer', 'min:1'],
            'min_users' => ['nullable', 'integer'],
            'max_users' => ['nullable', 'integer'],

            'best_for' => ['nullable', 'string'],
            'device_ideal' => ['nullable', 'string'],
            'short_description' => ['nullable', 'string'],

            'features' => ['nullable', 'string'],
            'whatsapp_order_url' => ['nullable', 'url'],

            // 🔥 upload file
            'thumbnail_file' => ['nullable', 'image', 'max:2048'],
            'banner_file' => ['nullable', 'image', 'max:4096'],

            // remove
            'remove_thumbnail' => ['nullable'],
            'remove_banner' => ['nullable'],

            'banner_color_start' => ['nullable', 'string'],
            'banner_color_end' => ['nullable', 'string'],

            'is_active' => ['nullable'],
            'is_featured' => ['nullable'],
            'is_best_seller' => ['nullable'],

            'includes_tv' => ['nullable'],
            'includes_streaming_app' => ['nullable'],
            'includes_mobile_quota' => ['nullable'],

            'good_for_gaming' => ['nullable'],
            'good_for_streaming' => ['nullable'],
            'good_for_wfh' => ['nullable'],
        ]);
    }

    // =========================
    // PREPARE DATA
    // =========================
    private function prepareData(Request $request, array $data, ?Package $package = null): array
    {
        // boolean casting
        foreach ([
            'includes_tv',
            'includes_streaming_app',
            'includes_mobile_quota',
            'good_for_gaming',
            'good_for_streaming',
            'good_for_wfh',
            'is_active',
            'is_featured',
            'is_best_seller',
        ] as $field) {
            $data[$field] = $request->boolean($field);
        }

        // =====================
        // THUMBNAIL
        // =====================
        if ($request->boolean('remove_thumbnail')) {
            if ($package && $package->thumbnail) {
                $this->deleteFromPublicDiskIfExists($package->thumbnail);
            }
            $data['thumbnail'] = null;
        } elseif ($request->hasFile('thumbnail_file')) {
            if ($package && $package->thumbnail) {
                $this->deleteFromPublicDiskIfExists($package->thumbnail);
            }

            $data['thumbnail'] = $request->file('thumbnail_file')
                ->store('packages/thumbnails', 'public');
        } elseif ($package) {
            $data['thumbnail'] = $package->thumbnail;
        }

        // =====================
        // BANNER
        // =====================
        if ($request->boolean('remove_banner')) {
            if ($package && $package->banner_image) {
                $this->deleteFromPublicDiskIfExists($package->banner_image);
            }
            $data['banner_image'] = null;
        } elseif ($request->hasFile('banner_file')) {
            if ($package && $package->banner_image) {
                $this->deleteFromPublicDiskIfExists($package->banner_image);
            }

            $data['banner_image'] = $request->file('banner_file')
                ->store('packages/banners', 'public');
        } elseif ($package) {
            $data['banner_image'] = $package->banner_image;
        }

        unset(
            $data['thumbnail_file'],
            $data['banner_file'],
            $data['remove_thumbnail'],
            $data['remove_banner']
        );

        return $data;
    }

    // =========================
    // DELETE FILE
    // =========================
    private function deleteFromPublicDiskIfExists(?string $path): void
    {
        if (!$path) return;

        if (Storage::disk('public')->exists($path)) {
            Storage::disk('public')->delete($path);
        }
    }

    // =========================
    // UNIQUE SLUG (FIX ERROR)
    // =========================
    private function uniqueSlug(string $baseSlug, ?int $ignoreId = null): string
    {
        $slug = Str::slug($baseSlug);
        $original = $slug;
        $counter = 2;

        while (
            Package::withTrashed() // 🔥 penting!
                ->when($ignoreId, fn ($q) => $q->where('id', '!=', $ignoreId))
                ->where('slug', $slug)
                ->exists()
        ) {
            $slug = $original . '-' . $counter;
            $counter++;
        }

        return $slug;
    }
}