<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:admin');
        $this->admin = Auth::guard('admin')->user();
        $this->table = '';
        $this->admin_url = admin_uri().$this->table;
    }

    public function index()
    {
        $datas = [
            'table' => $this->table,
            'meta' => [
                'title' => 'Dashboard'
            ],
            'css' => [],
            'js' => [
                'global/plugins/custom/fullcalendar/fullcalendar.bundle',
                'global/pages/widgets'
            ],
            'breadcrumb' => [
                array(
                    'title' => 'Dashboard',
                    'url' => 'dashboard'
                ),
            ],
            'admindata' => $this->admin,
            'data' => [],
        ];

        return view('admin.dashboard.dashboard', $datas);
    }
}
