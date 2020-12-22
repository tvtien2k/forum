<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Post;
use App\Models\Topic;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use function Livewire\str;

class ClientController extends Controller
{
    public function getHome()
    {
        $topics = Topic::all();
        $posts = Post::whereIn('status', ['post display', 'post update'])
            ->latest()
            ->take(6)
            ->get();
        return view('client.pages.home',
            [
                'topics' => $topics,
                'posts' => $posts
            ]);
    }

    public function getPost(Request $request)
    {
        $post = Post::where('slug', '=', $request->slug)
            ->whereIn('status', ['post display', 'post update'])
            ->first();
        if (!$post) {
            abort(404);
        }
        $ss_post = session('POST');
        if ($ss_post) {
            if (!in_array($post->id, $ss_post)) {
                array_push($ss_post, $post->id);
                $post->view = $post->view + 1;
            }
        } else {
            $ss_post = [$post->id];
            $post->view = $post->view + 1;
        }
        $post->save();
        session(['POST' => $ss_post]);
        if (Auth::check()) {
            $reader = $post->reader;
            if ($reader) {
                if (!str_contains($reader, Auth::id())) {
                    $post->reader = $post->reader . ',' . Auth::id();
                }
            } else {
                $post->reader = Auth::id();
            }
        }
        $post->save();
        $comments = Post::where('id', 'like', $post->id . '_%')
            ->where('status', '=', 'comment')
            ->orderBy('id', 'asc')
            ->get();
        $related_posts = Post::where('category_id', '=', $post->category_id)
            ->whereIn('status', ['post display', 'post update'])
            ->where('id', '<>', $post->id)
            ->take(3)
            ->latest()
            ->get();
        $new_posts = Post::whereIn('status', ['post display', 'post update'])
            ->where('id', '<>', $post->id)
            ->take(3)
            ->latest()
            ->get();
        return view('client.pages.post',
            [
                'post' => $post,
                'comments' => $comments,
                'related_posts' => $related_posts,
                'new_posts' => $new_posts
            ]);
    }

    public function getNewPosts()
    {
        $topics = Topic::all();
        $posts = Post::whereIn('status', ['post display', 'post update'])
            ->latest()
            ->paginate(10);
        return view('client.pages.posts',
            [
                'title' => 'New Posts',
                'topics' => $topics,
                'posts' => $posts
            ]);
    }

    public function getPopularPosts()
    {
        $topics = Topic::all();
        $posts = Post::whereIn('status', ['post display', 'post update'])
            ->orderBy('view', 'desc')
            ->latest()
            ->paginate(10);
        return view('client.pages.posts',
            [
                'title' => 'Popular Posts',
                'topics' => $topics,
                'posts' => $posts
            ]);
    }

    public function getTopic(Request $request)
    {
        $topics = Topic::all();
        $topic = Topic::where('slug', '=', $request->topic_slug)
            ->first();
        if (!$topic) {
            abort(404);
        }
        $posts = Post::leftJoin('tbl_category', 'tbl_category.id', '=', 'tbl_post.category_id')
            ->leftJoin('tbl_topic', 'tbl_topic.id', '=', 'tbl_category.topic_id')
            ->where('tbl_topic.slug', '=', $request->topic_slug)
            ->whereIn('status', ['post display', 'post update'])
            ->select('tbl_post.*')
            ->orderBy('tbl_post.created_at', 'desc')
            ->paginate(10);
        return view('client.pages.posts',
            [
                'title' => 'Topic: ' . $topic->name,
                'topics' => $topics,
                'topic' => $topic,
                'posts' => $posts
            ]);
    }

    public function getCategory(Request $request)
    {
        $topics = Topic::all();
        $category = Category::where('slug', '=', $request->category_slug)
            ->first();
        if (!$category) {
            abort(404);
        }
        $posts = Post::where('category_id', '=', $category->id)
            ->whereIn('status', ['post display', 'post update'])
            ->latest()
            ->paginate(10);
        return view('client.pages.posts',
            [
                'title' => 'Category: ' . $category->name,
                'topics' => $topics,
                'category' => $category,
                'posts' => $posts
            ]);
    }

    public function getSearch(Request $request)
    {
        $topics = Topic::all();
        $posts = Post::where('title', 'like', '%' . $request->key . '%')
            ->whereIn('status', ['post display', 'post update'])
            ->latest()
            ->paginate(10)
            ->withQueryString();
        return view('client.pages.posts',
            [
                'title' => 'Search: ' . $request->key,
                'topics' => $topics,
                'key' => $request->key,
                'posts' => $posts
            ]);
    }

    public function getUser(Request $request)
    {
        $topics = Topic::all();
        $user = User::find($request->id);
        $posts = Post::where('author_id', '=', $user->id)
            ->whereIn('status', ['post display', 'post update'])
            ->latest()
            ->paginate(6);
        return view('client.pages.user',
            [
                'topics' => $topics,
                'user' => $user,
                'posts' => $posts
            ]);
    }
}
