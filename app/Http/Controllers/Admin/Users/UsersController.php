<?php

namespace App\Http\Controllers\Admin\Users;

use App\Http\Controllers\Controller;
use App\Models\Admins;
use App\Models\Adminroles;
use App\Models\Adminrolemodules;
use App\Models\Staticdatas;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class UsersController extends Controller
{
    protected $validationRules = [
        'name' => 'required|alpha_num_spaces',
        'status' => 'required',
    ];

    protected $validationMessages = [
        'name.required' => 'Title can not be empty.',
        'name.alpha_num_spaces' => 'Title only allowed alphanumeric with spaces.',
        'email.required' => 'Email can not be empty.',
        'email.email' => 'Email format is invalid.',
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
        $this->table = 'users';
        $this->admin_url = admin_uri().$this->table;
    }

    public function index()
    {
        $datas = [
            'table' => $this->table,
            'admin_url' =>$this->admin_url,
            'meta' => [
                'title' => 'CMS Users',
                'heading' => 'Users Management'
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
                    'title' => 'Users',
                    'url' => $this->table
                ),
            ],
            'admindata' => $this->admin,
            'staticdata' => [
                'default_status' => Staticdatas::default_status(),
                'module_slug' => $this->table,
            ],
            'admin_modules' => Adminrolemodules::where('admin_role_id', $this->admin->role_id)->get(),
        ];

        $param_get = isset($_GET) ? $_GET : [];

        $datas_list = User::where('deleted_at', NULL);

        //*** Filter
        if(isset($param_get['action'])) {
            if(isset($param_get['title'])) {
                $name = $param_get['title'];
                if( $param_get['condition'] === 'like' ) {
                    $datas_list = $datas_list->where('name', 'like', '%'.$name.'%');
                }
                if( $param_get['condition'] === 'equal' ) {
                    $datas_list = $datas_list->where('name', $name);
                }
            }
            if( $param_get['status'] !== 'all' ) {
                $datas_list = $datas_list->where('status', $param_get['status']);
            }
            if(isset($param_get['created_from']) && isset($param_get['created_to'])) {
                $datas_list = $datas_list
                    ->where('created_at', '>', date('Y-m-d', strtotime($param_get['created_from'])).' 00:00:00')
                    ->where('created_at', '<', date('Y-m-d', strtotime($param_get['created_to'])).' 23:59:59');
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
            'head' => [ 'name', 'email', 'status', 'created_at', 'updated_at' ],
            'disabled_head' => []
        ];
        $datas['table_head'] = admin_table_head($table_head);
        $datas['table_body_colspan'] = count($table_head['head']);

        return view('admin.users.index', $datas);
    }

    public function create()
    {
        $datas = [
            'table' => $this->table,
            'admin_url' =>$this->admin_url,
            'meta' => [
                'title' => 'Create New User',
                'heading' => 'Users Management'
            ],
            'css' => [],
            'js' => [],
            'breadcrumb' => [
                array(
                    'title' => 'Dashboard',
                    'url' => 'dashboard'
                ),
                array(
                    'title' => 'Users',
                    'url' => $this->table
                ),
                array(
                    'title' => 'Create User',
                    'url' => $this->table.'/create'
                ),
            ],
            'admindata' => $this->admin,
            'staticdata' => [
                'default_status' => Staticdatas::default_status(),
                'module_slug' => $this->table,
            ],
            'admin_modules' => Adminrolemodules::where('admin_role_id', $this->admin->role_id)->get(),
        ];

        return view('admin.users.form', $datas);
    }

    public function save(Request $request)
    {
        $this->validationRules['email'] = 'required|email|unique:users,email';
        $this->validationRules['password'] = 'required|alpha_num_spaces';
        $this->validationRules['repassword'] = 'required|alpha_num_spaces|same:password';

        $this->validationMessages['email.unique'] = 'Email already used or registered.';

        $this->validationMessages['password.required'] = 'Password can not be empty.';
        $this->validationMessages['password.alpha_num_spaces'] = 'Password only accept alphanumeric and space.';

        $this->validationMessages['repassword.required'] = 'Re-password can not be empty.';
        $this->validationMessages['repassword.alpha_num_spaces'] = 'Re-password only accept alphanumeric and space.';
        $this->validationMessages['repassword.same'] = 'Re-password and password not match.';

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

        $insert = new User();
        $insert->uuid = (string) Str::uuid();
        $insert->name = $request->input('name');
        $insert->slug = create_slug($this->table, $request->input('name'));
        $insert->email = $request->input('email');
        $insert->password = Hash::make($request->input('repassword'));
        $insert->status = $request->input('status');
        $insert->created_by = $admin_id;
        $insert->updated_by = $admin_id;
        $insert->save();

        $new_data = User::where('deleted_at', NULL)
            ->whereRaw('name = "'.$request->input('name').'"')
            ->orderByRaw('id desc')
            ->first();

        insert_admin_logs(
            $admin_id,
            $this->table,
            $new_data->id,
            'INSERT',
            'Create new user with name '.$new_data->name
        );

        return redirect($this->admin_url.'/detail/'.$new_data['uuid'])->with([
            'success-message' => 'Success add new user.'
        ]);
    }

    public function detail($uuid)
    {
        $current = User::where('uuid', $uuid)
            ->with(
                array('logs' => function($query) {
                    $query->orderBy('created_at', 'DESC');
                })
            )->first();

        if(!$current) {
            return redirect($this->admin_url)->with([
                'error-message' => 'Not found'
            ]);
        }

        $datas = [
            'table' => $this->table,
            'admin_url' =>$this->admin_url,
            'meta' => [
                'title' => 'Detail '.$current['name'].'',
                'heading' => 'Users Management'
            ],
            'css' => [],
            'js' => [
                'admin/detail-admin-log'
            ],
            'breadcrumb' => [
                array(
                    'title' => 'Dashboard',
                    'url' => 'dashboard'
                ),
                array(
                    'title' => 'Users',
                    'url' => $this->table
                ),
                array(
                    'title' => 'Detail User',
                    'url' => $this->table.'/detail/'.$uuid
                ),
            ],
            'current' => $current,
            'admindata' => $this->admin,
            'staticdata' => [
                'default_status' => Staticdatas::default_status(),
                'module_slug' => $this->table,
            ],
            'admin_modules' => Adminrolemodules::where('admin_role_id', $this->admin->role_id)->get(),
        ];

        return view('admin.users.form', $datas);
    }

    public function update($uuid, Request $request)
    {
        $current = User::where('uuid', $uuid)->first();

        if(!$current) {
            return redirect($this->admin_url)->with([
                'error-message' => 'Not found'
            ]);
        }

        $this->validationRules['email'] = 'required|email|unique:users,email,'.$uuid.',uuid';
        $this->validationMessages['email.unique'] = 'Email already used or registered.';

        if( !empty($request->input('oldpassword')) || !empty($request->input('newpassword')) || !empty($request->input('renewpassword')) ) {
            $this->validationRules['oldpassword'] = 'required|alpha_num_spaces|old_password:'.$uuid.'';
            $this->validationRules['newpassword'] = 'required|alpha_num_spaces|required_with:oldpassword|different:oldpassword';
            $this->validationRules['renewpassword'] = 'required|alpha_num_spaces|required_with:renewpassword|same:newpassword';

            $this->validationMessages['oldpassword.required'] = 'Old Password can not be empty.';
            $this->validationMessages['oldpassword.alpha_num_spaces'] = 'Old Password only accept alphanumeric and space.';
            $this->validationMessages['oldpassword.old_password'] = 'Old Password is not match with current password.';

            $this->validationMessages['newpassword.required'] = 'New password can not be empty.';
            $this->validationMessages['newpassword.alpha_num_spaces'] = 'New password only accept alphanumeric and space.';
            $this->validationMessages['newpassword.required_with'] = 'Please type old password first.';
            $this->validationMessages['newpassword.different'] = 'Please use different password.';

            $this->validationMessages['renewpassword.required'] = 'Please type new password again.';
            $this->validationMessages['renewpassword.alpha_num_spaces'] = 'Please type new password in alphanumeric and space only.';
            $this->validationMessages['renewpassword.required_with'] = 'Please type new password first.';
            $this->validationMessages['renewpassword.same'] = 'Re-password and new password not match.';
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

        User::where('uuid', $uuid)->update(
            array(
                'name' => $request->input('name'),
                'slug' => create_slug($this->table, $request->input('name')),
                'email' => $request->input('email'),
                'status' => $request->input('status'),
                'updated_by' => $admin_id
            )
        );

        $action_detail = ($current->name != $request->input('name')) ?
            'Update user datas and rename name from '.$current->name.' to '.$request->input('name'):
            'Update user '.$current->name;

        insert_admin_logs(
            $admin_id,
            $this->table,
            $current->id,
            'UPDATE',
            $action_detail
        );

        if($request->input('renewpassword')) {
            User::where('uuid', $uuid)->update(
                array(
                    'password' => Hash::make($request->input('renewpassword')),
                    'updated_by' => $admin_id
                )
            );

            insert_admin_logs(
                $admin_id,
                $this->table,
                $current->id,
                'UPDATE',
                'Update password user '.$current->name
            );
        }

        return redirect($this->admin_url.'/detail/'.$current['uuid'])->with([
            'success-message' => 'Success update user.'
        ]);
    }
}
