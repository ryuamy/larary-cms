<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PagesController extends Controller
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
        // $odoo = new \Edujugon\Laradoo\Odoo();

        // $version = $odoo->version();
        // dd($version);

        $datas = [
            'table' => '',
            'meta' => [
                'title' => 'CMS Pages',
                'heading' => 'Pages Management'
            ],
            'css' => [],
            'js' => [
                'js/admin/datatable-pages'
            ],
            'breadcrumb' => [
                array(
                    'title' => 'Pages',
                    'url' => 'pages'
                ),
            ],
            'data' => [],
        ];

        return view('admin.pages.index', $datas);
    }

    public function list_datatable()
    {
        $datas = [
            'table' => '',
            'meta' => [
                'title' => 'List Datatable'
            ],
            'css' => [],
            'js' => [
                'metronic_v7.1.2/js/pages/custom/user/list-datatable'
            ],
            'breadcrumb' => [
                //...
                array(
                    'title' => 'User',
                    'url' => 'user'
                ),
                array(
                    'title' => 'List Datatable',
                    'url' => 'list-datatable'
                ),
            ],
            'data' => [],
        ];

        return view('admin.custom.apps.user.list_datatable', $datas);
    }
}
