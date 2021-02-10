<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
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
        // $this->middleware('auth:admin');
    }

    public function index()
    {
        $datas = [
            "table" => "",
            "meta" => [
                "title" => "Dashboard" . get_site_settings('title')
            ],
            "css" => [],
            "js" => [
                "metronic_v7.1.2/plugins/custom/fullcalendar/fullcalendar.bundle",
                "metronic_v7.1.2/js/pages/widgets"
            ],
            "breadcrumb" => [
                array(
                    "title" => "Dashboard",
                    "url" => "dashboard"
                ),
            ],
            "data" => [],
        ];

        return view("admin.dashboard.dashboard", $datas);
    }
}
