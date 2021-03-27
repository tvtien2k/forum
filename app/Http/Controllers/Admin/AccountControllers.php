<?php
namespace App\Http\Controllers\Admin;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
class AccountControllers extends Controller{
    public function getProfile()
    {
        return view('dashboard.pages.admin.account.profile');
    }
    public function postProfile(Request $request)
    {
        $user = User::find(Auth::id());
        $user->name = $request->name;
        $user->gender = $request->gender;
        $user->birthday = $request->birthday;
        $user->description = $request->description;
        $user->save();
        return back()->with('status', 'Update profile successfully!');
    }

    public function getSecurity()
    {
        return view('dashboard.pages.admin.account.security');
    }

    public function getForgotPassword()
    {
        Auth::logout();
        return redirect('forgot-password');
    }

    public function postChangePassword(Request $request)
    {
        $request->validate([
            'new_pass' => 'min:8',
        ]);
        $user = User::find(Auth::id());
        if (!Hash::check($request->old_pass, $user->password)) {
            return back()->withErrors('Old password is incorrect');
        } elseif ($request->new_pass != $request->re_pass) {
            return back()->withErrors('Password confirmation is incorrect');
        }
        $user->password = Hash::make($request->new_pass);
        $user->save();
        Auth::login($user);
        return back()->with('status', 'Password changed successfully!');
    }
}
