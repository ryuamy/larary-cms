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

class FileUploadSettingsController extends Controller
{
    protected $validationRules = [
        'organize_uploads' => 'nullable|numeric',
        'crop_image_to_exact_dimensions' => 'nullable|numeric',
        'thumbnail_width' => 'required|numeric|min:100',
        'thumbnail_height' => 'required|numeric|min:100',
        'medium_max_width' => 'required|numeric|min:100',
        'medium_max_height' => 'required|numeric|min:100',
        'large_max_width' => 'required|numeric|min:100',
        'large_max_height' => 'required|numeric|min:100',
    ];

    protected $validationMessages = [
        'organize_uploads.numeric' => 'Organize uploads only accept numeric.',
        'crop_image_to_exact_dimensions.numeric' => 'Crop image to exact dimensions only accept numeric.',
        'thumbnail_width.required' => 'Thumbnail width size can not be empty.',
        'thumbnail_width.numeric' => 'Thumbnail width size only accept numeric.',
        'thumbnail_height.required' => 'Thumbnail height size can not be empty.',
        'thumbnail_height.numeric' => 'Thumbnail height size only accept numeric.',
        'medium_max_width.required' => 'Medium max width size can not be empty.',
        'medium_max_width.numeric' => 'Medium max width size only accept numeric.',
        'medium_max_height.required' => 'Medium max height size can not be empty.',
        'medium_max_height.numeric' => 'Medium max height size only accept numeric.',
        'large_max_width.required' => 'Large max width size can not be empty.',
        'large_max_width.numeric' => 'Large max width size only accept numeric.',
        'large_max_height.required' => 'Large max height size can not be empty.',
        'large_max_height.numeric' => 'Large max height size only accept numeric.',
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
                'title' => 'Update File Upload Settings',
                'heading' => 'File Upload Settings Management'
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
                    'title' => 'File Upload Settings',
                    'url' => 'settings/file-upload'
                ),
            ],
            'admindata' => $this->admin,
            'staticdata' => [],
            'settings' => [
                'organize_uploads' => get_site_settings('organize_uploads'),
                'crop_image_to_exact_dimensions' => get_site_settings('crop_image_to_exact_dimensions'),
                'thumbnail_width' => get_site_settings('thumbnail_width'),
                'thumbnail_height' => get_site_settings('thumbnail_height'),
                'medium_max_width' => get_site_settings('medium_max_width'),
                'medium_max_height' => get_site_settings('medium_max_height'),
                'large_max_width' => get_site_settings('large_max_width'),
                'large_max_height' => get_site_settings('large_max_height'),
            ],
            'admin_modules' => Adminrolemodules::where('admin_id', $this->admin->id)->get(),
        ];

        return view('admin.settings.file_upload', $datas);
    }

    public function update(Request $request)
    {
        $validation = Validator::make($request->all(), $this->validationRules, $this->validationMessages);
        if ($validation->fails()) {
            $errors = $validation->errors()->all();
            Session::flash('errors', $errors );
            Session::flash('request', $request->input() );
            return redirect($this->admin_url.'/file-upload/')->with([
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

        if($request->input('organize_uploads') == null) {
            Settings::where('meta_key', 'organize_uploads')->update(
                array(
                    'meta_value' => '0',
                    'updated_by' => $admin_id
                )
            );

            $action_detail = ($current_meta_value != $request->input($key)) ?
                'Update settings Organize Uploads from 1 to 0':
                'Update settings Organize Uploads';

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

        if($request->input('crop_image_to_exact_dimensions') == null) {
            Settings::where('meta_key', 'crop_image_to_exact_dimensions')->update(
                array(
                    'meta_value' => '0',
                    'updated_by' => $admin_id
                )
            );

            $action_detail = ($current_meta_value != $request->input($key)) ?
                'Update settings Crop Image To Exact Dimensions from 1 to 0':
                'Update settings Crop Image To Exact Dimensions';

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

        return redirect($this->admin_url.'/file-upload/')->with([
            'success-message' => 'Success update file upload setting.'
        ]);
    }
}
