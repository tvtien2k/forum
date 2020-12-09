<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class NoticeController extends Controller
{
    public function getNotice()
    {
        return view('dashboard.pages.member.notice');
    }
}
