<?php

namespace App\Http\Controllers\Mod;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Post;
use App\Models\Topic;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    public function getMyPost()
    {
        $posts = Post::where([
                ['author_id', '=', Auth::user()->id],
                ['is_post', '=', true]]
        )->latest()->get();
        return view('dashboard.pages.mod.post.my-post', ['posts' => $posts]);
    }

    public function getPostIManage()
    {
        $topic = Topic::where('mod_id', '=', Auth::id())->first();
        $posts = Post::leftJoin('tbl_category', 'tbl_category.id', '=', 'tbl_post.category_id')
            ->leftJoin('tbl_topic', 'tbl_topic.id', '=', 'tbl_category.topic_id')
            ->where('tbl_topic.id', '=', $topic->id)
            ->select('tbl_post.*')
            ->orderBy('tbl_post.created_at', 'desc')
            ->latest()->get();
        return view('dashboard.pages.mod.post.post-i-manage',
            [
                'topic' => $topic,
                'category_id' => '',
                'posts' => $posts
            ]);
    }

    public function postPostIManage(Request $request)
    {
        $topic = Topic::where('mod_id', '=', Auth::id())->first();
        if ($request->category_id == "All") {
            $posts = Post::leftJoin('tbl_category', 'tbl_category.id', '=', 'tbl_post.category_id')
                ->leftJoin('tbl_topic', 'tbl_topic.id', '=', 'tbl_category.topic_id')
                ->where('tbl_topic.id', '=', $topic->id)
                ->select('tbl_post.*')
                ->orderBy('tbl_post.created_at', 'desc')
                ->latest()->get();
        } else {
            $posts = Post::where('category_id', '=', $request->category_id)->latest()->get();
        }
        return view('dashboard.pages.mod.post.post-i-manage',
            [
                'topic' => $topic,
                'category_id' => $request->category_id,
                'posts' => $posts
            ]);
    }
}
