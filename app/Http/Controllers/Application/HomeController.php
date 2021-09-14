<?php

namespace App\Http\Controllers\Application;

use App\Http\Controllers\Controller;

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
        // $this->middleware('auth:web');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $datas = [
            'meta' => [
                'title' => 'Home',
                'description' => '',
            ],
            'css' => [],
            'js' => [],
            'breadcrumb' => [],
        ];

        return view('application.home.index', $datas);
    }
}
