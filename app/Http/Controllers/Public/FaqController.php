<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Faq;
use Illuminate\Http\Request;

class FaqController extends Controller
{
    public function index(Request $request)
    {
        $q = trim((string) $request->query('q', ''));
        $category = trim((string) $request->query('category', ''));

        $faqs = Faq::query()
            ->where('is_active', 1)
            ->when($category !== '', function ($query) use ($category) {
                $query->where('category', $category);
            })
            ->when($q !== '', function ($query) use ($q) {
                $query->where(function ($qq) use ($q) {
                    $qq->where('question', 'like', "%{$q}%")
                       ->orWhere('answer', 'like', "%{$q}%")
                       ->orWhere('category', 'like', "%{$q}%");
                });
            })
            ->orderBy('sort_order')
            ->orderBy('id')
            ->paginate(12)
            ->withQueryString();

        return view('public.faq.index', compact('faqs', 'q', 'category'));
    }
}
