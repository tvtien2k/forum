<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class RedirectController extends Controller
{
    function checkPost()
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
    }

    public function redirectLogin()
    {
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
        $recently = DB::table('tbl_post AS post')
            ->whereIn('status', ['post display', 'post update'])
            ->whereExists(function ($query) {
                $query->from('tbl_post AS comment')
                    ->whereRaw('comment.id LIKE CONCAT(post.id, "%")')
                    ->where('comment.status', '=', 'comment')
                    ->where('comment.author_id', '=', Auth::id());
            })
            ->latest()
            ->get();
        if ($recently->count()) {
            $arr_category_id = [];
            foreach ($recently as $post) {
                array_push($arr_category_id, $post->category_id);
            }
            $posts = Post::whereIn('category_id', $arr_category_id)
                ->whereIn('status', ['post display', 'post update'])
                ->latest()
                ->paginate(4);
        } else {
            $posts = Post::whereIn('status', ['post display', 'post update'])
                ->orderBy('view', 'desc')
                ->latest()
                ->paginate(4);
        }
        $my_posts_count = Post::where('author_id', '=', Auth::id())
                ->where('status', 'like', 'post%')
                ->count() ?? 0;
        $my_public_posts_count = Post::where('author_id', '=', Auth::id())
                ->whereIn('status', ['post display', 'post update'])
                ->count() ?? 0;
        $my_approval_posts_count = Post::where('author_id', '=', Auth::id())
                ->where('status', '=', 'post approval')
                ->count() ?? 0;
        return view('dashboard.pages.member.dashboard',
            [
                'title' => 'Recommended',
                'posts' => $posts,
                'my_posts_count' => $my_posts_count,
                'my_public_posts_count' => $my_public_posts_count,
                'my_approval_posts_count' => $my_approval_posts_count,
            ]);
    }

    public function getModDashboard()
    {
        $posts = Post::leftJoin('tbl_category', 'tbl_category.id', '=', 'tbl_post.category_id')
            ->leftJoin('tbl_topic', 'tbl_topic.id', '=', 'tbl_category.topic_id')
            ->where('tbl_topic.id', '=', Auth::user()->topic->id)
            ->where('tbl_post.status', '=', 'post approval')
            ->select('tbl_post.*')
            ->latest()
            ->paginate(6);
        $count_all_post = Post::where('author_id', '=', Auth::id())
                ->where('status', 'like', 'post%')
                ->count() ?? 0;
        $count_display_post = Post::where('author_id', '=', Auth::id())
                ->whereIn('status', ['post display', 'post update'])
                ->count() ?? 0;
        $count_approval_post = Post::where('author_id', '=', Auth::id())
                ->where('status', '=', 'post approval')
                ->count() ?? 0;
        return view('dashboard.pages.mod.dashboard',
            [
                'posts' => $posts,
                'count_all_post' => $count_all_post,
                'count_display_post' => $count_display_post,
                'count_approval_post' => $count_approval_post,
            ]);
    }

    public function getAdminDashboard($id = null)
    {
        if ($id != null) {
            $count_all_post = Post::where('author_id', '=', $id)
                    ->where('status', '!=', 'comment')
                    ->count() ?? 0;
            $user = User::find($id);
            return view('dashboard.pages.admin.dashboard', ['count_all_post' => $count_all_post, 'user' => $user]);
        } else {
            $count_all_post = Post::where('author_id', '=', Auth::id())
                    ->where('status', '!=', 'comment')
                    ->count() ?? 0;
            return view('dashboard.pages.admin.dashboard', ['count_all_post' => $count_all_post]);
        }

    }

    public function checkLogin(Request $request)
    {
        $auth = User::find(Auth::user()->id);
        if ($auth->isBan == null) {
            $this->checkPost();
            if (Auth::user()->level == 0) {
                return redirect('/member/dashboard');
            } elseif (Auth::user()->level == 1) {
                return redirect('/mod/dashboard');
            } elseif (Auth::user()->level == 2) {
                return redirect('/admin/dashboard');
            }
            return redirect('/login');
        }
        $auth = explode("/", $auth->isBan);
        $dateNow = getdate();
        if ($auth[2] > $dateNow['year']) {
            $auth = implode("-", $auth);
            Auth::logout();
            return redirect('login')->with('ban', 'Account is banned until date ' . $auth);
        }
        if ($auth[2] == $dateNow['year']) {
            if ($auth[1] > $dateNow['mon']) {
                $auth = implode("-", $auth);
                Auth::logout();
                return redirect('login')->with('ban', 'Account is banned until date ' . $auth);
            }
            if ($auth[1] == $dateNow['mon']) {
                if ($auth[0] > $dateNow['mday'] || $auth[0] == $dateNow['mday']) {
                    $auth = implode("-", $auth);
                    Auth::logout();
                    return redirect('login')->with('ban', 'Account is banned until date ' . $auth);
                }
            }
        }
    }
}
