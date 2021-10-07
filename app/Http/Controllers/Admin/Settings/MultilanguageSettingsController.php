<?php

namespace App\Http\Controllers\Admin\Settings;

use App\Http\Controllers\Controller;
use App\Models\Admins;
use App\Models\Countries;
use App\Models\Settings;
use App\Models\Settinglogs;
use App\Models\Staticdatas;
use App\Rules\MaxWordsRule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class MultilanguageSettingsController extends Controller
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
        $this->table = 'settings';
        $this->admin_url = admin_uri().$this->table;
    }

    public function detail()
    {
        $datas = [
            'table' => $this->table,
            'admin_url' =>$this->admin_url,
            'meta' => [
                'title' => 'Setup Multilanguage',
                'heading' => 'Multilanguage Settings Management'
            ],
            'css' => [],
            'js' => [
                'admin/set-feature-image',
                'admin/select2',
                'admin/multilanguage-countries'
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
                    'title' => 'Multilanguage Settings',
                    'url' => 'settings/multilanguage-website'
                ),
            ],
            'admindata' => $this->admin,
            'staticdata' => [
                'date_format' => Staticdatas::date_format(),
                'time_format' => Staticdatas::time_format(),
                'module_slug' => 'multilanguage_settings',
            ],
            'settings' => [
                'multilanguage_website' => get_site_settings('multilanguage_website'),
                'permalink_news' => get_site_settings('permalink_news'),
                'permalink_news_category' => get_site_settings('permalink_news_category'),
                'permalink_news_tag' => get_site_settings('permalink_news_tag'),
            ],
            'countries' => Countries::where('deleted_at', null)->where('show_multilanguage', 'Y')->orderBy('name', 'asc')->get(),
        ];

        return view('admin.settings.multilanguage', $datas);
    }

    public function update(Request $request)
    {
        $admin_id = $this->admin->id;

        $current_multilanguage_website_setting = Settings::where('status', 1)->where('meta_key', 'multilanguage_website')
                                ->orderBy('id', 'desc')
                                ->first();

        $current_multilanguage_website_meta_value = $current_multilanguage_website_setting->meta_value;

        if($request->input('multilanguage_website')) {
            Settings::where('meta_key', 'multilanguage_website')->update(
                array(
                    'meta_value' => $request->input('multilanguage_website'),
                    'updated_by' => $admin_id
                )
            );

            $action_detail = 'Update settings multilanguage_website from 0 to 1';
        } else {
            Settings::where('meta_key', 'multilanguage_website')->update(
                array(
                    'meta_value' => 0,
                    'updated_by' => $admin_id
                )
            );
            
            $action_detail = 'Update settings multilanguage_website from 1 to 0';
        }

        $setting_log = new Settinglogs();
        $setting_log->admin_id = $admin_id;
        $setting_log->setting_id = $current_multilanguage_website_setting->id;
        $setting_log->action = 'UPDATE';
        $setting_log->action_detail = $action_detail;
        $setting_log->ipaddress = get_client_ip();
        $setting_log->save();

        insert_admin_logs(
            $admin_id,
            $this->table,
            $current_multilanguage_website_setting->id,
            'UPDATE',
            $action_detail
        );
        
        $enabled_languages = Countries::where('deleted_at', null)->where('show_multilanguage', 'Y');
        if($request->input('multilanguage')) {
            $enabled_languages = $enabled_languages->whereNotIn('iso_alpha_2_code', $request->input('multilanguage'));
        }
        $enabled_languages = $enabled_languages->get();

        foreach($enabled_languages as $disabling) {
            Countries::where('id', $disabling->id)->update(
                array(
                    'enable_multilanguage' => 'N',
                    'updated_by' => $admin_id
                )
            );

            insert_admin_logs(
                $admin_id,
                'countries',
                $disabling->id,
                'UPDATE',
                'Disable multilanguage for county '.$disabling->name
            );
        }

        if($request->input('multilanguage')) {
            $enabling_languages = Countries::where('deleted_at', null)->where('show_multilanguage', 'Y')
                                    ->whereIn('iso_alpha_2_code', $request->input('multilanguage'))
                                    ->get();

            foreach($enabling_languages as $language) {
                Countries::where('id', $language->id)->update(
                    array(
                        'enable_multilanguage' => 'Y',
                        'updated_by' => $admin_id
                    )
                );

                insert_admin_logs(
                    $admin_id,
                    'countries',
                    $language->id,
                    'UPDATE',
                    'Enable multilanguage for county '.$language->name
                );
            }
        }

        return redirect($this->admin_url.'/multilanguage-website/')->with([
            'success-message' => 'Success update multilanguage setting.'
        ]);
    }
}
