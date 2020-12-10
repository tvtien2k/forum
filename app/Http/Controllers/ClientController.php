<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Topic;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ClientController extends Controller
{
    public function getHome()
    {
        $topics = Topic::all();
        $posts = Post::where('status', '=', 'display')->latest()->take(6)->get();
        return view('client.pages.home', ['topics' => $topics, 'posts' => $posts]);
    }

    public function getPost(Request $request)
    {
        $post = (Post::where([['slug', '=', $request->slug],
            ['status', '=', 'display']])->first());
        if (!$post) {
            return abort(404);
        }
        $comments = Post::where([['id', 'like', $post->id . '_%'],
            ['id', '<>', $post->id . '_UPDATE']])
            ->orderBy('id', 'asc')->get();
        $related_posts = Post::where([['category_id', '=', $post->category_id],
            ['status', '=', 'display'],
            ['id', '<>', $post->id]])
            ->take(3)->latest()->get();
        $new_posts = Post::where([['status', '=', 'display'],
            ['id', '<>', $post->id]])
            ->take(3)->latest()->get();
        return view('client.pages.post',
            ['post' => $post, 'comments' => $comments, 'related_posts' => $related_posts, 'new_posts' => $new_posts]);
    }

    public function getNewPosts()
    {
        $topics = Topic::all();
        $posts = Post::where('status', '=', 'display')->latest()->paginate(10);
        return view('client.pages.posts', ['topics' => $topics, 'posts' => $posts]);
    }

    public function getTopic(Request $request)
    {
        $topics = Topic::all();
        $topic = Topic::where('slug', '=', $request->slug)->first();
        if (!$topic) {
            return abort(404);
        }
        $posts = Post::leftJoin('tbl_category', 'tbl_category.id', '=', 'tbl_post.category_id')
            ->leftJoin('tbl_topic', 'tbl_topic.id', '=', 'tbl_category.topic_id')
            ->where([['tbl_topic.slug', '=', $request->slug], ['tbl_post.status', '=', 'display']])
            ->orderBy('tbl_post.created_at', 'desc')
            ->paginate(10);
        return view('client.pages.topic', ['topics' => $topics, 'topic' => $topic, 'posts' => $posts]);
    }
}
