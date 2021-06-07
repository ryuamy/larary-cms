<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
// use App\Http\Requests\PagesRequest;
use App\Models\Admins;
use App\Models\Adminlogs;
use App\Models\Categories;
use App\Models\News;
use App\Models\Newscategories;
use App\Models\Newslogs;
use App\Models\Newstags;
use App\Models\Tags;
use App\Models\Staticdatas;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class NewsController extends Controller
{
    protected $validationRules = [
        'title' => 'required|alpha_num_spaces',
        'content' => 'required',
        'status' => 'required',
    ];

    protected $validationMessages = [
        'title.required' => 'Title can not be empty.',
        'title.alpha_num_spaces' => 'Title only allowed alphanumeric with spaces.',
        'content.required' => 'Content can not be empty.',
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
        $this->table = 'news';
        $this->admin_url = admin_uri().$this->table;
    }

    public function index()
    {
        $datas = [
            'table' => $this->table,
            'admin_url' =>$this->admin_url,
            'meta' => [
                'title' => 'CMS News',
                'heading' => 'News Management'
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
                    'title' => 'News',
                    'url' => $this->table
                ),
            ],
            'admindata' => $this->admin,
            'staticdata' => [
                'default_status' => Staticdatas::default_status()
            ],
        ];

        $param_get = isset($_GET) ? $_GET : [];

        $datas_list = News::whereRaw('status != 2');

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
            'head' => [ 'title', 'featured_image', 'status', 'created_at', 'updated_at' ],
            'disabled_head' => [ 'featured_image' ]
        ];
        $datas['table_head'] = admin_table_head($table_head);
        $datas['table_body_colspan'] = count($table_head['head']);

        return view('admin.news.index', $datas);
    }

    public function create()
    {
        $datas = [
            'table' => $this->table,
            'admin_url' =>$this->admin_url,
            'meta' => [
                'title' => 'Create News',
                'heading' => 'News Management'
            ],
            'css' => [],
            'js' => [
                'admin/set-feature-image',
                'admin/wysiwyg-editor',
            ],
            'breadcrumb' => [
                array(
                    'title' => 'Dashboard',
                    'url' => 'dashboard'
                ),
                array(
                    'title' => 'News',
                    'url' => $this->table
                ),
                array(
                    'title' => 'Create News',
                    'url' => $this->table.'/create'
                ),
            ],
            'admindata' => $this->admin,
            'staticdata' => [
                'default_status' => Staticdatas::default_status(),
                'category_tag_type' => Staticdatas::category_tag_type()
            ],
            'categories' => Categories::whereRaw('status != 2')->get(),
            'tags' => Tags::whereRaw('status != 2')->get(),
        ];

        return view('admin.news.form', $datas);
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

        $path_featured_image = create_uploads_folder();

        $image_new_name = '';
        $featured = $request->file('featured');
        //http://image.intervention.io/api/crop
        if(!empty($featured)) {
            $image_mime_type = $featured->getMimeType();
            $image_extention = $featured->getClientOriginalExtension();
            $image_size = $featured->getSize();

            $image_new_name = uniqid().'.'.$image_extention;

            $featured->move($path_featured_image, $image_new_name);
        }

        $slug = create_slug($this->table, $request->input('title'));

        $insert = new News();
        $insert->uuid = (string) Str::uuid();
        $insert->name = $request->input('title');
        $insert->slug = $slug;
        $insert->featured_image = $path_featured_image.'/'.$image_new_name;
        $insert->content = $request->input('content');
        $insert->status = $request->input('status');
        $insert->created_by = $admin_id;
        $insert->updated_by = $admin_id;
        $insert->save();

        $new_data = News::whereRaw('status != 2')->whereRaw('name = "'.$request->input('title').'"')->orderByRaw('id desc')->first();

        if(!empty($request->input('tags'))) {
            foreach($request->input('tags') as $tags) {
                $tag_data = Tags::whereRaw('status != 2')->whereRaw('name = "'.$tags['value'].'"')->first();

                $data_tag = new Newstags();
                $data_tag->tag_id = $tag_data->id;
                $data_tag->news_id = $new_data->id;
                $data_tag->status = 1;
                $data_tag->created_by = $admin_id;
                $data_tag->updated_by = $admin_id;
                $data_tag->save();

                $data_log_tags = new Newslogs();
                $data_log_tags->admin_id = $admin_id;
                $data_log_tags->news_id = $new_data->id;
                $data_log_tags->action = 'INSERT';
                $data_log_tags->action_detail = 'Add news tags';
                $data_log_tags->ipaddress = get_client_ip();
                $data_log_tags->save();
            }
        }

        if(!empty($request->input('categories'))) {
            foreach($request->input('categories') as $categories) {
                $category_data = Categories::whereRaw('status != 2')->whereRaw('name = "'.$categories['value'].'"')->first();

                $data_category = new Newscategories();
                $data_category->category_id = $category_data->id;
                $data_category->news_id = $new_data->id;
                $data_category->status = 1;
                $data_category->created_by = $admin_id;
                $data_category->updated_by = $admin_id;
                $data_category->save();

                $data_log_categories = new Newslogs();
                $data_log_categories->admin_id = $admin_id;
                $data_log_categories->news_id = $new_data->id;
                $data_log_categories->action = 'INSERT';
                $data_log_categories->action_detail = 'Add categories of news';
                $data_log_categories->ipaddress = get_client_ip();
                $data_log_categories->save();
            }
        }

        $data_log = new Newslogs();
        $data_log->admin_id = $admin_id;
        $data_log->news_id = $new_data->id;
        $data_log->action = 'INSERT';
        $data_log->action_detail = 'Created news';
        $data_log->ipaddress = get_client_ip();
        $data_log->save();

        $admin_log = new Adminlogs();
        $admin_log->admin_id = $admin_id;
        $admin_log->table = strtoupper($this->table);
        $admin_log->table_id = $new_data->id;
        $admin_log->action = 'INSERT';
        $admin_log->action_detail = 'Create news with title '.$new_data->name;
        $admin_log->ipaddress = get_client_ip();
        $admin_log->save();

        return redirect($this->admin_url.'/detail/'.$new_data['uuid'])->with([
            'success-message' => 'Success add news.'
        ]);
    }

    public function detail($uuid)
    {
        $current = News::where('uuid', $uuid)->first();

        if(!$current) {
            return redirect($this->admin_url)->with([
                'error-message' => 'Not found'
            ]);
        }

        $datas = [
            'table' => $this->table,
            'admin_url' =>$this->admin_url,
            'meta' => [
                'title' => 'Detail '.$current['name'].' NSews',
                'heading' => 'News Management'
            ],
            'css' => [],
            'js' => [
                'admin/edit-permalink',
                'admin/set-feature-image',
                'admin/wysiwyg-editor'
            ],
            'breadcrumb' => [
                array(
                    'title' => 'Dashboard',
                    'url' => 'dashboard'
                ),
                array(
                    'title' => 'News',
                    'url' => $this->table
                ),
                array(
                    'title' => 'Detail News',
                    'url' => $this->table.'/detail/'.$uuid
                ),
            ],
            'current' => $current,
            'admindata' => $this->admin,
            'staticdata' => [
                'default_status' => Staticdatas::default_status()
            ],
        ];

        return view('admin.news.form', $datas);
    }

    public function update($uuid, Request $request)
    {
        $current = News::where('uuid', $uuid)->first();

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
            Session::flash('errors', $errors );
            Session::flash('request', $request->input() );
            return redirect($this->admin_url.'/detail/'.$uuid)->with([
                'error-message' => 'There is some errors, please check again'
            ]);
        }

        $admin_id = $this->admin->id;

        $path_featured_image = create_uploads_folder();

        $featured_image = $current->featured_image;
        $featured = $request->file('featured');
        if(!empty($featured)) {
            $image_mime_type = $featured->getMimeType();
            $image_extention = $featured->getClientOriginalExtension();
            $image_size = $featured->getSize();

            $image_new_name = uniqid().'.'.$image_extention;

            $featured->move($path_featured_image, $image_new_name);

            $featured_image = $path_featured_image.'/'.$image_new_name;
        }

        $slug = ($request->input('permalink') != $current->slug) ? create_slug($this->table, $request->input('permalink')) : $request->input('permalink');

        News::where('uuid', $uuid)->update(
            array(
                'name' => $request->input('title'),
                'slug' => $slug,
                'featured_image' => $featured_image,
                'content' => $request->input('content'),
                'status' => $request->input('status'),
                'updated_by' => $admin_id
            )
        );

        if(!empty($request->input('tags'))) {
            Newstags::where('news_id', $current->id)->delete();

            $data_log = new Newslogs();
            $data_log->admin_id = $admin_id;
            $data_log->news_id = $current->id;
            $data_log->action = 'DELETE';
            $data_log->action_detail = 'Delete previous news tags';
            $data_log->ipaddress = get_client_ip();
            $data_log->save();

            foreach($request->input('tags') as $tags) {
                $tag_data = Tags::whereRaw('status != 2')->whereRaw('name = "'.$tags['value'].'"')->first();

                $data_tag = new Newstags();
                $data_tag->tag_id = $tag_data->id;
                $data_tag->news_id = $current->id;
                $data_tag->status = 1;
                $data_tag->created_by = $admin_id;
                $data_tag->updated_by = $admin_id;
                $data_tag->save();

                $data_log = new Newslogs();
                $data_log->admin_id = $admin_id;
                $data_log->news_id = $current->id;
                $data_log->action = 'UPDATE';
                $data_log->action_detail = 'Update news tags';
                $data_log->ipaddress = get_client_ip();
                $data_log->save();
            }
        }

        if(!empty($request->input('categories'))) {
            Newscategories::where('news_id', $current->id)->delete();

            $data_log = new Newslogs();
            $data_log->admin_id = $admin_id;
            $data_log->news_id = $current->id;
            $data_log->action = 'DELETE';
            $data_log->action_detail = 'Delete previous categories of news';
            $data_log->ipaddress = get_client_ip();
            $data_log->save();

            foreach($request->input('categories') as $categories) {
                $category_data = Categories::whereRaw('status != 2')->whereRaw('name = "'.$categories['value'].'"')->first();

                $data_category = new Newscategories();
                $data_category->category_id = $category_data->id;
                $data_category->news_id = $current->id;
                $data_category->status = 1;
                $data_category->created_by = $admin_id;
                $data_category->updated_by = $admin_id;
                $data_category->save();

                $data_log = new Newslogs();
                $data_log->admin_id = $admin_id;
                $data_log->news_id = $current->id;
                $data_log->action = 'UPDATE';
                $data_log->action_detail = 'Update categories of news';
                $data_log->ipaddress = get_client_ip();
                $data_log->save();
            }
        }

        $action_detail = ($current->name != $request->input('title')) ?
            'Update content and rename title from '.$current->name.' to '.$request->input('title'):
            'Update news '.$current->name;

        $data_log = new Newslogs();
        $data_log->admin_id = $admin_id;
        $data_log->news_id = $current->id;
        $data_log->action = 'UPDATE';
        $data_log->action_detail = $action_detail;
        $data_log->ipaddress = get_client_ip();
        $data_log->save();

        $admin_log = new Adminlogs();
        $admin_log->admin_id = $admin_id;
        $admin_log->table = strtoupper($this->table);
        $admin_log->table_id = $current->id;
        $admin_log->action = 'UPDATE';
        $admin_log->action_detail = $action_detail;
        $admin_log->ipaddress = get_client_ip();
        $admin_log->save();

        return redirect($this->admin_url.'/detail/'.$current['uuid'])->with([
            'success-message' => 'Success update news.'
        ]);
    }
}
