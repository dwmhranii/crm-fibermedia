<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\GalleryAlbum;
use App\Models\GalleryItem;
use App\Models\SiteSetting;

class ProfileController extends Controller
{
    public function index()
    {
        $albumId = SiteSetting::getValue('profile_album_id');
        $limit   = (int) (SiteSetting::getValue('profile_items_limit') ?? 2);

        if ($limit <= 0) {
            $limit = 2;
        }

        $album = null;

        if (!empty($albumId)) {
            $album = GalleryAlbum::query()
                ->where('id', $albumId)
                ->where('is_active', 1)
                ->first();
        }

        if (!$album) {
            $album = GalleryAlbum::query()
                ->where('slug', 'profil')
                ->where('is_active', 1)
                ->first();
        }

        $galleryItems = collect();

        if ($album) {
            $galleryItems = GalleryItem::query()
                ->where('album_id', $album->id)
                ->where('is_active', 1)
                ->where('type', 'image')
                ->orderBy('sort_order')
                ->orderBy('id')
                ->limit($limit)
                ->get();
        }

        return view('public.profil.index', compact('album', 'galleryItems'));
    }
}