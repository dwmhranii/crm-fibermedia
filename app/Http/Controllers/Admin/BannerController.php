<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;


class BannerController extends Controller
{
    public function index(Request $request)
    {
        $q = $request->get('q');

        $banners = Banner::query()
            ->when($q, function ($query) use ($q) {
                $query->where('title', 'like', "%{$q}%")
                      ->orWhere('position', 'like', "%{$q}%");
            })
            ->orderByDesc('is_active')
            ->orderBy('position')
            ->orderBy('sort_order')
            ->latest('id')
            ->paginate(12);

        return view('admin.banners.index', compact('banners', 'q'));
    }

    public function create()
    {
        return view('admin.banners.create');
    }

    public function store(Request $request)
    {
        $data = $this->validated($request);

        // upload
        if ($request->hasFile('image_desktop')) {
            $data['image_desktop'] = $request->file('image_desktop')->store('banners', 'public');
        }
        if ($request->hasFile('image_mobile')) {
            $data['image_mobile'] = $request->file('image_mobile')->store('banners', 'public');
        }

    $data['created_by'] = Auth::id();
    $data['updated_by'] = Auth::id();


        Banner::create($data);

        return redirect()->route('admin.banners.index')->with('success', 'Banner berhasil dibuat.');
    }

    public function edit(Banner $banner)
    {
        return view('admin.banners.edit', compact('banner'));
    }

    public function update(Request $request, Banner $banner)
    {
        $data = $this->validated($request);

        // upload replace
        if ($request->hasFile('image_desktop')) {
            if ($banner->image_desktop) Storage::disk('public')->delete($banner->image_desktop);
            $data['image_desktop'] = $request->file('image_desktop')->store('banners', 'public');
        }
        if ($request->hasFile('image_mobile')) {
            if ($banner->image_mobile) Storage::disk('public')->delete($banner->image_mobile);
            $data['image_mobile'] = $request->file('image_mobile')->store('banners', 'public');
        }

        $data['updated_by'] = Auth::id();

        $banner->update($data);

        return redirect()->route('admin.banners.index')->with('success', 'Banner berhasil diupdate.');
    }

    public function show(Banner $banner)
    {
        return view('admin.banners.show', compact('banner'));
    }

    public function destroy(Banner $banner)
    {
        // hapus file
        if ($banner->image_desktop) Storage::disk('public')->delete($banner->image_desktop);
        if ($banner->image_mobile) Storage::disk('public')->delete($banner->image_mobile);

        $banner->delete();

        return redirect()->route('admin.banners.index')->with('success', 'Banner berhasil dihapus.');
    }

    private function validated(Request $request): array
    {
        $validated = $request->validate([
            'title' => ['required','string','max:190'],
            'subtitle' => ['nullable','string','max:190'],
            'description' => ['nullable','string'],

            'image_desktop' => ['nullable','image','max:4096'],
            'image_mobile' => ['nullable','image','max:4096'],

            'cta_text' => ['nullable','string','max:80'],
            'cta_url' => ['nullable','string','max:255'],
            'open_in_new_tab' => ['nullable','boolean'],

            'position' => ['required','string','max:50'],
            'sort_order' => ['nullable','integer','min:0'],

            'start_at' => ['nullable','date'],
            'end_at' => ['nullable','date','after_or_equal:start_at'],

            'is_active' => ['nullable','boolean'],
        ]);

        // checkbox handling
        $validated['open_in_new_tab'] = $request->boolean('open_in_new_tab');
        $validated['is_active'] = $request->boolean('is_active');
        $validated['sort_order'] = $validated['sort_order'] ?? 0;

        return $validated;
    }
}
