<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admins;
use App\Models\Adminlogs;
use App\Models\Categories;
use App\Models\Staticdatas;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

class NewscategoriesController extends Controller
{
    protected $validationRules = [
        'title' => 'required|alpha_num_spaces',
        'status' => 'required',
    ];
    
    protected $validationMessages = [
        'title.required' => 'Title can not be empty.',
        'title.alpha_num_spaces' => 'Title only allowed alphanumeric with spaces.',
        'status.required' => 'Status must be selected.',
    ];

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:admin');
        $this->admin = Auth::guard('admin')->user();
        $this->table = 'categories';
        $this->admin_url = admin_uri().'news/'.$this->table;
    }

    public function index()
    {
        $datas = [
            'table' => $this->table,
            'admin_url' =>$this->admin_url,
            'meta' => [
                'title' => 'CMS News Categories',
                'heading' => 'News Categories Management'
            ],
            'css' => [],
            'js' => [
                'js/admin/bulk-edit',
                'js/admin/filter-data'
            ],
            'breadcrumb' => [
                array(
                    'title' => 'Dashboard',
                    'url' => 'dashboard'
                ),
                array(
                    'title' => 'News',
                    'url' => 'news'
                ),
                array(
                    'title' => 'Categories',
                    'url' => 'news/'.$this->table
                ),
            ],
            'admindata' => Auth::guard('admin')->user(),
            'staticdata' => [
                'default_status' => Staticdatas::default_status()
            ],
        ];

        $param_get = isset($_GET) ? $_GET : [];

        $datas_list = Categories::whereRaw('status != 2')->whereRaw('status != 2');
        
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
            if($param_get['order'] == 'title') {
                $order = 'name';
            }
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
            'head' => [ 'title', 'status', 'created_at', 'updated_at' ],
            'disabled_head' => []
        ];
        $table_head = admin_table_head($table_head);
        $datas['table_head'] = $table_head;

        return view('admin.categories.index', $datas);
    }

    public function create()
    {
        $datas = [
            'table' => $this->table,
            'admin_url' =>$this->admin_url,
            'meta' => [
                'title' => 'Create News Category',
                'heading' => 'News Categories Management'
            ],
            'css' => [],
            'js' => [],
            'breadcrumb' => [
                array(
                    'title' => 'Dashboard',
                    'url' => 'dashboard'
                ),
                array(
                    'title' => 'News',
                    'url' => 'news'
                ),
                array(
                    'title' => 'Category',
                    'url' => 'news/'.$this->table
                ),
                array(
                    'title' => 'Create News Category',
                    'url' => 'news/'.$this->table.'/create'
                ),
            ],
            'admindata' => Auth::guard('admin')->user(),
            'staticdata' => [
                'default_status' => Staticdatas::default_status(),
                'category_tag_type' => Staticdatas::category_tag_type()
            ],
        ];

        return view('admin.categories.form', $datas);
    }

    public function save(Request $request)
    {
        $validation = Validator::make($request->all(), $this->validationRules, $this->validationMessages);
        if ($validation->fails()) {
            $errors = $validation->errors()->all();
            \Session::flash('errors', $errors );
            \Session::flash('request', $request->input() );
            return redirect($this->admin_url.'/create')->with([
                'error-message' => 'There is some errors, please check again'
            ]);
        }

        $admin_id = $this->admin->id;

        $slug = create_slug($this->table, $request->input('title'));

        $insert = new Categories();
        $insert->uuid = (string) Str::uuid();
        $insert->name = $request->input('title');
        $insert->slug = $slug;
        $insert->type = 1;
        $insert->status = $request->input('status');
        $insert->created_by = $admin_id;
        $insert->updated_by = $admin_id;
        $insert->save();

        $new_data = Categories::whereRaw('status != 2')->whereRaw('name = "'.$request->input('title').'"')->orderByRaw('id desc')->first();

        $admin_log = new Adminlogs();
        $admin_log->admin_id = $admin_id;
        $admin_log->table = strtoupper($this->table);
        $admin_log->table_id = $new_data->id;
        $admin_log->action = 'INSERT';
        $admin_log->action_detail = 'Create news categories with title '.$new_data->name;
        $admin_log->ipaddress = get_client_ip();
        $admin_log->save();

        return redirect($this->admin_url.'/detail/'.$new_data['uuid'])->with([
            'success-message' => 'Success add news categories.'
        ]);
    }

    public function detail($uuid)
    {
        $current = Categories::where('uuid', $uuid)->whereRaw('type = 1')->first();

        if(!$current) {
            return redirect($this->admin_url)->with([
                'error-message' => 'Not found'
            ]);
        }

        $datas = [
            'table' => $this->table,
            'admin_url' =>$this->admin_url,
            'meta' => [
                'title' => 'Detail '.$current['name'].' News Category',
                'heading' => 'News Categories Management'
            ],
            'css' => [],
            'js' => [
                'js/admin/edit-permalink'
            ],
            'breadcrumb' => [
                array(
                    'title' => 'Dashboard',
                    'url' => 'dashboard'
                ),
                array(
                    'title' => 'News',
                    'url' => 'news'
                ),
                array(
                    'title' => 'Category',
                    'url' => 'news/'.$this->table
                ),
                array(
                    'title' => 'Detail News Category',
                    'url' => 'news/'.$this->table.'/detail/'.$uuid
                ),
            ],
            'current' => $current,
            'admindata' => Auth::guard('admin')->user(),
            'staticdata' => [
                'default_status' => Staticdatas::default_status(),
                'category_tag_type' => Staticdatas::category_tag_type()
            ],
        ];

        return view('admin.categories.form', $datas);
    }

    public function update($uuid, Request $request)
    {
        $current = Categories::where('uuid', $uuid)->whereRaw('type = 1')->first();

        if(!$current) {
            return redirect($this->admin_url)->with([
                'error-message' => 'Not found'
            ]);
        }

        $this->validationRules['permalink'] = 'required|slug';
        $this->validationMessages['permalink.required'] = 'Permalink can not be empty.';
        $this->validationMessages['permalink.slug'] = 'Permalink only allowed aplhanumeric with dash or underscore.';

        $validation = Validator::make($request->all(), $this->validationRules, $this->validationMessages);
        if ($validation->fails()) {
            $errors = $validation->errors()->all();
            \Session::flash('errors', $errors );
            \Session::flash('request', $request->input() );
            return redirect($this->admin_url.'/detail/'.$uuid)->with([
                'error-message' => 'There is some errors, please check again'
            ]);
        }

        $admin_id = $this->admin->id;

        $slug = ($request->input('permalink') != $current->slug) ? create_slug($this->table, $request->input('permalink')) : $request->input('permalink');

        Categories::where('uuid', $uuid)->update(
            array(
                'name' => $request->input('title'),
                'slug' => $slug,
                'status' => $request->input('status'),
                'updated_by' => $admin_id
            )
        );

        $action_detail = ($current->name != $request->input('title')) ? 
            'Update content and rename title from '.$current->name.' to '.$request->input('title'): 
            'Update news categories '.$current->name;

        $admin_log = new Adminlogs();
        $admin_log->admin_id = $admin_id;
        $admin_log->table = strtoupper($this->table);
        $admin_log->table_id = $current->id;
        $admin_log->action = 'UPDATE';
        $admin_log->action_detail = $action_detail;
        $admin_log->ipaddress = get_client_ip();
        $admin_log->save();

        return redirect($this->admin_url.'/detail/'.$current['uuid'])->with([
            'success-message' => 'Success update news categories.'
        ]);
    }
}
