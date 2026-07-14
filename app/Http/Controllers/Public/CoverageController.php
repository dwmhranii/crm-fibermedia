<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Coverage;
use App\Models\Page;
use Illuminate\Http\Request;

class CoverageController extends Controller
{
    public function index(Request $request)
    {
        $page = Page::query()
            ->where('slug', 'coverage')
            ->where('is_active', 1)
            ->first();

        $pageHeading = $page->title ?? 'FibermediaPlay Fiber Area';
        $pageSubtitle = $page->meta_description
            ?? 'Cari wilayah kamu dan cek apakah sudah ter-cover jaringan Fiber kami di Malang Raya.';

        $coverages = Coverage::query()
            ->where('is_active', 1)
            ->orderBy('sort_order')
            ->orderBy('name')
            ->get();

        $coveragesForMap = $coverages->map(function ($c) {
            return [
                'id'       => $c->id,
                'name'     => (string) ($c->name ?? ''),
                'district' => (string) ($c->district ?? ''),
                'city'     => (string) ($c->city ?? ''),
                'lat'      => $c->lat,
                'lng'      => $c->lng,
            ];
        })->values();

        return view('public.coverage.index', [
            'pageHeading'     => $pageHeading,
            'pageSubtitle'    => $pageSubtitle,
            'coverages'       => $coverages,
            'coveragesForMap' => $coveragesForMap,
        ]);
    }
}