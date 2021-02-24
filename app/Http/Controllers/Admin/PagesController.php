<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pages;
use App\Models\Pagelogs;
use App\Models\Staticdatas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PagesController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:admin');
        $this->table = 'pages';
    }

    public function index()
    {
        $datas = [
            'table' => $this->table,
            'meta' => [
                'title'     => 'CMS Pages',
                'heading'   => 'Pages Management'
            ],
            'css' => [],
            'js' => [
                'js/admin/bulk-edit'
            ],
            'breadcrumb' => [
                array(
                    'title' => 'Pages',
                    'url'   => 'pages'
                ),
            ],
            'staticdata' => [
                'default_status' => Staticdatas::default_status()
            ],
            // 'data' => [],
        ];

        $param_get = isset($_GET) ? $_GET : [];

        $datas_list = Pages::whereRaw('status != -1');
        
        //*** Filter
        if(isset($_GET['action'])) {
            if( $_GET['status'] !== 'all' ) {
                $datas_list = $datas_list->where('status', $_GET['status']);
            }
            if(isset($_GET['created_from']) && isset($_GET['created_to'])) {
                $datas_list = $datas_list
                    ->where('created_at', '>', date('Y-m-d', strtotime($_GET['created_from'])).' 00:00:00')
                    ->where('created_at', '<', date('Y-m-d', strtotime($_GET['created_to'])).' 23:59:59');
            }
        }
        //*** Filter

        //*** Sort
        $order = 'id';
        if(isset($param_get['order'])) {
            $order = $param_get['order'];
            if($param_get['order'] == 'created_date') {
                $order = 'created_at';
            } elseif($param_get['order'] == 'updated_date') {
                $order = 'updated_at';
            }
        }
        $sort = (isset($param_get['sort'])) ? strtoupper($param_get['sort']) : 'DESC';
        $datas_list = $datas_list->orderByRaw($order.' '.$sort);
        //*** Sort
        
        $datas['total'] = count($datas_list->get());

        $limit = custom_pagination_limit();
        $offset = (isset($param_get['page']) && $param_get['page'] > 1) ? ($param_get['page'] * $limit) - $limit : 0;
        $datas['list'] = $datas_list->offset($offset)->limit($limit)->get();

        $base_sort_link = custom_pagination_sort_link('pages', $param_get);
        $datas['pagination']['base_sort_link'] = $base_sort_link;

        $page_link = custom_pagination_link('pages', $param_get);
        $datas['pagination']['page_link'] = $page_link;

        $current_page = isset($param_get['page']) ? (int)$param_get['page'] : 1;
        $pagination_prep = custom_pagination_prep($datas['total'], $current_page);
        $datas['pagination']['showing_from'] = $pagination_prep['showing_from'];
        $datas['pagination']['showing_to'] = $pagination_prep['showing_to'];

        $datas['pagination']['view'] = custom_pagination(
            array(
                'base'          => $page_link,
                'page'          => $pagination_prep['page'],
                'pages'         => $pagination_prep['pages'],
                'key'           => 'page',
                'next_text'     => '&rsaquo;',
                'prev_text'     => '&lsaquo;',
                'first_text'    => '&laquo;',
                'last_text'     => '&raquo;',
                'show_dots'     => TRUE
            )
        );
        
        $table_head = [
            'table'         => $this->table,
            'head'          => [ 'title', 'featured_image', 'status', 'created_date', 'updated_date' ],
            'disabled_head' => [ 'featured_image' ]
        ];
        $table_head = admin_table_head($table_head);
        $datas['table_head'] = $table_head;

        // dd($datas);

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
