<?php

namespace App\Http\Controllers\Admin\Settings;

use App\Http\Controllers\Controller;
use App\Models\Adminrolemodules;
use App\Models\Settings;
use App\Models\Settinglogs;
use App\Models\Staticdatas;
use App\Rules\IndonesianAddressRule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class SeoSettingsController extends Controller
{
    protected $validationRules = [
        'description' => 'required|alpha_num_spaces|max:60',
        'search_engine_visibility' => 'nullable|numeric',
    ];

    protected $validationMessages = [
        'description.required' => 'Description can not be empty.',
        'description.alpha_num_spaces' => 'Description only allowed alphanumeric with spaces.',
        'description.max' => 'Description only allowed alphanumeric with spaces.',
        'search_engine_visibility.numeric' => 'Search engine visibility only accept numeric.',
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
                'title' => 'Update SEO Website Settings',
                'heading' => 'SEO Website Settings Management'
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
                    'title' => 'SEO Website Settings',
                    'url' => 'settings/seo'
                ),
            ],
            'admindata' => $this->admin,
            'staticdata' => [
                'module_slug' => 'seo_website_settings',
            ],
            'settings' => [
                'search_engine_visibility' => get_site_settings('search_engine_visibility'),
                'description' => get_site_settings('description'),
                'focus_keyphrase' => get_site_settings('focus_keyphrase'),
                'google_verification_code' => get_site_settings('google_verification_code'),
                'bing_verification_code' => get_site_settings('bing_verification_code'),
            ],
            'admin_modules' => Adminrolemodules::where('admin_id', $this->admin->id)->get(),
        ];

        return view('admin.settings.seo', $datas);
    }

    public function update(Request $request)
    {
        $this->validationRules['focus_keyphrase'] = ['required', new IndonesianAddressRule()];
        $this->validationMessages['focus_keyphrase.required'] = 'Focus keyphrase can not be empty.';
        $this->validationMessages['focus_keyphrase.IndonesianAddressRule'] = 'Focus keyphrase only accept letters, numeric and comma.';

        $this->validationRules['google_verification_code'] = ['nullable', 'required_if:search_engine_visibility,1', new IndonesianAddressRule()];
        $this->validationMessages['google_verification_code.required_if'] = 'Google Verification Code can not be empty.';
        $this->validationMessages['google_verification_code.IndonesianAddressRule'] = 'Google Verification Code only accept letters, numeric, dashes and underscores.';

        $this->validationRules['bing_verification_code'] = ['nullable', 'required_if:search_engine_visibility,1', new IndonesianAddressRule()];
        $this->validationMessages['bing_verification_code.required_if'] = 'Bing Verification Code can not be empty.';
        $this->validationMessages['bing_verification_code.IndonesianAddressRule'] = 'Bing Verification Code only accept letters, numeric, dashes and underscores.';

        $validation = Validator::make($request->all(), $this->validationRules, $this->validationMessages);
        if ($validation->fails()) {
            $errors = $validation->errors()->all();
            Session::flash('errors', $errors );
            Session::flash('request', $request->input() );
            return redirect($this->admin_url.'/seo/')->with([
                'error-message' => 'There is some errors, please check again'
            ]);
        }

        $admin_id = $this->admin->id;

        foreach($request->input() as $key => $input) {
            if($key !== '_token') {
                $current_settings = Settings::where('status', 1)->where('meta_key', $key)->orderBy('id', 'desc')->first();

                $current_meta_value = $current_settings->meta_value;

                $meta_value = !empty($request->input($key)) ? $request->input($key) : '';

                Settings::where('meta_key', $key)->update(
                    array(
                        'meta_value' => $meta_value,
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

        if($request->input('search_engine_visibility') == null) {
            Settings::where('meta_key', 'search_engine_visibility')->update(
                array(
                    'meta_value' => '0',
                    'updated_by' => $admin_id
                )
            );

            $action_detail = ($current_meta_value != $request->input($key)) ?
                'Update settings search_engine_visibility from 1 to 0':
                'Update settings search_engine_visibility';

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

        return redirect($this->admin_url.'/seo/')->with([
            'success-message' => 'Success update SEO website setting.'
        ]);
    }
}
