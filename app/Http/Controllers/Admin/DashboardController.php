<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use App\Models\Coverage;
use App\Models\User;
use App\Models\Package;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $packagesCount  = Package::count();
        $coveragesCount = Coverage::count();

        $isSuper = optional($user->role)->slug === 'superadmin';

        $usersCount     = $isSuper ? User::count() : 0;
        $bannersCount = $isSuper ? Banner::count() : 0;

        return view('admin.dashboard', compact(
            'packagesCount',
            'coveragesCount',
            'usersCount',
            'bannersCount'
        ));
    }
}