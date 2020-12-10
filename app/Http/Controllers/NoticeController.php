<?php

namespace App\Http\Controllers;

use App\Models\Notice;
use App\Models\Post;
use App\Models\Report;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NoticeController extends Controller
{
    function getIndexId()
    {
        $notice_latest = Notice::latest()->first();
        if ($notice_latest) {
            $index = (int)explode('-', $notice_latest->id)[3] + 1;
        } else {
            $index = 1;
        }
        return $index;
    }

    public function getAddPost(Request $request)
    {
        $post = Post::find(session('id'));
        $notice = new Notice();
        $notice->id = $post->id . '-' . $post->category->topic->mod->id . '-' . $this->getIndexId();
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
        $notice = new Notice();
        $notice->id = $post->id . '-' . $post->category->topic->mod->id . '-' . $this->getIndexId();
        $notice->post_id = $post->id;
        $notice->user_id = $post->category->topic->mod->id;
        $notice->content = Auth::user()->name . " has update a post that requires your approval";
        $notice->link = "mod/post/approval/" . $post->id;
        $notice->status = 'Not seen';
        $notice->save();
        return redirect('member/post/edit/' . $post->id)->with('status', 'Edit successfully!');
    }

    public function getAddComment()
    {
        $parent_comment = Post::find(session('parent_comment'));
        $new_comment = Post::find(session('new_comment'));
        $post_id = explode('-', $parent_comment->id)[0] . '-' . explode('_', explode('-', $parent_comment->id)[1])[0];
        $post = Post::find($post_id);
        if ($post_id == $parent_comment->id) {
            if ($post->author != $new_comment->author) {
                $notice = new Notice();
                $notice->id = $post->id . '-' . $post->author_id . '-' . $this->getIndexId();
                var_dump($notice->id);
                $notice->post_id = $post->id;
                $notice->user_id = $post->author_id;
                $notice->content = Auth::user()->name . ' commented on your "' . $post->title . '" post';
                $notice->link = "post/" . $post->slug . "#" . $new_comment->id;
                $notice->status = 'Not seen';
                $notice->save();
            }
        } else {
            if ($post->author != $new_comment->author) {
                $notice = new Notice();
                $notice->id = $post->id . '-' . $post->author_id . '-' . $this->getIndexId();
                $notice->post_id = $post->id;
                $notice->user_id = $post->author_id;
                $notice->content = Auth::user()->name . ' commented on your "' . $post->title . '" post';
                $notice->link = "post/" . $post->slug . "#" . $new_comment->id;
                $notice->status = 'Not seen';
                $notice->save();
            }
            if ($parent_comment->author != $new_comment->author) {
                $notice = new Notice();
                $notice->id = $parent_comment->id . '-' . $parent_comment->author_id . '-' . $this->getIndexId();
                $notice->post_id = $parent_comment->id;
                $notice->user_id = $parent_comment->author_id;
                $notice->content = Auth::user()->name . " reply your comment in post " . $post->title;
                $notice->link = "post/" . $post->slug . "#" . $new_comment->id;
                $notice->status = 'Not seen';
                $notice->save();
            }
        }
        return redirect('post/' . $post->slug . "#" . $new_comment->id);
    }

    public function getAddReport()
    {
        $report = Report::find(session('id'));
        $post_id = explode('-', $report->post_id)[0] . '-' . explode('_', explode('-', $report->post_id)[1])[0];
        $post = Post::find($post_id);
        $admins = User::where('level', '=', 2)->get();
        foreach ($admins as $admin) {
            $notice = new Notice();
            $notice->id = $report->post_id . '-' . $admin->id . '-' . $this->getIndexId();
            $notice->post_id = $report->post_id;
            $notice->user_id = $admin->id;
            if ($report->post_id == $post_id) {
                $notice->content = Auth::user()->name . ' has just reported on a post titled ' . $post->name;
            } else {
                $notice->content = Auth::user()->name . ' has just reported on a comment on a post titled ' . $post->name;
                $notice->link = "post/" . $post->slug . '#' . $report->post_id;
            }
            $notice->status = 'Not seen';
            $notice->save();
        }
        if ($report->post_id == $post_id) {
            return redirect('post/' . $post->slug);
        }
        return redirect('post/' . $post->slug . '#' . $report->post_id);
    }
}
