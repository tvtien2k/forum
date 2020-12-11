<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Notice;
use App\Models\Post;
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
        $count_notice = Notice::where([['user_id', '=', Auth::id()], ['status', '=', 'Not seen']])
                ->count() ?? 0;
        $count_all_post = Post::where([['author_id', '=', Auth::id()], ['is_post', '=', 1]])
                ->count() ?? 0;
        $count_display_post = Post::where([['author_id', '=', Auth::id()], ['is_post', '=', 1], ['status', '=', 'display']])
                ->count() ?? 0;
        $count_approval_post = Post::where([['author_id', '=', Auth::id()], ['is_post', '=', 1], ['status', '=', 'approval']])
                ->count() ?? 0;
        $notices = Notice::where([['user_id', '=', Auth::id()], ['status', '=', 'Not seen']])
            ->take(5)->get();
        return view('dashboard.pages.member.dashboard',
            [
                'count_notice' => $count_notice,
                'count_all_post' => $count_all_post,
                'count_display_post' => $count_display_post,
                'count_approval_post' => $count_approval_post,
                'notices' => $notices
            ]);
    }
}
