<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\GalleryAlbum;
use App\Models\GalleryItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class GalleryItemController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = GalleryItem::query()->with('album');

        if ($request->filled('album_id')) {
            $query->where('album_id', $request->album_id);
        }

        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        if ($request->filled('q')) {
            $q = $request->q;
            $query->where(function ($w) use ($q) {
                $w->where('title', 'like', "%{$q}%")
                  ->orWhere('caption', 'like', "%{$q}%")
                  ->orWhere('video_url', 'like', "%{$q}%");
            });
        }

        $items = $query->latest()->paginate(15)->withQueryString();
        $albums = GalleryAlbum::orderBy('title')->get();

        return view('admin.gallery-items.index', compact('items', 'albums'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $albums = GalleryAlbum::orderBy('title')->get();
        return view('admin.gallery-items.create', compact('albums'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'album_id'    => ['required', 'exists:gallery_albums,id'],
            'type'        => ['required', 'in:image,video'],
            'title'       => ['nullable', 'string', 'max:255'],
            'caption'     => ['nullable', 'string'],
            'video_url'   => ['nullable', 'url', 'max:2048'],
            'sort_order'  => ['nullable', 'integer', 'min:0'],
            'is_active'   => ['nullable', 'boolean'],
            'file'        => ['nullable', 'file', 'mimes:jpg,jpeg,png,webp,mp4,mov', 'max:20480'],
            'thumb'       => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:8192'],
        ]);

        // normalize checkbox
        $data['is_active'] = (bool) ($request->boolean('is_active'));

        // If type is video, video_url required; if image, file required
        if ($data['type'] === 'video') {
            $request->validate([
                'video_url' => ['required', 'url', 'max:2048'],
            ]);
        } else {
            $request->validate([
                'file' => ['required'],
            ]);
        }

        // Upload file (image/video) if present
        if ($request->hasFile('file')) {
            $data['file_path'] = $request->file('file')->store('gallery/items', 'public');
        }

        // Upload thumb if present (optional)
        if ($request->hasFile('thumb')) {
            $data['thumb_path'] = $request->file('thumb')->store('gallery/items/thumbs', 'public');
        }

        $item = GalleryItem::create($data);

        return redirect()
            ->route('admin.gallery-items.show', $item)
            ->with('success', 'Gallery item created.');
    }

    /**
     * Display the specified resource.
     */
    public function show(GalleryItem $galleryItem)
    {
        $galleryItem->load('album');
        return view('admin.gallery-items.show', ['item' => $galleryItem]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(GalleryItem $galleryItem)
    {
        $albums = GalleryAlbum::orderBy('title')->get();
        return view('admin.gallery-items.edit', ['item' => $galleryItem, 'albums' => $albums]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, GalleryItem $galleryItem)
    {
        $data = $request->validate([
            'album_id'    => ['required', 'exists:gallery_albums,id'],
            'type'        => ['required', 'in:image,video'],
            'title'       => ['nullable', 'string', 'max:255'],
            'caption'     => ['nullable', 'string'],
            'video_url'   => ['nullable', 'url', 'max:2048'],
            'sort_order'  => ['nullable', 'integer', 'min:0'],
            'is_active'   => ['nullable', 'boolean'],
            'file'        => ['nullable', 'file', 'mimes:jpg,jpeg,png,webp,mp4,mov', 'max:20480'],
            'thumb'       => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:8192'],
        ]);

        $data['is_active'] = (bool) ($request->boolean('is_active'));

        if ($data['type'] === 'video') {
            $request->validate([
                'video_url' => ['required', 'url', 'max:2048'],
            ]);
            // optional: if switching to video, we don't force file
        } else {
            // if type is image and there is no existing file_path, require file
            if (!$galleryItem->file_path && !$request->hasFile('file')) {
                $request->validate(['file' => ['required']]);
            }
        }

        // Replace file if uploaded
        if ($request->hasFile('file')) {
            if ($galleryItem->file_path) {
                Storage::disk('public')->delete($galleryItem->file_path);
            }
            $data['file_path'] = $request->file('file')->store('gallery/items', 'public');
        }

        // Replace thumb if uploaded
        if ($request->hasFile('thumb')) {
            if ($galleryItem->thumb_path) {
                Storage::disk('public')->delete($galleryItem->thumb_path);
            }
            $data['thumb_path'] = $request->file('thumb')->store('gallery/items/thumbs', 'public');
        }

        $galleryItem->update($data);

        return redirect()
            ->route('admin.gallery-items.show', $galleryItem)
            ->with('success', 'Gallery item updated.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(GalleryItem $galleryItem)
    {
        if ($galleryItem->file_path) {
            Storage::disk('public')->delete($galleryItem->file_path);
        }

        if ($galleryItem->thumb_path) {
            Storage::disk('public')->delete($galleryItem->thumb_path);
        }

        $galleryItem->delete();

        return redirect()
            ->route('admin.gallery-items.index')
            ->with('success', 'Gallery item deleted.');
    }
}