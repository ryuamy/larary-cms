<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
// use Validator;
// use Hash;
// use Session;
// use App\User;

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
        $this->middleware('guest:admin')->except('logout');
    }

    public function form()
    {
        $datas = [
            "table" => "",
            "meta" => [
                "title" => "Login Dashboard"
            ],
            "css" => [],
            "js" => [],
            "breadcrumb" => [
                array(
                    "title" => "Dashboard",
                    "url" => "dashboard"
                ),
            ],
            "data" => [],
        ];

        return view("admin.auth.login", $datas);
    }

    public function logout(Request $request)
    {
        Auth::guard('admin')->logout();
        // Auth::logout()->guard('admin');
        return redirect(admin_uri() . '/login/')->with([
            'success-message' => 'Success logout'
        ]);
    }
}
