<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Report;
use Illuminate\Http\Request;
use App\Models\Post;

class ReportController extends Controller
{
    public function viewReport()
    {
        $report = Report::whereMonth('created_at', \Carbon\Carbon::now()->month)
            ->orderByRaw('day(created_at) desc')->get();
        return view('dashboard.pages.admin.report.view', ['report' => $report]);
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
        $post = Post::find($id_post[0]);
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
        return view('dashboard.pages.admin.report.post_ban',
            [
                'idTick' => $id,
                'post' => $post,
                'comments' => $comments,
                'related_posts' => $related_posts,
                'new_posts' => $new_posts,
            ]);
    }

    public function getFilter(Request $request)
    {
        if ($request->day == "0" && $request->month != "0") {
            $report = Report::whereMonth('created_at', $request->month)
                ->orderByRaw('day(created_at) desc')->get();
            $monthChoose = $request->month;
            return view('dashboard.pages.admin.report.view', ['report' => $report, 'monthC' => $monthChoose]);

        } elseif ($request->day != "0" && $request->month != "0") {
            $report = Report::whereMonth('created_at', '=', $request->month)
                ->whereDay('created_at', '=', $request->day)
                ->orderByRaw('day(created_at) desc')
                ->get();
            $monthChoose = $request->month;
            $dayChoose = $request->day;
            return view('dashboard.pages.admin.report.view', ['report' => $report, 'monthC' => $monthChoose, 'dayC' => $dayChoose]);
        }


    }
}
