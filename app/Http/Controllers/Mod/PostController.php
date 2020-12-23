<?php

namespace App\Http\Controllers\Mod;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Post;
use App\Models\Topic;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class PostController extends Controller
{
    public function getMyPost()
    {
        $posts = Post::where('author_id', '=', Auth::id())
            ->where('status', 'like', 'post%')
            ->latest()
            ->get();
        return view('dashboard.pages.mod.post.my-post', ['posts' => $posts]);
    }

    public function getPostIManage()
    {
        $topic = Topic::where('mod_id', '=', Auth::id())
            ->first();
        $posts = Post::leftJoin('tbl_category', 'tbl_category.id', '=', 'tbl_post.category_id')
            ->leftJoin('tbl_topic', 'tbl_topic.id', '=', 'tbl_category.topic_id')
            ->where('tbl_topic.id', '=', $topic->id)
            ->where('status', 'like', 'post%')
            ->select('tbl_post.*')
            ->orderBy('tbl_post.created_at', 'desc')
            ->latest()
            ->get();
        return view('dashboard.pages.mod.post.post-i-manage',
            [
                'topic' => $topic,
                'category_id' => '',
                'posts' => $posts
            ]);
    }

    public function postPostIManage(Request $request)
    {
        $topic = Topic::where('mod_id', '=', Auth::id())
            ->first();
        if ($request->category_id == "All") {
            $posts = Post::leftJoin('tbl_category', 'tbl_category.id', '=', 'tbl_post.category_id')
                ->leftJoin('tbl_topic', 'tbl_topic.id', '=', 'tbl_category.topic_id')
                ->where('tbl_topic.id', '=', $topic->id)
                ->where('status', 'like', 'post%')
                ->select('tbl_post.*')
                ->orderBy('tbl_post.created_at', 'desc')
                ->latest()
                ->get();
        } else {
            $posts = Post::where('category_id', '=', $request->category_id)
                ->where('status', 'like', 'post%')
                ->latest()
                ->get();
        }
        return view('dashboard.pages.mod.post.post-i-manage',
            [
                'topic' => $topic,
                'category_id' => $request->category_id,
                'posts' => $posts
            ]);
    }

    public function getApprovalPost(Request $request)
    {
        $post =
            (Post::leftJoin('tbl_category', 'tbl_category.id', '=', 'tbl_post.category_id')
                ->leftJoin('tbl_topic', 'tbl_topic.id', '=', 'tbl_category.topic_id')
                ->where('tbl_post.id', '=', $request->id . '_UPDATE')
                ->where('tbl_topic.mod_id', '=', Auth::id())
                ->select('tbl_post.*')->first())
            ??
            (Post::leftJoin('tbl_category', 'tbl_category.id', '=', 'tbl_post.category_id')
                ->leftJoin('tbl_topic', 'tbl_topic.id', '=', 'tbl_category.topic_id')
                ->where('tbl_post.id', '=', $request->id)
                ->where('tbl_topic.mod_id', '=', Auth::id())
                ->select('tbl_post.*')->first());
        if (!$post) {
            return abort(404);
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
        return view('dashboard.pages.mod.post.approval',
            [
                'post' => $post,
                'related_posts' => $related_posts,
                'new_posts' => $new_posts
            ]);
    }

    public function postApprovalPost(Request $request)
    {
        if ($request->action == 'Approval') {
            $post_id = explode('-', $request->id)[0] . '-' . explode('_', explode('-', $request->id)[1])[0];
            $post = Post::find($post_id);
            if ($post->status == 'post update') {
                $post_update = Post::find($request->id);
                $post->category_id = $post_update->category_id;
                $post->title = $post_update->title;
                $post->slug = $post_update->slug;
                $post->content = $post_update->content;
                $post->description = $post_update->description;
                $post->updated_at = $post_update->created_at;
                $post->status = 'post display';
                $post->save();
                $post_update->delete();
            } else {
                $post->status = 'post display';
                $post->save();
            }
        } elseif ($request->action == 'Disapproval') {
            $post = Post::find($request->id);
            $post->status = 'post approval';
            $post->save();
        } else {
            return redirect('mod/post/list/post-i-manage');
        }
        return redirect('mod/post/list/post-i-manage')->with('status', 'Update successfully!');
    }
}
