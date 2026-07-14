<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Coverage;
use Illuminate\Http\Request;

class CoverageController extends Controller
{
    public function index(Request $request)
    {
        $q = trim((string) $request->get('q', ''));

        $coverages = Coverage::query()
            ->when($q !== '', function ($query) use ($q) {
                $query->where(function ($w) use ($q) {
                    $w->where('name', 'like', "%{$q}%")
                      ->orWhere('district', 'like', "%{$q}%")
                      ->orWhere('city', 'like', "%{$q}%");
                });
            })
            ->orderByDesc('is_active')
            ->orderBy('sort_order')
            ->orderBy('name')
            ->paginate(12)
            ->withQueryString();

        return view('admin.coverages.index', compact('coverages', 'q'));
    }

    public function create()
    {
        return view('admin.coverages.create');
    }

    public function store(Request $request)
    {
        $data = $this->validated($request);

        $data['is_active']  = $request->boolean('is_active');
        $data['sort_order'] = (int) ($data['sort_order'] ?? 0);

        $coverage = Coverage::create($data);

        return redirect()
            ->route('admin.coverages.show', $coverage->id)
            ->with('success', 'Coverage berhasil dibuat.');
    }

    public function show(Coverage $coverage)
    {
        return view('admin.coverages.show', compact('coverage'));
    }

    public function edit(Coverage $coverage)
    {
        return view('admin.coverages.edit', compact('coverage'));
    }

    public function update(Request $request, Coverage $coverage)
    {
        $data = $this->validated($request);

        $data['is_active']  = $request->boolean('is_active');
        $data['sort_order'] = (int) ($data['sort_order'] ?? 0);

        $coverage->update($data);

        return redirect()
            ->route('admin.coverages.show', $coverage->id)
            ->with('success', 'Coverage berhasil diupdate.');
    }

    public function destroy(Coverage $coverage)
    {
        $coverage->delete();

        return redirect()
            ->route('admin.coverages.index')
            ->with('success', 'Coverage berhasil dihapus.');
    }

    private function validated(Request $request): array
    {
        return $request->validate([
            'name'       => ['required', 'string', 'max:100'],
            'district'   => ['nullable', 'string', 'max:100'],
            'city'       => ['required', 'string', 'max:100'],
            'lat'        => ['nullable', 'numeric', 'between:-90,90'],
            'lng'        => ['nullable', 'numeric', 'between:-180,180'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
            'is_active'  => ['nullable'],
        ]);
    }
}