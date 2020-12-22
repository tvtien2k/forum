<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RedirectController extends Controller
{
    public function redirectLogin()
    {
        $ss_post = session('POST');
        if ($ss_post) {
            foreach ($ss_post as $id) {
                $post = Post::find($id);
                $reader = $post->reader;
                if ($reader) {
                    if (!str_contains($reader, Auth::id())) {
                        $post->reader = $post->reader . ',' . Auth::id();
                    }
                } else {
                    $post->reader = Auth::id();
                }
                $post->save();
            }
        }
        if (Auth::user()->level == 0) {
            return redirect('/member/dashboard');
        } elseif (Auth::user()->level == 1) {
            return redirect('/mod/dashboard');
        } elseif (Auth::user()->level == 2) {
            return redirect('/admin/dashboard');
        }
        return redirect('/login');
    }

    public function getMemberDashboard()
    {
        $count_all_post = Post::where('author_id', '=', Auth::id())
                ->where('is_post', '=', true)
                ->count() ?? 0;
        $count_display_post = Post::where('author_id', '=', Auth::id())
                ->where('status', '<>', 'approval')
                ->where('is_post', '=', true)
                ->count() ?? 0;
        $count_approval_post = Post::where('author_id', '=', Auth::id())
                ->whereIn('status', ['update', 'approval'])
                ->count() ?? 0;
        return view('dashboard.pages.member.dashboard',
            [
                'count_all_post' => $count_all_post,
                'count_display_post' => $count_display_post,
                'count_approval_post' => $count_approval_post,
            ]);
    }

    public function getModDashboard()
    {
        $count_category_i_manage = Category::where('topic_id', '=', Auth::user()->topic->id)
                ->count() ?? 0;
        $count_post_i_manage = Post::leftJoin('tbl_category', 'tbl_category.id', '=', 'tbl_post.category_id')
                ->leftJoin('tbl_topic', 'tbl_topic.id', '=', 'tbl_category.topic_id')
                ->where('tbl_topic.id', '=', Auth::user()->topic->id)
                ->where('tbl_post.is_post', '=', true)
                ->select('tbl_post.*')
                ->count() ?? 0;
        $approved_post = Post::leftJoin('tbl_category', 'tbl_category.id', '=', 'tbl_post.category_id')
                ->leftJoin('tbl_topic', 'tbl_topic.id', '=', 'tbl_category.topic_id')
                ->where('tbl_topic.id', '=', Auth::user()->topic->id)
                ->where('tbl_post.status', '<>', 'approval')
                ->where('tbl_post.is_post', '=', true)
                ->select('tbl_post.*')
                ->count() ?? 0;
        $unapproved_post = Post::leftJoin('tbl_category', 'tbl_category.id', '=', 'tbl_post.category_id')
                ->leftJoin('tbl_topic', 'tbl_topic.id', '=', 'tbl_category.topic_id')
                ->where('tbl_topic.id', '=', Auth::user()->topic->id)
                ->whereIn('status', ['update', 'approval'])
                ->select('tbl_post.*')
                ->count() ?? 0;
        $count_all_my_post = Post::where('author_id', '=', Auth::id())
                ->where('is_post', '=', true)
                ->count() ?? 0;
        $count_display_post = Post::where('author_id', '=', Auth::id())
                ->where('status', '<>', 'approval')
                ->where('is_post', '=', true)
                ->count() ?? 0;
        $count_waiting_for_approval = Post::where('author_id', '=', Auth::id())
                ->whereIn('status', ['update', 'approval'])
                ->count() ?? 0;

        return view('dashboard.pages.mod.dashboard',
            [
                'count_category_i_manage' => $count_category_i_manage,
                'count_post_i_manage' => $count_post_i_manage,
                'approved_post' => $approved_post,
                'unapproved_post' => $unapproved_post,
                'count_all_my_post' => $count_all_my_post,
                'count_display_post' => $count_display_post,
                'count_waiting_for_approval' => $count_waiting_for_approval,
            ]);
    }
}
