<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use App\Models\Report;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReportController extends Controller
{
    public function postAddReport(Request $request)
    {
        $notice_latest = Report::latest()->first();
        if ($notice_latest) {
            $index = (int)explode('-', $notice_latest->id)[3] + 1;
            $id = $request->id . '-' . Auth::id() . '-' . $index;
        } else {
            $id = $request->id . '-' . Auth::id() . '-1';
        }
        $report = new Report();
        $report->id = $id;
        $report->post_id = $request->id;
        $report->user_id = Auth::id();
        $report->content = $request->_content;
        $report->save();
        return redirect('notice/add-report')->with(['id' => $report->id]);
    }
}
