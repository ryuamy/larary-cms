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
                "title" => "Login Dashboard" . get_site_settings('title')
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
   
    // public function login(Request $request)
    // {   
    //     $input = $request->all();
   
    //     $this->validate($request, [
    //         'email' => 'required|email',
    //         'password' => 'required',
    //     ]);
   
    //     if(auth()->attempt(array('email' => $input['email'], 'password' => $input['password'])))
    //     {
    //         // if (auth()->user()->is_admin == 1) {
    //         //     return redirect()->route('admin.home');
    //         // }else{
    //         //     return redirect()->route('home');
    //         // }
    //         echo "Success login";
    //     }else{
    //         // return redirect()->route('login')
    //         //     ->with('error','Email-Address And Password Are Wrong.');
    //         echo "Email-Address And Password Are Wrong";
    //     }
          
    // }
}
