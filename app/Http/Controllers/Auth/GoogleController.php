<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Laravel\Socialite\Facades\Socialite;

class GoogleController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function handleGoogleCallback()
    {
        try {
            $user = Socialite::driver('google')->user();
            $finduser = User::where('email', $user->email)->first();
            if ($finduser) {
                if ($finduser->google_id == null) {
                    $finduser->google_id = $user->id;
                    $finduser->save();
                }
                Auth::login($finduser);
            } else {
                $newUser = User::create([
                    'name' => $user->name,
                    'email' => $user->email,
                    'google_id' => $user->id,
                    'password' => Hash::make('12345678'),
                    'email_verified_at' => now(),
                ]);
                Auth::login($newUser);
            }
            return redirect()->intended('redirect');
        } catch (Exception $e) {
            dd($e->getMessage());
        }
    }
    public function checkLogin(Request $request){
        $credentials = $request->only('email', 'password');
        if (Auth::attempt($credentials)) {
            $auth=User::find(Auth::user()->id);
            if($auth->isBan==NULL){
                return redirect('admin/dashboard');
            }
            $auth=explode("/",$auth->isBan);
            $dateNow=getdate();
            if($auth[2]>$dateNow['year']){
                $auth=implode("-",$auth);
                session()->flash('ban', 'Account is banned until date '.$auth);
                return view('auth.login');
            }
            if($auth[2]==$dateNow['year']){
                if($auth[1]>$dateNow['mon']){
                    $auth=implode("-",$auth);
                    session()->flash('ban', 'Account is banned until date '.$auth);
                    return view('auth.login');
                }
                if($auth[1]==$dateNow['mon']){
                    if($auth[0]>$dateNow['mday']||$auth[0]==$dateNow['mday']){
                        $auth=implode("-",$auth);
                        session()->flash('ban', 'Account is banned until date '.$auth);
                        return view('auth.login');
                    }
                }
            }
        }
        else{
            return view('auth.login');
        }
    }
}
