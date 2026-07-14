<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Addon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class AddonController extends Controller
{
    public function index(Request $request)
    {
        $q = trim((string) $request->get('q', ''));

        $categoryLabels = [
            'cctv' => 'CCTV',
            'network-device' => 'Access Point AP Router',
            'smart-home' => 'Smart Home',
            'stb-android' => 'STB Android',
            'streaming' => 'Streaming',
        ];

        $addons = Addon::query()
            ->when($q !== '', function ($query) use ($q) {
                $query->where(function ($subQuery) use ($q) {
                    $subQuery->where('name', 'like', "%{$q}%")
                        ->orWhere('slug', 'like', "%{$q}%")
                        ->orWhere('type', 'like', "%{$q}%")
                        ->orWhere('category', 'like', "%{$q}%")
                        ->orWhere('short_description', 'like', "%{$q}%");
                });
            })
            ->orderByDesc('is_best_seller')
            ->orderByDesc('is_featured')
            ->orderByDesc('is_active')
            ->orderBy('sort_order', 'asc')
            ->latest('id')
            ->paginate(10)
            ->withQueryString();

        return view('admin.addons.index', compact('addons', 'q', 'categoryLabels'));
    }

    public function create()
    {
        $categoryLabels = [
            'cctv' => 'CCTV',
            'network-device' => 'Access Point AP Router',
            'smart-home' => 'Smart Home',
            'stb-android' => 'STB Android',
            'streaming' => 'Streaming',
        ];

        return view('admin.addons.create', compact('categoryLabels'));
    }

    public function store(Request $request)
    {
        $data = $this->validated($request);
        $data = $this->prepareData($request, $data);

        if (empty($data['slug'])) {
            $data['slug'] = Str::slug($data['name']);
        }

        $data['slug'] = $this->uniqueSlug($data['slug']);

        $addon = Addon::create($data);

        return redirect()
            ->route('admin.addons.show', $addon->id)
            ->with('success', 'Add on berhasil dibuat.');
    }

    public function show(Addon $addon)
    {
        $categoryLabels = [
            'cctv' => 'CCTV',
            'network-device' => 'Access Point AP Router',
            'smart-home' => 'Smart Home',
            'stb-android' => 'STB Android',
            'streaming' => 'Streaming',
        ];

        return view('admin.addons.show', compact('addon', 'categoryLabels'));
    }

    public function edit(Addon $addon)
    {
        $categoryLabels = [
            'cctv' => 'CCTV',
            'network-device' => 'Access Point AP Router',
            'smart-home' => 'Smart Home',
            'stb-android' => 'STB Android',
            'streaming' => 'Streaming',
        ];

        return view('admin.addons.edit', compact('addon', 'categoryLabels'));
    }

    public function update(Request $request, Addon $addon)
    {
        $data = $this->validated($request);
        $data = $this->prepareData($request, $data, $addon);

        if (empty($data['slug'])) {
            $data['slug'] = Str::slug($data['name']);
        }

        $data['slug'] = $this->uniqueSlug($data['slug'], $addon->id);

        $addon->update($data);

        return redirect()
            ->route('admin.addons.show', $addon->id)
            ->with('success', 'Add on berhasil diupdate.');
    }

    public function destroy(Addon $addon)
    {
        if (!empty($addon->thumbnail)) {
            $this->deleteFromPublicDiskIfExists($addon->thumbnail);
        }

        if (!empty($addon->banner_image)) {
            $this->deleteFromPublicDiskIfExists($addon->banner_image);
        }

        $addon->delete();

        return redirect()
            ->route('admin.addons.index')
            ->with('success', 'Add on berhasil dihapus.');
    }

    private function validated(Request $request): array
    {
        return $request->validate([
            'name' => ['required', 'string', 'max:100'],
            'slug' => ['nullable', 'string', 'max:150'],

            'type' => ['required', 'in:home,business'],
            'category' => ['nullable', 'in:cctv,network-device,smart-home,stb-android,streaming'],

            'price' => ['required', 'integer', 'min:0'],
            'pricing_type' => ['required', 'in:monthly,one_time'],
            'duration_months' => ['nullable', 'integer', 'min:1'],

            'best_for' => ['nullable', 'string'],
            'device_ideal' => ['nullable', 'string'],
            'short_description' => ['nullable', 'string'],
            'description' => ['nullable', 'string'],
            'features' => ['nullable', 'string'],
            'whatsapp_url' => ['nullable', 'url'],

            'thumbnail_file' => ['nullable', 'image', 'max:2048'],
            'banner_file' => ['nullable', 'image', 'max:4096'],

            'remove_thumbnail' => ['nullable'],
            'remove_banner' => ['nullable'],

            'banner_color_start' => ['nullable', 'string', 'max:20'],
            'banner_color_end' => ['nullable', 'string', 'max:20'],

            'is_active' => ['nullable'],
            'is_featured' => ['nullable'],
            'is_best_seller' => ['nullable'],
            'sort_order' => ['nullable', 'integer'],
        ]);
    }

    private function prepareData(Request $request, array $data, ?Addon $addon = null): array
    {
        foreach ([
            'is_active',
            'is_featured',
            'is_best_seller',
        ] as $field) {
            $data[$field] = $request->boolean($field);
        }

        if ($request->boolean('remove_thumbnail')) {
            if ($addon && $addon->thumbnail) {
                $this->deleteFromPublicDiskIfExists($addon->thumbnail);
            }
            $data['thumbnail'] = null;
        } elseif ($request->hasFile('thumbnail_file')) {
            if ($addon && $addon->thumbnail) {
                $this->deleteFromPublicDiskIfExists($addon->thumbnail);
            }

            $data['thumbnail'] = $request->file('thumbnail_file')
                ->store('addons/thumbnails', 'public');
        } elseif ($addon) {
            $data['thumbnail'] = $addon->thumbnail;
        }

        if ($request->boolean('remove_banner')) {
            if ($addon && $addon->banner_image) {
                $this->deleteFromPublicDiskIfExists($addon->banner_image);
            }
            $data['banner_image'] = null;
        } elseif ($request->hasFile('banner_file')) {
            if ($addon && $addon->banner_image) {
                $this->deleteFromPublicDiskIfExists($addon->banner_image);
            }

            $data['banner_image'] = $request->file('banner_file')
                ->store('addons/banners', 'public');
        } elseif ($addon) {
            $data['banner_image'] = $addon->banner_image;
        }

        unset(
            $data['thumbnail_file'],
            $data['banner_file'],
            $data['remove_thumbnail'],
            $data['remove_banner']
        );

        return $data;
    }

    private function deleteFromPublicDiskIfExists(?string $path): void
    {
        if (!$path) {
            return;
        }

        if (Storage::disk('public')->exists($path)) {
            Storage::disk('public')->delete($path);
        }
    }

    private function uniqueSlug(string $baseSlug, ?int $ignoreId = null): string
    {
        $slug = Str::slug($baseSlug);
        $original = $slug;
        $counter = 2;

        while (
            Addon::query()
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