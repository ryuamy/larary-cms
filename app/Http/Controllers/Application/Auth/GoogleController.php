<?php

namespace App\Http\Controllers\Application\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Userlogs;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class GoogleController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function redirect()
    {
        return Socialite::driver('google')->redirect();
    }

    public function callback()
    {
        if (Auth::check()) {
            return redirect('/home');
        }

        $oauthUser = Socialite::driver('google')->user();

        $user = User::where('google_id', $oauthUser->id)->first();

        if ($user) {
            Auth::loginUsingId($user->id);
        } else {
            $check_user_email = User::where('email', $oauthUser->email)->first();

            if($check_user_email) {
                return redirect(url('/login'))->with([
                    'error-message' => 'Email exists'
                ]);
            }

            $newUser = User::create([
                'uuid' => (string) Str::uuid(),
                'name' => $oauthUser->name,
                'slug' => create_slug('users', $oauthUser->name),
                'email' => $oauthUser->email,
                'google_id'=> $oauthUser->id,
                'status' => 1,
                'created_by' => 0,
                // password tidak akan digunakan ;)
                'password' => md5($oauthUser->token),
            ]);

            Userlogs::create([
                'user_id' => $newUser->id,
                'table' => 'USERS',
                'table_id' => $newUser->id,
                'action' => 'LOGIN',
                'action_detail'=> 'Success login',
                'ipaddress' => 1,
                'created_by' => $newUser->id,
            ]);

            Auth::login($newUser);
        }

        return redirect('/home');
    }

    public function logout(Request $request)
    {

    }
}
