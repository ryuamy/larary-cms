<?php

namespace App\Http\Controllers\Admin\Custom\Apps;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function __construct()
    {
        // $this->middleware('auth:admin');
    }

    public function list_default()
    {
        $datas = [
            "table" => "",
            "meta" => [
                "title" => "List Default"
            ],
            "css" => [],
            "js" => [],
            "breadcrumb" => [
                //...
                array(
                    "title" => "User",
                    "url" => "user"
                ),
                array(
                    "title" => "List Default",
                    "url" => "list-default"
                ),
            ],
            "data" => [],
        ];

        return view("admin.custom.apps.user.list_default", $datas);
    }
}
