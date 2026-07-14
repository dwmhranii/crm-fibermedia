<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PageController extends Controller
{
    public function show() {
        $page = \App\Models\Page::where('slug','profil')->where('is_active',1)->firstOrFail();
        return view('public.page.show', compact('page'));
    }

}
