<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $return = [];
        $sendingstatus = 10;
        switch ($sendingstatus) {
            case 10:
            {
                $return['status'] = 200;
                $return['message'] = 'success';
                $return['datas'] = [];
            }
            break;
            case 'WA':
            {
                $return['status'] = 200;
                $return['message'] = 'success WA';
                $return['datas'] = [];
            }
            break;
            case 'CHECK_BALANCE':
            {
                $return['status'] = 200;
                $return['message'] = 'success CHECK_BALANCE';
                $return['datas'] = [];
            }
            break;
        }
        dd($return);

        return view('home');
    }
}
