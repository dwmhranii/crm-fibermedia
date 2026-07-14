<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SiteSetting;
use App\Models\User;
use App\Models\GalleryAlbum;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;

class SettingController extends Controller
{
    private array $fields = [
        'general' => [
            'site_name' => ['type' => 'text', 'label' => 'Site Name'],
            'logo'      => ['type' => 'image', 'label' => 'Logo'],
            'favicon'   => ['type' => 'image', 'label' => 'Favicon'],
        ],
        'contact' => [
            'contact_whatsapp' => ['type' => 'text', 'label' => 'WhatsApp'],
            'contact_email'    => ['type' => 'text', 'label' => 'Email'],
            'contact_address'  => ['type' => 'textarea', 'label' => 'Address'],
        ],
        'seo' => [
            'seo_default_title'       => ['type' => 'text', 'label' => 'Default Title'],
            'seo_default_description' => ['type' => 'textarea', 'label' => 'Default Description'],
            'og_image'                => ['type' => 'image', 'label' => 'OG Image'],
        ],
        'social' => [
            'instagram_url' => ['type' => 'text', 'label' => 'Instagram URL'],
            'tiktok_url'    => ['type' => 'text', 'label' => 'TikTok URL'],
        ],
        'legal' => [
            'legal_title'        => ['type' => 'text', 'label' => 'Legal Title'],
            'legal_description'  => ['type' => 'textarea', 'label' => 'Legal Description'],
            'legal_logo_1'       => ['type' => 'image', 'label' => 'Legal Logo 1'],
            'legal_logo_2'       => ['type' => 'image', 'label' => 'Legal Logo 2'],
            'legal_logo_1_alt'   => ['type' => 'text', 'label' => 'Legal Logo 1 Alt'],
            'legal_logo_2_alt'   => ['type' => 'text', 'label' => 'Legal Logo 2 Alt'],
        ],
        'profile' => [
            'profile_album_id'    => ['type' => 'select', 'label' => 'Album Profile'],
            'profile_items_limit' => ['type' => 'number', 'label' => 'Jumlah item ditampilkan'],
        ],
    ];

    public function index()
    {
        $values  = SiteSetting::allKeyValue();
        $canEdit = $this->isSuperAdmin();

        // ✅ FIX: albums harus diambil SEBELUM return
        $albums = GalleryAlbum::query()
            ->where('is_active', 1)
            ->orderBy('title')
            ->get(['id', 'title', 'slug', 'is_active']);

        return view('admin.settings.index', [
            'groups'  => $this->fields,
            'values'  => $values,
            'canEdit' => $canEdit,
            'albums'  => $albums,
        ]);
    }

    public function update(Request $request)
    {
        if (!$this->isSuperAdmin()) {
            abort(403, 'Only superadmin can update settings.');
        }

        $rules = [
            'site_name' => ['nullable', 'string', 'max:191'],

            'contact_whatsapp' => ['nullable', 'string', 'max:50'],
            'contact_email'    => ['nullable', 'email', 'max:191'],
            'contact_address'  => ['nullable', 'string', 'max:255'],

            'seo_default_title'       => ['nullable', 'string', 'max:191'],
            'seo_default_description' => ['nullable', 'string', 'max:255'],

            'instagram_url' => ['nullable', 'url', 'max:255'],
            'tiktok_url'    => ['nullable', 'url', 'max:255'],

            'logo'     => ['nullable', 'file', 'mimes:jpg,jpeg,png,webp,svg', 'max:2048'],
            'favicon'  => ['nullable', 'file', 'mimes:ico,png,jpg,jpeg,webp,svg', 'max:1024'],
            'og_image' => ['nullable', 'file', 'mimes:jpg,jpeg,png,webp', 'max:2048'],

            'legal_title'       => ['nullable', 'string', 'max:191'],
            'legal_description' => ['nullable', 'string', 'max:800'],

            'legal_logo_1' => ['nullable', 'file', 'mimes:jpg,jpeg,png,webp,svg', 'max:2048'],
            'legal_logo_2' => ['nullable', 'file', 'mimes:jpg,jpeg,png,webp,svg', 'max:2048'],

            'legal_logo_1_alt' => ['nullable', 'string', 'max:191'],
            'legal_logo_2_alt' => ['nullable', 'string', 'max:191'],

            'profile_album_id'    => ['nullable', 'exists:gallery_albums,id'],
            'profile_items_limit' => ['nullable', 'integer', 'min:1', 'max:50'],
        ];

        $data = $request->validate($rules);

        // TEXT SETTINGS
        $this->saveText('site_name', $data['site_name'] ?? null, 'general');

        $this->saveText('contact_whatsapp', $data['contact_whatsapp'] ?? null, 'contact');
        $this->saveText('contact_email', $data['contact_email'] ?? null, 'contact');
        $this->saveText('contact_address', $data['contact_address'] ?? null, 'contact');

        $this->saveText('seo_default_title', $data['seo_default_title'] ?? null, 'seo');
        $this->saveText('seo_default_description', $data['seo_default_description'] ?? null, 'seo');

        $this->saveText('instagram_url', $data['instagram_url'] ?? null, 'social');
        $this->saveText('tiktok_url', $data['tiktok_url'] ?? null, 'social');

        $this->saveText('profile_album_id', $data['profile_album_id'] ?? null, 'profile');
        $this->saveText('profile_items_limit', $data['profile_items_limit'] ?? 2, 'profile');

        // LEGAL TEXT
        $this->saveText('legal_title', $data['legal_title'] ?? null, 'legal');
        $this->saveText('legal_description', $data['legal_description'] ?? null, 'legal');
        $this->saveText('legal_logo_1_alt', $data['legal_logo_1_alt'] ?? null, 'legal');
        $this->saveText('legal_logo_2_alt', $data['legal_logo_2_alt'] ?? null, 'legal');

        // UPLOADS
        $this->saveUpload($request, 'legal_logo_1', 'legal');
        $this->saveUpload($request, 'legal_logo_2', 'legal');

        $this->saveUpload($request, 'logo', 'general');
        $this->saveUpload($request, 'favicon', 'general');
        $this->saveUpload($request, 'og_image', 'seo');

        // CLEAR CACHE
        Cache::forget('fibermediaplay-cache-site_settings.all');

        return back()->with('success', 'Settings berhasil disimpan.');
    }

    private function saveText(string $key, $value, string $group): void
    {
        SiteSetting::setValue($key, $value, $group);
    }

    private function saveUpload(Request $request, string $key, string $group): void
    {
        if (!$request->hasFile($key)) return;

        $file = $request->file($key);
        if (!$file || !$file->isValid()) return;

        $oldPath = SiteSetting::getValue($key);
        if ($oldPath && Storage::disk('public')->exists($oldPath)) {
            Storage::disk('public')->delete($oldPath);
        }

        $path = $file->store('settings', 'public');
        SiteSetting::setValue($key, $path, $group);
    }

    private function isSuperAdmin(): bool
    {
        /** @var User|null $user */
        $user = Auth::user();
        if (!$user) return false;

        if (method_exists($user, 'hasRole')) {
            return $user->hasRole('superadmin');
        }

        if (method_exists($user, 'role')) {
            return optional($user->role)->slug === 'superadmin';
        }

        return ($user->role ?? null) === 'superadmin';
    }
}