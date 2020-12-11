<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AccountController extends Controller
{
    public function getProfile()
    {
        return view('dashboard.pages.member.account.profile');
    }

    public function postProfile(Request $request)
    {
        $user = User::find(Auth::id());
        $user->name = $request->name;
        $user->gender = $request->gender;
        $user->birthday = $request->birthday;
        $user->description = $request->description;
        $user->save();
        return back();
    }
}
