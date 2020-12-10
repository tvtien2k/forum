<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Post;
use Illuminate\Http\Request;

class AjaxController extends Controller
{
    public function getCategory(Request $request)
    {
        $categories = Category::where('topic_id', '=', $request->topic_id)->get();
        foreach ($categories as $category) {
            echo "<option value=" . $category->id . ">" . $category->name . "</option>";
        }
    }

    public function getPost(Request $request)
    {
        $posts = Post::where([['title', 'like', '%' . $request->key . '%'], ['status', '=', 'display']])
            ->latest()->take(6)->get();
        foreach ($posts as $post) {
            echo '<option value="' . $post->title . '">';
        }
    }
}
