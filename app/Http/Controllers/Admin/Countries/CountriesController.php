<?php

namespace App\Http\Controllers\Admin\Countries;

use App\Http\Controllers\Controller;
use App\Models\Admins;
use App\Models\Adminrolemodules;
use App\Models\Countries;
use App\Models\Staticdatas;
use Illuminate\Support\Facades\Auth;

class CountriesController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:admin');
        if(Auth::guard('admin')->user() != null) {
            $admin_id = Auth::guard('admin')->user()->id;
            $this->admin = Admins::where('id', $admin_id)->with('role')->first();
        }
        $this->table = 'countries';
        $this->admin_url = admin_uri().$this->table;
    }

    public function index()
    {
        $datas = [
            'table' => $this->table,
            'admin_url' =>$this->admin_url,
            'meta' => [
                'title' => 'CMS Countries',
                'heading' => 'Countries Management'
            ],
            'css' => [],
            'js' => [
                'admin/bulk-edit',
                'admin/filter-data'
            ],
            'breadcrumb' => [
                array(
                    'title' => 'Dashboard',
                    'url' => 'dashboard'
                ),
                array(
                    'title' => 'Countries',
                    'url' => $this->table
                ),
                array(
                    'title' => 'Countries',
                    'url' => $this->table
                ),
            ],
            'admindata' => $this->admin,
            'staticdata' => [
                'default_status' => Staticdatas::default_status()
            ],
            'admin_modules' => Adminrolemodules::where('admin_role_id', $this->admin->role_id)->get(),
        ];

        $param_get = isset($_GET) ? $_GET : [];

        $datas_list = custom_admin_sort_filter('countries', $param_get);
        
        $datas['total'] = $datas_list['total'];
        $datas['list'] = json_decode(json_encode($datas_list['datas_list']), true);

        $base_sort_link = custom_sort_link($this->table, $param_get);
        $datas['pagination']['base_sort_link'] = $base_sort_link;

        $page_link = custom_pagination_link($this->table, $param_get);
        $datas['pagination']['page_link'] = $page_link;

        $current_page = isset($param_get['page']) ? (int)$param_get['page'] : 1;
        $pagination_prep = custom_pagination_prep($datas['total'], $current_page);
        $datas['pagination']['showing_from'] = $pagination_prep['showing_from'];
        $datas['pagination']['showing_to'] = $pagination_prep['showing_to'];

        $datas['pagination']['view'] = custom_pagination(
            array(
                'base' => $page_link,
                'page' => $pagination_prep['page'],
                'pages' => $pagination_prep['pages'],
                'key' => 'page',
                'next_text' => '&rsaquo;',
                'prev_text' => '&lsaquo;',
                'first_text' => '&laquo;',
                'last_text' => '&raquo;',
                'show_dots' => TRUE
            )
        );

        $table_head = [
            'table' => $this->table,
            'head' => [ 'name', 'iso_alpha_2_code', 'iso_alpha_3_code', 'un_code', 'phone_code', 'flag', 'capital_city', 'status', 'created_at', 'updated_at' ],
            'disabled_head' => [ 'flag' ]
        ];
        $datas['table_head'] = admin_table_head($table_head);
        $datas['table_body_colspan'] = count($table_head['head']);

        return view('admin.countries.index', $datas);
    }
}
