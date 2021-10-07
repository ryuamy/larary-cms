<?php

namespace App\Http\Controllers\Admin\Users;

use App\Http\Controllers\Controller;
use App\Models\Admins;
use App\Models\Adminroles;
use App\Models\Adminrolemodules;
use App\Models\Modules;
use App\Models\Staticdatas;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class AdminrolesController extends Controller
{
    protected $validationRules = [
        'name' => 'required|alpha_num_spaces',
        'status' => 'required',
    ];

    protected $validationMessages = [
        'name.required' => 'Name can not be empty.',
        'name.alpha_num_spaces' => 'Name only allowed alphanumeric with spaces.',
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
        if(Auth::guard('admin')->user() != null) {
            $admin_id = Auth::guard('admin')->user()->id;
            $this->admin = Admins::where('id', $admin_id)->with('role')->first();
        }
        $this->table = 'admin_roles';
        $this->admin_url = admin_uri().'admin-roles';
    }

    public function index()
    {
        $datas = [
            'table' => $this->table,
            'admin_url' =>$this->admin_url,
            'meta' => [
                'title' => 'CMS Admin Roles',
                'heading' => 'Admin Roles Management'
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
                    'title' => 'Admin Roles',
                    'url' => str_replace('_', '-', $this->table)
                ),
            ],
            'admindata' => $this->admin,
            'staticdata' => [
                'default_status' => Staticdatas::default_status(),
                'module_slug' => 'admin_roles',
            ],
            'admin_roles' => Adminroles::where('deleted_at', NULL)->get()
        ];

        $param_get = isset($_GET) ? $_GET : [];

        $datas_list = Adminroles::where('deleted_at', NULL);

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

        $base_sort_link = custom_sort_link(str_replace('_', '-', $this->table), $param_get);
        $datas['pagination']['base_sort_link'] = $base_sort_link;

        $page_link = custom_pagination_link(str_replace('_', '-', $this->table), $param_get);
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
            'head' => [ 'name', 'status', 'created_at', 'updated_at' ],
            'disabled_head' => []
        ];
        $datas['table_head'] = admin_table_head($table_head);
        $datas['table_body_colspan'] = count($table_head['head']);

        return view('admin.admin_roles.index', $datas);
    }

    public function create()
    {
        $datas = [
            'table' => $this->table,
            'admin_url' =>$this->admin_url,
            'meta' => [
                'title' => 'Create New Admin Role',
                'heading' => 'Admin Roles Management'
            ],
            'css' => [],
            'js' => [
                'admin/admin-role-module',
            ],
            'breadcrumb' => [
                array(
                    'title' => 'Dashboard',
                    'url' => 'dashboard'
                ),
                array(
                    'title' => 'Admin Roles',
                    'url' => str_replace('_', '-', $this->table)
                ),
                array(
                    'title' => 'Create Admin Role',
                    'url' => str_replace('_', '-', $this->table).'/create'
                ),
            ],
            // 'current' => [],
            'admindata' => $this->admin,
            'staticdata' => [
                'default_status' => Staticdatas::default_status(),
                'module_slug' => 'admin_roles',
            ],
            'admin_roles' => Adminroles::where('deleted_at', NULL)->get(),
            'modules' => Modules::where('deleted_at', NULL)->get(),
        ];

        return view('admin.admin_roles.form', $datas);
    }

    public function save(Request $request)
    {
        $validation = Validator::make($request->all(), $this->validationRules, $this->validationMessages);
        if ($validation->fails()) {
            $errors = $validation->errors()->all();
            Session::flash('errors', $errors );
            Session::flash('request', $request->input() );
            return redirect($this->admin_url.'/create')->with([
                'error-message' => 'There is some errors, please check again'
            ]);
        }

        $admin_id = $this->admin->id;

        $slug = create_slug($this->table, $request->input('title'));

        $insert = new Adminroles();
        $insert->uuid = (string) Str::uuid();
        $insert->name = $request->input('name');
        // $insert->slug = $slug;
        $insert->status = $request->input('status');
        $insert->created_by = $admin_id;
        $insert->updated_by = $admin_id;
        $insert->save();

        $new_data = Adminroles::where('deleted_at', NULL)
            ->whereRaw('name = "'.$request->input('name').'"')
            ->orderByRaw('id desc')
            ->first();

        insert_admin_logs(
            $admin_id,
            $this->table,
            $new_data->id,
            'INSERT',
            'Create new admin role with name '.$new_data->name
        );

        if(!empty($request->input('modules'))) {
            foreach($request->input('modules') as $module) {
                foreach($module['rules'] as $rules) {
                    $admin_role_module = new Adminrolemodules();
                    $admin_role_module->admin_id = $admin_id;
                    $admin_role_module->admin_role_id = $new_data->id;
                    $admin_role_module->module_id = $module['module_id'];
                    $admin_role_module->module_slug = $module['name'];
                    $admin_role_module->rules = $rules;
                    $admin_role_module->created_by = $admin_id;
                    $admin_role_module->save();
                }
            }

            insert_admin_logs(
                $admin_id,
                $this->table,
                $this->admin->role_id,
                'UPDATE',
                'Update admin role modules'
            );
        }

        return redirect($this->admin_url.'/detail/'.$new_data['uuid'])->with([
            'success-message' => 'Success add new admin role.'
        ]);
    }

    public function detail($uuid)
    {
        $current = Adminroles::where('uuid', $uuid)->first();

        if(!$current) {
            return redirect($this->admin_url)->with([
                'error-message' => 'Not found'
            ]);
        }

        $datas = [
            'table' => $this->table,
            'admin_url' =>$this->admin_url,
            'meta' => [
                'title' => 'Detail '.$current['name'].' Role',
                'heading' => 'Admin Roles Management'
            ],
            'css' => [],
            'js' => [
                'admin/edit-permalink',
                'admin/admin-role-module',
            ],
            'breadcrumb' => [
                array(
                    'title' => 'Dashboard',
                    'url' => 'dashboard'
                ),
                array(
                    'title' => 'Admin Roles',
                    'url' => str_replace('_', '-', $this->table)
                ),
                array(
                    'title' => 'Detail Admin Role',
                    'url' => str_replace('_', '-', $this->table).'/detail/'.$uuid
                ),
            ],
            'current' => $current,
            'admindata' => $this->admin,
            'staticdata' => [
                'default_status' => Staticdatas::default_status(),
                'module_slug' => 'admin_roles',
            ],
            'admin_roles' => Adminroles::where('deleted_at', NULL)->orderBy('name')->get(),
            'modules' => Modules::where('deleted_at', NULL)->get(),
            'admin_modules' => Adminrolemodules::where('admin_id', $this->admin->id)->get(),
        ];

        return view('admin.admin_roles.form', $datas);
    }

    public function update($uuid, Request $request)
    {
        $current = Adminroles::where('uuid', $uuid)->first();

        if(!$current) {
            return redirect($this->admin_url)->with([
                'error-message' => 'Not found'
            ]);
        }

        $validation = Validator::make($request->all(), $this->validationRules, $this->validationMessages);
        if ($validation->fails()) {
            $errors = $validation->errors()->all();
            Session::flash('errors', $errors );
            Session::flash('request', $request->input() );
            return redirect($this->admin_url.'/detail/'.$uuid)->with([
                'error-message' => 'There is some errors, please check again'
            ]);
        }

        $admin_id = $this->admin->id;

        $slug = ($request->input('permalink') != $current->slug) ? create_slug($this->table, $request->input('permalink')) : $request->input('permalink');

        Adminroles::where('uuid', $uuid)->update(
            array(
                'name' => $request->input('name'),
                'slug' => $slug,
                'status' => $request->input('status'),
                'updated_by' => $admin_id
            )
        );

        $action_detail = ($current->name != $request->input('name')) ?
            'Update datas and rename name from '.$current->name.' to '.$request->input('name'):
            'Update admin role '.$current->name;

        insert_admin_logs(
            $admin_id,
            $this->table,
            $current->id,
            'UPDATE',
            $action_detail
        );

        if(!empty($request->input('modules'))) {
            $check_admin_role_module = Adminrolemodules::where('admin_role_id', $current->id)->get();

            if(!empty($check_admin_role_module)) {
                Adminrolemodules::where('admin_role_id', $current->id)->delete();
            }

            insert_admin_logs(
                $admin_id,
                $this->table,
                $current->id,
                'DELETE',
                'Delete previous admin role modules'
            );

            foreach($request->input('modules') as $module) {
                if(isset($module['rules'])) {
                    foreach($module['rules'] as $rules) {
                        $admin_role_module = new Adminrolemodules();
                        $admin_role_module->admin_role_id = $current->id;
                        $admin_role_module->module_id = $module['module_id'];
                        $admin_role_module->module_slug = $module['name'];
                        $admin_role_module->rules = $rules;
                        $admin_role_module->created_by = $admin_id;
                        $admin_role_module->save();
                    }
                }
            }

            insert_admin_logs(
                $admin_id,
                $this->table,
                $this->admin->role_id,
                'UPDATE',
                'Update admin role modules'
            );
        }

        return redirect($this->admin_url.'/detail/'.$current['uuid'])->with([
            'success-message' => 'Success update admin.'
        ]);
    }
}
