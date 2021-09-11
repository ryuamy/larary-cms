<?php

namespace App\Http\Controllers\Admin\Settings;

use App\Http\Controllers\Controller;
use App\Models\Adminrolemodules;
use App\Models\Settings;
use App\Models\Settinglogs;
use App\Models\Staticdatas;
use App\Rules\MaxWordsRule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class GeneralSettingsController extends Controller
{
    protected $validationRules = [
        'title' => 'required|alpha_num_spaces',
        'admin_pagination_limit' => 'required|numeric',
        'timezone' => 'required',
        'date_format' => 'required',
        'time_format' => 'required',
        // 'start_of_week' => 'required',
    ];

    protected $validationMessages = [
        'title.required' => 'Title can not be empty.',
        'title.alpha_num_spaces' => 'Title only allowed alphanumeric with spaces.',
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
                'time_format' => Staticdatas::time_format(),
                'module_slug' => 'general_settings',
            ],
            'settings' => [
                'title' => get_site_settings('title'),
                'tagline' => get_site_settings('tagline'),
                'separator' => get_site_settings('separator'),
                'focus_keyphrase' => get_site_settings('focus_keyphrase'),
                'timezone' => get_site_settings('timezone'),
                'date_format' => get_site_settings('date_format'),
                'time_format' => get_site_settings('time_format'),
                'admin_pagination_limit' => get_site_settings('admin_pagination_limit'),
                'language' => get_site_settings('language'),
                'start_of_week' => get_site_settings('start_of_week'),
            ],
            'timezone_choice' => timezone_choice(get_site_settings('timezone')),
            'admin_modules' => Adminrolemodules::where('admin_id', $this->admin->id)->get(),
        ];

        return view('admin.settings.general', $datas);
    }

    public function update(Request $request)
    {
        $this->validationRules['tagline'] = ['required', 'alpha_num_spaces', new MaxWordsRule(7)];
        $this->validationMessages['tagline.required'] = 'Tagline can not be empty.';
        $this->validationMessages['tagline.alpha_num_spaces'] = 'Tagline only allowed letters, numbers, and space.';
        $this->validationMessages['tagline.MaxWordsRule'] = 'Tagline cannot be longer than 7 words.';

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

                insert_admin_logs(
                    $admin_id,
                    $this->table,
                    $current_settings->id,
                    'UPDATE',
                    $action_detail
                );
            }
        }

        return redirect($this->admin_url.'/general/')->with([
            'success-message' => 'Success update general setting.'
        ]);
    }
}
