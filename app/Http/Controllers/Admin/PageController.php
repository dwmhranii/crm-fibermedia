<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Page;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;

class PageController extends Controller
{
    private function isSuper(): bool
    {
        return Auth::user()?->role?->slug === 'superadmin';
    }

    public function index(Request $request)
    {
        $q = trim((string) $request->get('q'));

        $pages = Page::query()
            ->when($q, function ($query) use ($q) {
                $query->where('title', 'like', "%{$q}%")
                      ->orWhere('slug', 'like', "%{$q}%");
            })
            ->latest('id')
            ->paginate(10);

        return view('admin.pages.index', compact('pages', 'q'));
    }

    public function show(Page $page)
    {
        return view('admin.pages.show', compact('page'));
    }

    public function create()
    {
        if (!$this->isSuper()) {
            abort(403, 'Unauthorized');
        }

        return view('admin.pages.create');
    }

    public function store(Request $request)
    {
        if (!$this->isSuper()) {
            abort(403, 'Unauthorized');
        }

        $data = $request->validate([
            'title' => ['required', 'string', 'max:191'],
            'slug' => ['nullable', 'string', 'max:191', 'alpha_dash', Rule::unique('pages', 'slug')],
            'content' => ['required', 'string'],
            'meta_title' => ['nullable', 'string', 'max:191'],
            'meta_description' => ['nullable', 'string', 'max:255'],
            'og_image' => ['nullable', 'string', 'max:255'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        // slug fallback
        $slug = $data['slug'] ?? Str::slug($data['title']);
        $slug = $this->uniqueSlug($slug);

        $page = Page::create([
            ...$data,
            'slug' => $slug,
            'is_active' => (bool) ($request->boolean('is_active')),
            'created_by' => Auth::id(),
            'updated_by' => Auth::id(),
        ]);

        return redirect()
            ->route('admin.pages.index')
            ->with('success', "Page '{$page->title}' berhasil dibuat.");
    }

    public function edit(Page $page)
    {
        if (!$this->isSuper()) {
            abort(403, 'Unauthorized');
        }

        return view('admin.pages.edit', compact('page'));
    }

    public function update(Request $request, Page $page)
    {
        if (!$this->isSuper()) {
            abort(403, 'Unauthorized');
        }

        $data = $request->validate([
            'title' => ['required', 'string', 'max:191'],
            'slug' => [
                'nullable',
                'string',
                'max:191',
                'alpha_dash',
                Rule::unique('pages', 'slug')->ignore($page->id),
            ],
            'content' => ['required', 'string'],
            'meta_title' => ['nullable', 'string', 'max:191'],
            'meta_description' => ['nullable', 'string', 'max:255'],
            'og_image' => ['nullable', 'string', 'max:255'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        $slug = $data['slug'] ?? Str::slug($data['title']);
        $slug = $this->uniqueSlug($slug, $page->id);

        $page->update([
            ...$data,
            'slug' => $slug,
            'is_active' => (bool) ($request->boolean('is_active')),
            'updated_by' => Auth::id(),
        ]);

        return redirect()
            ->route('admin.pages.index')
            ->with('success', "Page '{$page->title}' berhasil diupdate.");
    }

    public function destroy(Page $page)
    {
        if (!$this->isSuper()) {
            abort(403, 'Unauthorized');
        }

        $title = $page->title;
        $page->delete();

        return redirect()
            ->route('admin.pages.index')
            ->with('success', "Page '{$title}' berhasil dihapus.");
    }

    /**
     * Generate slug unik.
     * Jika sudah ada, jadi: slug-2, slug-3, dst.
     */
    private function uniqueSlug(string $base, ?int $ignoreId = null): string
    {
        $base = Str::slug($base);
        $slug = $base;
        $i = 2;

        while (
            Page::query()
                ->when($ignoreId, fn($q) => $q->where('id', '!=', $ignoreId))
                ->where('slug', $slug)
                ->exists()
        ) {
            $slug = "{$base}-{$i}";
            $i++;
        }

        return $slug;
    }
}
