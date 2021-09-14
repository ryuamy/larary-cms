<?php

namespace App\Http\Controllers\Application\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function form()
    {
        $datas = [
            "table" => "",
            "meta" => [
                "title" => "Login"
            ],
            "css" => [],
            "js" => [],
            "breadcrumb" => [
                array(
                    "title" => "",
                    "url" => ""
                ),
            ],
            "data" => [],
        ];

        return view("application.auth.login", $datas);
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect(url('/login'))->with([
            'success-message' => 'Success logout'
        ]);
    }
}
