<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ClientController extends Controller
{
    public function getHome()
    {
        return view('client.index');
    }

    public function getPost(Request $request)
    {
        $post = (Post::
        where([['slug', '=', $request->slug],
            ['status', '<>', 'approval']
        ])->first());
        if (!$post) {
            return back();
        }
        $comments = Post::
        where([['id', 'like', $post->id . '_%'],
            ['id', '<>', $post->id . '_UPDATE']
        ])->orderBy('id', 'asc')->get();
        return view('client.pages.post', ['post' => $post, 'comments' => $comments]);
    }
}
