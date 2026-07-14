<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Faq;
use Illuminate\Http\Request;

class FaqController extends Controller
{
    private array $categories = [
        'general'      => 'Umum',
        'billing'      => 'Tagihan & Pembayaran',
        'technical'    => 'Gangguan Teknis',
        'installation' => 'Pemasangan',
        'coverage'     => 'Coverage Area',
        'package'      => 'Paket & Layanan',
    ];

    public function index(Request $request)
    {
        $q = trim((string) $request->get('q', ''));
        $category = trim((string) $request->get('category', ''));

        $faqs = Faq::query()
            ->when($q !== '', function ($query) use ($q) {
                $query->where(function ($w) use ($q) {
                    $w->where('question', 'like', "%{$q}%")
                      ->orWhere('answer', 'like', "%{$q}%");
                });
            })
            ->when($category !== '', function ($query) use ($category) {
                $query->where('category', $category);
            })
            ->orderByDesc('is_active')
            ->orderBy('sort_order')
            ->latest('id')
            ->paginate(12)
            ->withQueryString();

        $categories = $this->categories;

        return view('admin.faqs.index', compact('faqs', 'q', 'category', 'categories'));
    }

    public function create()
    {
        $categories = $this->categories;

        return view('admin.faqs.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $data = $this->validated($request);

        $data['is_active'] = $request->boolean('is_active');
        $data['sort_order'] = (int) ($data['sort_order'] ?? 0);

        $faq = Faq::create($data);

        return redirect()
            ->route('admin.faqs.show', $faq->id)
            ->with('success', 'FAQ berhasil ditambahkan.');
    }

    public function show(Faq $faq)
    {
        $categories = $this->categories;

        return view('admin.faqs.show', compact('faq', 'categories'));
    }

    public function edit(Faq $faq)
    {
        $categories = $this->categories;

        return view('admin.faqs.edit', compact('faq', 'categories'));
    }

    public function update(Request $request, Faq $faq)
    {
        $data = $this->validated($request);

        $data['is_active'] = $request->boolean('is_active');
        $data['sort_order'] = (int) ($data['sort_order'] ?? 0);

        $faq->update($data);

        return redirect()
            ->route('admin.faqs.show', $faq->id)
            ->with('success', 'FAQ berhasil diperbarui.');
    }

    public function destroy(Faq $faq)
    {
        $faq->delete();

        return redirect()
            ->route('admin.faqs.index')
            ->with('success', 'FAQ berhasil dihapus.');
    }

    private function validated(Request $request): array
    {
        return $request->validate([
            'question'   => ['required', 'string', 'max:255'],
            'answer'     => ['required', 'string'],
            'category'   => ['nullable', 'in:' . implode(',', array_keys($this->categories))],
            'sort_order' => ['nullable', 'integer', 'min:0'],
            'is_active'  => ['nullable'],
        ]);
    }
}