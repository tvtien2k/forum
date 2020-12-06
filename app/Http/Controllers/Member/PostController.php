<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use App\Http\Controllers\InsertDataController;
use App\Models\Category;
use App\Models\Notice;
use App\Models\Post;
use App\Models\Topic;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Mockery\Matcher\Not;

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
        ]);
        $post = new Post();
        $post->author_id = Auth::user()->id;
        $post->category_id = $request->category_id;
        $post->title = $request->title;
        $post->slug = $request->slug;
        $post_latest = Post::latest()->first();
        if ($post_latest) {
            $index = (int)explode('-', $post_latest->id)[1] + 1;
            $post_id = $this->to_id($post->slug) . '-' . $index;
        } else {
            $post_id = $this->to_id($post->slug) . '-1';
        }
        $post->id = $post_id;
        $post->content = $request->_content;
        $post->status = 'approval';
        $post->is_post = true;
        $post->allow_comment = $request->allow_comment;
        $post->save();
        return redirect('notice/add-post')->with(['id' => $post->id]);
    }

    public function getListPost()
    {
        $posts = Post::
        where([
                ['author_id', '=', Auth::user()->id],
                ['is_post', '=', true]]
        )->latest()->get();
        return view('dashboard.pages.member.post.list', ['posts' => $posts]);
    }

    public function postDeletePost(Request $request)
    {
        Post::
        where([
            ['id', 'like', $request->id . '%'],
            ['author_id', '=', Auth::user()->id]
        ])->delete();
        Notice::where('post_id', 'like', $request->id . '%')->delete();
        return redirect('member/post/list')->with('status', 'Deleted successfully!');
    }

    public function getEditPost(Request $request)
    {
        $topics = Topic::all();
        $post = (Post::
            where([['id', '=', $request->id . '_UPDATE'],
                ['author_id', '=', Auth::user()->id]
            ])->first()) ?? (Post::
            where([['id', '=', $request->id],
                ['author_id', '=', Auth::user()->id]
            ])->first());
        return view('dashboard.pages.member.post.edit', ['post' => $post, 'topics' => $topics]);
    }

    public function postEditPost(Request $request)
    {
        $request->validate([
            'title' => 'max:255',
            'slug' => 'max:255',
        ]);
        $post = Post::where([['id', '=', $request->id],
            ['author_id', '=', Auth::user()->id]
        ])->first();
        if ($post->status == 'approval') {
            $post->category_id = $request->category_id;
            $post->title = $request->title;
            $post->slug = $request->slug;
            $post->content = $request->_content;
            $post->allow_comment = $request->allow_comment;
            $post->save();
        } elseif ($post->status == 'display') {
            $post->status = 'update';
            $post->save();
            $post_update = new Post();
            $post_update->id = $request->id . '_UPDATE';
            $post_update->author_id = Auth::user()->id;
            $post_update->category_id = $request->category_id;
            $post_update->title = $request->title;
            $post_update->slug = $request->slug;
            $post_update->content = $request->_content;
            $post_update->status = 'approval';
            $post_update->is_post = false;
            $post_update->allow_comment = $request->allow_comment;
            $post_update->save();
        } elseif ($post->status == 'update') {
            $post_update = Post::find($post->id . '_UPDATE');
            $post_update->category_id = $request->category_id;
            $post_update->title = $request->title;
            $post_update->slug = $request->slug;
            $post_update->content = $request->_content;
            $post_update->allow_comment = $request->allow_comment;
            $post_update->save();
        } else {
            return back();
        }
        return redirect('notice/update-post')->with(['id' => $post->id]);
    }

    public function getViewPost(Request $request)
    {
        $post = (Post::
            where([['id', '=', $request->id . '_UPDATE'],
                ['author_id', '=', Auth::user()->id]
            ])->first()) ?? (Post::
            where([['id', '=', $request->id],
                ['author_id', '=', Auth::user()->id]
            ])->first());
        return view('dashboard.pages.member.post.view', ['post' => $post]);
    }
}
