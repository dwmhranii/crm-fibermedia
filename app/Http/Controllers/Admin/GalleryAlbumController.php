<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\GalleryAlbum;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class GalleryAlbumController extends Controller
{
    public function index(Request $request)
    {
        $q = trim((string) $request->get('q'));

        $albums = GalleryAlbum::query()
            ->when($q, function ($query) use ($q) {
                $query->where('title', 'like', "%{$q}%")
                      ->orWhere('slug', 'like', "%{$q}%");
            })
            ->orderByDesc('is_active')
            ->orderBy('sort_order')
            ->latest('id')
            ->paginate(12);

        return view('admin.gallery-albums.index', compact('albums', 'q'));
    }

    public function create()
    {
        return view('admin.gallery-albums.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title'       => ['required', 'string', 'max:255'],
            'slug'        => ['nullable', 'string', 'max:255', 'unique:gallery_albums,slug'],
            'description' => ['nullable', 'string'],
            'cover_image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:4096'],
            'is_active'   => ['nullable', 'boolean'],
            'sort_order'  => ['nullable', 'integer', 'min:0'],
        ]);

        $data['slug']       = $data['slug'] ?: Str::slug($data['title']);
        $data['is_active']  = (bool) ($data['is_active'] ?? true);
        $data['sort_order'] = (int) ($data['sort_order'] ?? 0);
        $data['created_by'] = Auth::id();
        $data['updated_by'] = Auth::id();

        if ($request->hasFile('cover_image')) {
            $path = $request->file('cover_image')->store('gallery/albums', 'public');
            $data['cover_image'] = $path;
        }

        GalleryAlbum::create($data);

        return redirect()->route('admin.gallery-albums.index')->with('success', 'Album berhasil dibuat.');
    }

    public function show(GalleryAlbum $gallery_album)
    {
        $album = $gallery_album->loadCount('items');
        return view('admin.gallery-albums.show', compact('album'));
    }

    public function edit(GalleryAlbum $gallery_album)
    {
        $album = $gallery_album;
        return view('admin.gallery-albums.edit', compact('album'));
    }

    public function update(Request $request, GalleryAlbum $gallery_album)
    {
        $data = $request->validate([
            'title'        => ['required', 'string', 'max:255'],
            'slug'         => ['nullable', 'string', 'max:255', 'unique:gallery_albums,slug,' . $gallery_album->id],
            'description'  => ['nullable', 'string'],
            'cover_image'  => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:4096'],
            'is_active'    => ['nullable', 'boolean'],
            'sort_order'   => ['nullable', 'integer', 'min:0'],
            'remove_cover' => ['nullable', 'boolean'],
        ]);

        $data['slug']       = $data['slug'] ?: Str::slug($data['title']);
        $data['is_active']  = (bool) ($data['is_active'] ?? false);
        $data['sort_order'] = (int) ($data['sort_order'] ?? 0);
        $data['updated_by'] = Auth::id();

        if (($data['remove_cover'] ?? false) && $gallery_album->cover_image) {
            Storage::disk('public')->delete($gallery_album->cover_image);
            $data['cover_image'] = null;
        }

        if ($request->hasFile('cover_image')) {
            if ($gallery_album->cover_image) {
                Storage::disk('public')->delete($gallery_album->cover_image);
            }
            $path = $request->file('cover_image')->store('gallery/albums', 'public');
            $data['cover_image'] = $path;
        }

        unset($data['remove_cover']);

        $gallery_album->update($data);

        return redirect()->route('admin.gallery-albums.index')->with('success', 'Album berhasil diupdate.');
    }

    public function destroy(GalleryAlbum $gallery_album)
    {
        $gallery_album->delete();
        return redirect()->route('admin.gallery-albums.index')->with('success', 'Album berhasil dihapus.');
    }
}