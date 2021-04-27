<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\Report;
use Illuminate\Http\Request;
use App\Models\Topic;
use App\Models\Category;
use App\Models\User;
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

    public function getCategory( $topic_id)
    {
        echo "<option value=" . 'all' . ">   </option>";
        $categories = Category::where('topic_id', '=', $topic_id)->get();
        foreach ($categories as $category) {

            echo "<option value=" . $category->id . ">" . $category->name . "</option>";
        }

    }


    public function getMyPost()
    {
        $posts = Post::where('author_id', '=', Auth::id())
            ->where('status', '!=', 'comment')
            ->latest()
            ->get();
        return view('dashboard.pages.admin.post.my-post', ['posts' => $posts]);
    }

    public function getAddPost()
    {
        $topics = Topic::all();
        return view('dashboard.pages.admin.post.add', ['topics' => $topics]);
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
        if ($post->author->level == 2) {
            $post->status = 'post display';
        } else {
            $post->status = 'post approval';
        }
        $post->save();
        return redirect('admin/manage-post/list/my-post')
            ->with('status', 'Post successfully created!');
    }


    public function showPost($id = null)
    {
        if (isset($id)) {
            $user = DB::table('users')->where('id', $id)->get();
            foreach ($user as $u) {
                $u = $u;
            }
            $posts = Post::select('tbl_post.*')->where('author_id', '=', $id)->get();
            $topic = Topic::all();
            $cate = Category::all();
            return view('dashboard.pages.admin.post.post-i-manage', ['post' => $posts,
                'topic' => $topic, 'user' => $u, 'cate' => $cate]);
        } else {
            $topicFirst = DB::table('tbl_topic')->first();
            $posts = Post::leftJoin('tbl_category', 'tbl_category.id', '=', 'tbl_post.category_id')
                ->leftJoin('tbl_topic', 'tbl_topic.id', '=', 'tbl_category.topic_id')
                ->where('tbl_topic.id', '=', $topicFirst->id)
                ->select('tbl_post.*')
                ->get();
            $topic = Topic::all();
            $cate = Category::all();
            return view('dashboard.pages.admin.post.post-i-manage', ['post' => $posts,
                'topic' => $topic, 'cate' => $cate]);
        }

    }

    public function filter(Request $request, $id = null)
    {
        $topic = Topic::all();
        $cate = DB::table('tbl_category')->where('topic_id','=',$request->topic)->get();
        $topicChoose = $request->topic;
        $categoryChoose = $request->category;

        if (isset($id) != null) {
            $user = DB::table('users')->where('id', $id)->get();
            foreach ($user as $u) {
                $u = $u;
            }
            if ($categoryChoose != "all") {
                $posts = Post::select('tbl_post.*')
                    ->where('author_id', '=', $id)
                    ->where('category_id', '=', $request->category)
                    ->get();
                return view('dashboard.pages.admin.post.post-i-manage', ['post' => $posts,
                    'topic' => $topic, 'user' => $u, 'topicC' => $topicChoose, 'cateC' => $categoryChoose, 'cate' => $cate]);
            }
            if ($categoryChoose == "all") {
                $posts = Post::leftJoin('tbl_category', 'tbl_category.id', '=', 'tbl_post.category_id')
                    ->leftJoin('tbl_topic', 'tbl_topic.id', '=', 'tbl_category.topic_id')
                    ->where('tbl_topic.id', '=', $request->topic)
                    ->where('author_id', '=', $id)
                    ->select('tbl_post.*')
                    ->get();
                return view('dashboard.pages.admin.post.post-i-manage', ['post' => $posts,
                    'topic' => $topic, 'user' => $u, 'topicC' => $topicChoose, 'cateC' => $categoryChoose, 'cate' => $cate]);
            }

        } else {


            if ($request->topic != 'NULL' && $request->category == 'all'||$request->category == 'NULL') {
                $posts = Post::leftJoin('tbl_category', 'tbl_category.id', '=', 'tbl_post.category_id')
                    ->leftJoin('tbl_topic', 'tbl_topic.id', '=', 'tbl_category.topic_id')
                    ->where('tbl_topic.id', '=', $request->topic)
                    ->select('tbl_post.*')
                    ->get();
                return view('dashboard.pages.admin.post.post-i-manage', ['post' => $posts,
                    'topic' => $topic, 'topicC' => $topicChoose, 'cateC' => $categoryChoose, 'cate' => $cate]);
            } elseif ($request->category != 'all') {
                $posts = Post::leftjoin('tbl_category', 'tbl_category.id', '=', 'tbl_post.category_id')
                    ->where('tbl_category.id', '=', $request->category)
                    ->select('tbl_post.*')
                    ->get();
                return view('dashboard.pages.admin.post.post-i-manage', ['post' => $posts,
                    'topic' => $topic, 'topicC' => $topicChoose, 'cateC' => $categoryChoose, 'cate' => $cate]);
                //Lấy post theo poster

            } elseif ($id != null && $request->category != all) {
                $posts = Post::select('tbl_post.*')
                    ->where('author_id', '=', $id)
                    ->where('category_id', '=', $request->category)
                    ->get();
                return view('dashboard.pages.admin.post.post-i-manage', ['post' => $posts,
                    'topic' => $topic, 'topicC' => $topicChoose, 'cateC' => $categoryChoose, 'cate' => $cate]);
            }
        }
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
        return view('dashboard.pages.admin.post.edit',
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

    public function postDeletePost(Request $request)
    {
        $post = Post::where('id', 'like', $request->id . '%')->get();
        foreach ($post as $p) {
            $postDelete = Post::find($p->id);
            $postDelete->delete();
        }
        $report = Report::where('post_id', 'like', $request->id . '%')->get();
        foreach ($report as $r) {
            $reportDelete = Report::find($r->id);
            $reportDelete->delete();
        }
        return redirect('admin/manage-report/view');

    }

    public function deleteInClient(Request $request)
    {
        $post = Post::where('id', 'like', $request->id . '%')->get();
        foreach ($post as $p) {
            $postDelete = Post::find($p->id);
            $postDelete->delete();
        }
        if ($request->iscmt == 1) {
            return back();
        } else {
            return redirect('/home');
        }

    }

    public function deleteInAdmin(Request $request)
    {
        $post = Post::where('id', 'like', $request->id . '%')->get();
        foreach ($post as $p) {
            $postDelete = Post::find($p->id);
            $postDelete->delete();
        }
        if ($request->iscmt == 1) {
            return back();
        } else {
            return redirect('admin/manage-report/view');
        }

    }

    public function viewDetail($id)
    {
        $i = 0;
        $id_cmt_cut = [];
        $id_cmt = explode("_", $id);
        unset($id_cmt[0]);
        foreach ($id_cmt as $ic) {
            $id_cmt_cut[$i] = $ic;
            $i += 1;
        }
        //$id_cmt_cut = implode("_", $id_cmt_cut);
        $id_post = explode("_", $id);
        $post = Post::where('id', '=', $id_post[0])
            ->whereIn('status', ['post display', 'post update', 'post approval'])
            ->first();
        if (!$post) {
            abort(404);
        }
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
                'idTick' => $id,
                'post' => $post,
                'comments' => $comments,
                'related_posts' => $related_posts,
                'new_posts' => $new_posts,
            ]);
    }

    public function viewPost($id)
    {
        $i = 0;
        $id_cmt_cut = [];
        $id_cmt = explode("_", $id);
        unset($id_cmt[0]);
        foreach ($id_cmt as $ic) {
            $id_cmt_cut[$i] = $ic;
            $i += 1;
        }
        //$id_cmt_cut = implode("_", $id_cmt_cut);
        $id_post = explode("_", $id);
        $post = Post::where('id', '=', $id_post[0])
            ->whereIn('status', ['post display', 'post update', 'post approval'])
            ->first();
        if (!$post) {
            abort(404);
        }
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
                'idTick'=>$id,
                'post' => $post,
                'comments' => $comments,
                'related_posts' => $related_posts,
                'new_posts' => $new_posts,
            ]);
    }
}
