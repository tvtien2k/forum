<?php

namespace App\Http\Controllers;

use App\Models\Notice;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NoticeController extends Controller
{
    public function getAddPost(Request $request)
    {
        $post = Post::find(session('id'));
        $notice = new Notice();
        $notice_latest = Notice::latest()->first();
        if ($notice_latest) {
            $index = (int)explode('-', $notice_latest->id)[3] + 1;
            $notice_id = $post->id . '-' . $post->category->topic->mod->id . '-' . $index;
        } else {
            $notice_id = $post->id . '-' . $post->category->topic->mod->id . '-1';
        }
        $notice->id = $notice_id;
        $notice->post_id = $post->id;
        $notice->user_id = $post->category->topic->mod->id;
        $notice->content = Auth::user()->name . " has created a new post that requires your approval";
        $notice->link = "mod/post/approval/" . $post->id;
        $notice->status = 'Not seen';
        $notice->save();
        return redirect('member/post/list')->with('status', 'Create successful posts! We need some time to review your post.');
    }

    public function getUpdatePost()
    {
        $post = Post::find(session('id'));
        if (Notice::where('post_id', '=', $post->id)->first()) {
            Notice::where('post_id', '=', $post->id)->delete();
        }
        $notice = new Notice();
        $notice_latest = Notice::latest()->first();
        if ($notice_latest) {
            $index = (int)explode('-', $notice_latest->id)[3] + 1;
            $notice_id = $post->id . '-' . $post->category->topic->mod->id . '-' . $index;
        } else {
            $notice_id = $post->id . '-' . $post->category->topic->mod->id . '-1';
        }
        $notice->id = $notice_id;
        $notice->post_id = $post->id;
        $notice->user_id = $post->category->topic->mod->id;
        $notice->content = Auth::user()->name . " has update a post that requires your approval";
        $notice->link = "mod/post/approval/" . $post->id;
        $notice->status = 'Not seen';
        $notice->save();
        return redirect('member/post/edit/' . $post->id)->with('status', 'Edit successfully!');
    }
}
