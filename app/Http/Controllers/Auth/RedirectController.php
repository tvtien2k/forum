<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RedirectController extends Controller
{
    public function redirectLogin()
    {
        if (Auth::check() && Auth::user()->level == 0) {
            return redirect('/member/dashboard');
        } elseif (Auth::check() && Auth::user()->level == 1) {
            return redirect('/mod/dashboard');
        } elseif (Auth::check() && Auth::user()->level == 2) {
            return redirect('/admin/dashboard');
        }
        return redirect('/login');
    }

    public function getMemberDashboard()
    {
        return view('dashboard.pages.member.dashboard');
    }
}
