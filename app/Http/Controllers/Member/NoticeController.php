<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use App\Models\Notice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NoticeController extends Controller
{
    public function getNotice()
    {
        $notices = Notice::where('user_id', '=', Auth::id())->latest()->paginate(10);
        return view('dashboard.pages.member.notice', ['notices' => $notices]);
    }

    public function getRedirectNotice(Request $request)
    {
        $notice = Notice::find($request->id);
        if (!$notice) {
            return abort(404);
        }
        $notice->status = "Seen";
        $notice->save();
        return redirect($notice->link);
    }

    public function getMarkSeen()
    {
        Notice::where('user_id', '=', Auth::id())->update(['status' => "Seen"]);
        return back();
    }
}
