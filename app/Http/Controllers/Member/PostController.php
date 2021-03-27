<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\Topic;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PostController extends Controller
{
    function to_id($slug)
    {
        $arr = explode('-', $slug);
        $id = "";
        foreach ($arr as $v) {
            $id .= substr($v, 0, 1);
        }
        return strtoupper($id);
    }

    public function getRecently()
    {
        $posts = DB::table('tbl_post AS post')
            ->whereIn('status', ['post display', 'post update'])
            ->whereExists(function ($query) {
                $query->from('tbl_post AS comment')
                    ->whereRaw('comment.id LIKE CONCAT(post.id, "%")')
                    ->where('comment.status', '=', 'comment')
                    ->where('comment.author_id', '=', Auth::id());
            })
            ->latest()
            ->paginate(4);
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
                'title' => 'Recently',
                'posts' => $posts,
                'my_posts_count' => $my_posts_count,
                'my_public_posts_count' => $my_public_posts_count,
                'my_approval_posts_count' => $my_approval_posts_count,
            ]);
    }

    public function getListPost()
    {
        $posts = Post::where('author_id', '=', Auth::id())
            ->where('status', 'like', 'post%')
            ->latest()
            ->get();
        return view('dashboard.pages.member.post.list', ['posts' => $posts]);
    }

    public function getViewPost(Request $request)
    {
        $post =
            (Post::where('id', '=', $request->id . '_UPDATE')
                ->where('author_id', '=', Auth::id())
                ->first())
            ??
            (Post::where('id', '=', $request->id)
                ->where('author_id', '=', Auth::id())
                ->first());
        if (!$post) {
            abort(404);
        }
        $related_posts = Post::where('category_id', '=', $post->category_id)
            ->whereIn('status', ['post display', 'post update'])
            ->where('id', '<>', $post->id)
            ->take(3)
            ->latest()
            ->get();
        $new_posts = Post::where('status', '<>', 'approval')
            ->whereIn('status', ['post display', 'post update'])
            ->take(3)
            ->latest()
            ->get();
        return view('dashboard.pages.member.post.view',
            [
                'post' => $post,
                'related_posts' => $related_posts,
                'new_posts' => $new_posts
            ]);
    }

    public function getAddPost()
    {
        $topics = Topic::all();
        return view('dashboard.pages.member.post.add', ['topics' => $topics]);
    }

    public function postAddPost(Request $request)
    {
        $request->validate([
            'title' => 'max:255',
            'slug' => 'unique:tbl_post|max:255',
            '_content' => 'required',
        ]);
        $post = new Post();
        $post->author_id = Auth::id();
        $post->category_id = $request->category_id;
        $post->title = $request->title;
        $post->slug = $request->slug;
        $post_latest = Post::where('status', 'like', 'post%')
            ->latest()
            ->first();
        if ($post_latest) {
            $index = (int)explode('-', $post_latest->id)[1] + 1;
            $post_id = $this->to_id($post->slug) . '-' . $index;
        } else {
            $post_id = $this->to_id($post->slug) . '-1';
        }
        $post->id = $post_id;
        $post->content = $request->_content;
        $post->description = $request->description;
        if ($post->category->topic->mod_id == $post->author_id || Auth::user()->level == 2) {
            $post->status = 'post display';
        } else {
            $post->status = 'post approval';
        }
        $post->save();
        if (Auth::user()->level == 0) {
            return redirect('member/post/list')
                ->with('status', 'Post successfully created!');
        } elseif (Auth::user()->level == 1) {
            return redirect('mod/post/list')
                ->with('status', 'Post successfully created!');
        }
        return redirect('admin/post/list')
            ->with('status', 'Post successfully created!');
    }

    public function postDeletePost(Request $request)
    {
        Post::where('id', 'like', $request->id . '%')
            ->delete();
        return back()
            ->with('status', 'Deleted successfully!');
    }

    public function getEditPost(Request $request)
    {
        $topics = Topic::all();
        $post =
            (Post::where('id', '=', $request->id . '_UPDATE')
                ->where('author_id', '=', Auth::id())
                ->first())
            ??
            (Post::where('id', '=', $request->id)
                ->where('author_id', '=', Auth::id())
                ->first());
        if (!$post) {
            abort(404);
        }
        return view('dashboard.pages.member.post.edit',
            [
                'post' => $post,
                'topics' => $topics
            ]);
    }

    public function postEditPost(Request $request)
    {
        $request->validate([
            'title' => 'max:255',
            'slug' => 'max:255',
            '_content' => 'required',
        ]);
        $post = Post::where('id', '=', $request->id)
            ->where('author_id', '=', Auth::id())
            ->first();
        if ($post->status == 'post approval' || $post->category->topic->mod_id == $post->author_id || Auth::user()->level == 2) {
            $post->category_id = $request->category_id;
            $post->title = $request->title;
            $post->slug = $request->slug;
            $post->content = $request->_content;
            $post->description = $request->description;
            $post->save();
        } else {
            if ($post->status == 'post display') {
                $post->status = 'post update';
                $post->save();
            }
            $post_update = Post::find($post->id . '_UPDATE') ?? new Post();
            $post_update->id = $request->id . '_UPDATE';
            $post_update->author_id = Auth::id();
            $post_update->category_id = $request->category_id;
            $post_update->title = $request->title;
            $post_update->slug = $request->slug;
            $post_update->content = $request->_content;
            $post_update->description = $request->description;
            $post_update->status = 'update';
            $post_update->save();
        }
        return back()->with('status', 'Edit successfully!');
    }


    public function postComment(Request $request)
    {
        $request->validate([
            '_content' => 'required',
        ]);
        $parent_comment = Post::find($request->id);
        $latest_comment = Post::where('id', 'REGEXP', '^' . $request->id . '_[0-9]*$')
            ->latest()
            ->first();
        if ($latest_comment) {
            $arr = explode('_', explode('-', $latest_comment->id)[1]);
            $index = (int)$arr[count($arr) - 1] + 1;
            $id = $request->id . '_' . $index;
        } else {
            $id = $request->id . '_1';
        }
        $new_comment = new Post();
        $new_comment->id = $id;
        $new_comment->author_id = Auth::id();
        $new_comment->content = $request->_content;
        $new_comment->status = 'comment';
        $new_comment->save();
        $post_id = explode('-', $parent_comment->id)[0] . '-' . explode('_', explode('-', $parent_comment->id)[1])[0];
        $post = Post::find($post_id);
        return redirect('post/' . $post->slug . "#" . explode($post->id . "_", $new_comment->id)[1]);
    }
}
