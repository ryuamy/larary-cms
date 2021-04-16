<?php

namespace App\Http\Controllers\Admin\Custom\Apps;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function list_default()
    {
        $datas = [
            'table' => '',
            'meta' => [
                'title' => 'List Default'
            ],
            'css' => [],
            'js' => [],
            'breadcrumb' => [
                //...
                array(
                    'title' => 'User',
                    'url' => 'user'
                ),
                array(
                    'title' => 'List Default',
                    'url' => 'list-default'
                ),
            ],
            'data' => [],
        ];

        return view('admin.custom.apps.user.list_default', $datas);
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
                'metronic_v7.1.2/pages/custom/user/list-datatable'
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
