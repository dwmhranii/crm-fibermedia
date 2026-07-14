<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\WhyCard;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class WhyCardController extends Controller
{
    public function index(Request $request): View
    {
        $q = trim((string) $request->get('q'));

        $whyCards = WhyCard::query()
            ->when($q, function ($query) use ($q) {
                $query->where(function ($sub) use ($q) {
                    $sub->where('title', 'like', "%{$q}%")
                        ->orWhere('subtitle', 'like', "%{$q}%")
                        ->orWhere('description', 'like', "%{$q}%");
                });
            })
            ->orderBy('sort_order')
            ->orderByDesc('id')
            ->paginate(10)
            ->withQueryString();

        return view('admin.why-cards.index', compact('whyCards', 'q'));
    }

    public function create(): View
    {
        return view('admin.why-cards.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'title'       => ['required', 'string', 'max:150'],
            'subtitle'    => ['nullable', 'string', 'max:200'],
            'description' => ['required', 'string'],
            'sort_order'  => ['required', 'integer', 'min:0'],
            'is_active'   => ['nullable', 'boolean'],
        ]);

        $validated['is_active'] = $request->boolean('is_active');

        // kolom lama tetap diisi null/aman
        $validated['icon'] = null;
        $validated['bg_color'] = null;
        $validated['text_color'] = null;

        WhyCard::create($validated);

        return redirect()
            ->route('admin.why-cards.index')
            ->with('success', 'Why Card berhasil ditambahkan.');
    }

    public function show(WhyCard $whyCard): View
    {
        return view('admin.why-cards.show', compact('whyCard'));
    }

    public function edit(WhyCard $whyCard): View
    {
        return view('admin.why-cards.edit', compact('whyCard'));
    }

    public function update(Request $request, WhyCard $whyCard): RedirectResponse
    {
        $validated = $request->validate([
            'title'       => ['required', 'string', 'max:150'],
            'subtitle'    => ['nullable', 'string', 'max:200'],
            'description' => ['required', 'string'],
            'sort_order'  => ['required', 'integer', 'min:0'],
            'is_active'   => ['nullable', 'boolean'],
        ]);

        $validated['is_active'] = $request->boolean('is_active');

        // reset field lama biar tidak kepakai
        $validated['icon'] = null;
        $validated['bg_color'] = null;
        $validated['text_color'] = null;

        $whyCard->update($validated);

        return redirect()
            ->route('admin.why-cards.index')
            ->with('success', 'Why Card berhasil diupdate.');
    }

    public function destroy(WhyCard $whyCard): RedirectResponse
    {
        $whyCard->delete();

        return redirect()
            ->route('admin.why-cards.index')
            ->with('success', 'Why Card berhasil dihapus.');
    }
}