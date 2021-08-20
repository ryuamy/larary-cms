<?php

namespace App\Http\Controllers\Admin\Settings;

use App\Http\Controllers\Controller;
// use App\Http\Requests\PagesRequest;
// use App\Models\Admins;
use App\Models\Adminlogs;
// use App\Models\Categories;
// use App\Models\News;
// use App\Models\Newscategories;
// use App\Models\Newslogs;
// use App\Models\Newstags;
// use App\Models\Tags;
use App\Models\Settings;
use App\Models\Settinglogs;
use App\Models\Staticdatas;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class GeneralSettingsController extends Controller
{
    protected $validationRules = [
        'title' => 'required|alpha_num_spaces',
        'tagline' => 'required|alpha_num_spaces',
        'description' => 'required|alpha_num_spaces',
        'admin_pagination_limit' => 'required|numeric',
        'timezone' => 'required',
        'date_format' => 'required',
        'time_format' => 'required',
        // 'start_of_week' => 'required',
    ];

    protected $validationMessages = [
        'title.required' => 'Title can not be empty.',
        'title.alpha_num_spaces' => 'Title only allowed alphanumeric with spaces.',
        'tagline.required' => 'Tagline can not be empty.',
        'description.required' => 'Description can not be empty.',
        'admin_pagination_limit.required' => 'Admin pagination limit can not be empty.',
        'admin_pagination_limit.numeric' => 'Admin pagination limit only accept numeric.',
        'timezone.required' => 'Timezone must be selected.',
        'date_format.required' => 'Date format must be selected.',
        'time_format.required' => 'Time format must be selected.',
        // 'start_of_week.required' => 'Week starts on must be selected.',
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
        $this->table = 'settings';
        $this->admin_url = admin_uri().$this->table;
    }

    public function detail()
    {
        $datas = [
            'table' => $this->table,
            'admin_url' =>$this->admin_url,
            'meta' => [
                'title' => 'Update General Settings',
                'heading' => 'General Settings Management'
            ],
            'css' => [],
            'js' => [
                'admin/set-feature-image',
                'admin/select2',
            ],
            'breadcrumb' => [
                array(
                    'title' => 'Dashboard',
                    'url' => 'dashboard'
                ),
                array(
                    'title' => 'Settings',
                    'url' => 'settings'
                ),
                array(
                    'title' => 'General Settings',
                    'url' => 'settings/general'
                ),
            ],
            'admindata' => $this->admin,
            'staticdata' => [
                'date_format' => Staticdatas::date_format(),
                'time_format' => Staticdatas::time_format()
            ],
            'settings' => [
                'title' => Settings::where('status', 1)->where('meta_key', 'title')->orderBy('id', 'desc')->first()->meta_value,
                'tagline' => get_site_settings('tagline'),
                'description' => get_site_settings('description'),
                'focus_keyphrase' => get_site_settings('focus_keyphrase'),
                'timezone' => get_site_settings('timezone'),
                'date_format' => get_site_settings('date_format'),
                'time_format' => get_site_settings('time_format'),
                'admin_pagination_limit' => get_site_settings('admin_pagination_limit'),
                'language' => get_site_settings('language'),
                'start_of_week' => get_site_settings('start_of_week'),
            ],
            'timezone_choice' => timezone_choice(get_site_settings('timezone')),
        ];

        return view('admin.settings.general', $datas);
    }

    public function update(Request $request)
    {
        $validation = Validator::make($request->all(), $this->validationRules, $this->validationMessages);
        if ($validation->fails()) {
            $errors = $validation->errors()->all();
            Session::flash('errors', $errors );
            Session::flash('request', $request->input() );
            return redirect($this->admin_url.'/general/')->with([
                'error-message' => 'There is some errors, please check again'
            ]);
        }

        $admin_id = $this->admin->id;

        foreach($request->input() as $key => $input) {
            if($key !== '_token') {
                $current_settings = Settings::where('status', 1)->where('meta_key', $key)->orderBy('id', 'desc')->first();

                $current_meta_value = $current_settings->meta_value;

                Settings::where('meta_key', $key)->update(
                    array(
                        'meta_value' => $request->input($key),
                        'updated_by' => $admin_id
                    )
                );

                $action_detail = ($current_meta_value != $request->input($key)) ?
                    'Update settings '.$key.' from '.$current_meta_value.' to '.$request->input($key):
                    'Update settings '.$key;

                $setting_log = new Settinglogs();
                $setting_log->admin_id = $admin_id;
                $setting_log->setting_id = $current_settings->id;
                $setting_log->action = 'UPDATE';
                $setting_log->action_detail = $action_detail;
                $setting_log->ipaddress = get_client_ip();
                $setting_log->save();

                $admin_log = new Adminlogs();
                $admin_log->admin_id = $admin_id;
                $admin_log->table = strtoupper($this->table);
                $admin_log->table_id = $current_settings->id;
                $admin_log->action = 'UPDATE';
                $admin_log->action_detail = $action_detail;
                $admin_log->ipaddress = get_client_ip();
                $admin_log->save();
            }
        }

        return redirect($this->admin_url.'/general/')->with([
            'success-message' => 'Success update general setting.'
        ]);
    }
}
