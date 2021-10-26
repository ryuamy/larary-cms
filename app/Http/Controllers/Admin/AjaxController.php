<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admins;
use App\Models\Pagelogs;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AjaxController extends Controller
{
    /**
     * Change selected data status
     * to active, inactive, etc
     *
     * @param request $request
     * @return \Illuminate\Http\Response
     */
    public function bulk_edit(Request $request)
    {
        $admin_id = Auth::guard('admin')->user()->id;

        $table = $request->input('table');

        $bulk = $request->input('bulk');
        $bulk = rtrim($bulk, ', ');

        $uuids = explode(',', $bulk);

        $status = $request->input('type');

        foreach($uuids as $uuid) {
            $data = DB::table($table)->where('uuid', $uuid)->first();
            $title = $data->name;

            // DB::table($table)->where('uuid', $uuid)->update( ['status' => $status] );

            if($status == 2) {
                DB::table($table)->where('uuid', $uuid)->update([
                    'status' => 2,
                    'updated_by' => $admin_id,
                    'deleted_at' => date('Y-m-d H:i:s'),
                ]);
                $action = 'DELETE';
            } else {
                DB::table($table)->where('uuid', $uuid)->update([
                    'status' => $status,
                    'updated_by' => $admin_id,
                ]);
                $action = 'UPDATE';
            }

            $action_detail = 'Change '.$title.' status with id '.$uuid;

            if($table == 'pages') {
                $data_page_log = new Pagelogs();
                $data_page_log->admin_id = $admin_id;
                $data_page_log->page_id = $data->id;
                $data_page_log->action = $action;
                $data_page_log->action_detail = $action_detail;
                $data_page_log->ipaddress = get_client_ip();
                $data_page_log->save();
            }

            insert_admin_logs(
                $admin_id,
                $table,
                $data->id,
                $action,
                $action_detail
            );
        }

        $response = response()->json(
            array(
                'msg' => 'success',
                'datas' => []
            ),
            200
        );
        return $response;
    }

    /**
     * Delete selected data
     *
     * @param request $request
     * @return \Illuminate\Http\Response
     */
    public function delete_data(Request $request)
    {
        $admin_id = Auth::guard('admin')->user()->id;

        $table = $request->input('table');

        $uuid = $request->input('uuid');

        $data = DB::table($table)->where('uuid', $uuid)->first();
        $title = $data->name;

        DB::table($table)->where('uuid', $uuid)->update([
            'status' => 2,
            'updated_by' => $admin_id,
            'deleted_at' => date('Y-m-d H:i:s'),
        ]);

        $action_detail = 'Delete '.$title.' (uuid '.$uuid.')';

        if($table == 'pages') {
            $data_page_log = new Pagelogs();
            $data_page_log->admin_id = $admin_id;
            $data_page_log->page_id = $data->id;
            $data_page_log->action = 'DELETE';
            $data_page_log->action_detail = $action_detail;
            $data_page_log->ipaddress = get_client_ip();
            $data_page_log->save();
        }

        insert_admin_logs(
            $admin_id,
            $table,
            $data->id,
            'DELETE',
            $action_detail
        );

        $response = response()->json(
            array(
                'msg' => 'success',
                'datas' => []
            ),
            200
        );
        return $response;
    }

    /**
     * Admin login
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function login(Request $request)
    {
        $rules = [
            'username' => 'required|alpha_num',
            'password' => 'required|alpha_num_spaces',
            /** reCaptcha */
            // 'g-recaptcha-response' => 'required|captcha',
            /** Laravel Captcha */
            'captcha' => 'required|captcha'
        ];

        $messages = [
            'username.required' => 'Username is required',
            'username.alpha_num' => 'Username only accept alphanumeric',
            'password.required' => 'Password is required',
            'captcha.string' => 'Password only accept alphanumeric and space',
            /** reCaptcha */
            // 'g-recaptcha-response.captcha' => 'Invalid captcha',
            /** Laravel Captcha */
            'captcha.required' => 'Captcha is required',
            'captcha.captcha' => 'Invalid captcha',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        $check = DB::table('admins')
            ->where('slug', $request->username)
            ->first();
        
        $admin_id = ($check) ? $check->id : 0;

        if($validator->fails()){
            $errors = str_replace( array('[', ']', '"'), '', json_encode($validator->errors()->all()) );

            insert_admin_logs(
                $admin_id,
                'ADMINS',
                $admin_id,
                'LOGIN',
                'Failed to login. Error: '.$errors
            );

            return response()->json(
                array(
                    'response' => 'failed',
                    'message' => 'Failed to login. Error: '.$errors,
                    'datas' => [
                        'errors' => $validator->errors()->all()
                    ]
                ),
                400
            );
        } else {
            $remember_login = $request->remember != null ? true : false;

            $login_attempt = [
                'slug' => $request->username, 
                'password' => $request->password
            ];

            if ( Auth::guard('admin')->attempt($login_attempt, $remember_login) )
            {
                try {
                    if($check->status != 1) {
                        insert_admin_logs(
                            $admin_id,
                            'ADMINS',
                            $admin_id,
                            'LOGIN',
                            'Failed to login due inactive admin account'
                        );

                        return response()->json(
                            array(
                                'response' => 'failed',
                                'message' => 'Admin not active'
                            ),
                            400
                        );
                    }

                    insert_admin_logs(
                        $admin_id,
                        'ADMINS',
                        $admin_id,
                        'LOGIN',
                        'Success login'
                    );

                    return response()->json(
                        array(
                            'response' => 'success',
                            'message' => 'Admin found',
                            'datas' => [
                                'redirect' => url('/admin/dashboard')
                            ]
                        ),
                        200
                    );
                } catch (Exception $error) {
                    insert_admin_logs(
                        $admin_id,
                        'ADMINS',
                        $admin_id,
                        'LOGIN',
                        'Failed to login. Error: '.$error->getMessage()
                    );

                    return response()->json(
                        array(
                            'response' => 'failed',
                            'message' => $error->getMessage(),
                            'datas' => [
                                'exception' => $error->getMessage()
                            ]
                        ),
                        500
                    );
                }
            } else {
                insert_admin_logs(
                    $admin_id,
                    'ADMINS',
                    $admin_id,
                    'LOGIN',
                    'Attempting to login with incorrect password'
                );

                return response()->json(
                    array(
                        'response' => 'failed',
                        'message' => 'Incorrect username or password',
                    ),
                    400
                );
            }
        }
    }

    /**
     * Reload image captcha / non reCaptcha
     *
     * @return \Illuminate\Http\Response
     */
    public function reload_captcha()
    {
        return response()->json(['captcha'=> captcha_img()]);
    }

    /**
     * Delete selected file
     *
     * @return \Illuminate\Http\Response
     */
    public function delete_file(Request $request)
    {
        $table = $request->table;
        $value = $request->value;
        $path = '';
        $file = '';

        if(file_exists($path.'\\'.$file) === false) {
            return response()->json(
                array(
                    'response' => 'failed',
                    'message' => 'File not exist.',
                ),
                400
            );
        }

        if(is_file($path.'\\'.$file) === false) {
            return response()->json(
                array(
                    'response' => 'failed',
                    'message' => 'Invalid file.',
                ),
                400
            );
        }

        unlink($path.'\\'.$file);

        return response()->json(
            array(
                'response' => 'success',
                'message' => 'File deleted.',
            ),
            200
        );
    }

    /**
     * Delete selected file
     *
     * @return \Illuminate\Http\Response
     */
    // public function detail_admin_log($id)
    // {
    //     $limit = 10;

    //     $logs = DB::table('admin_logs')
    //         ->where('admin_id', $id)
    //         // ->offset(0)
    //         // ->limit($limit)
    //         ->get();

    //     $datas = [];

    //     foreach($logs as $log) {
    //         $datas[] = [
    //             'action' => $log->action,
    //             'actionDetail' => $log->action_detail,
    //             'ipAddress' => $log->ipaddress,
    //             'date' => $log->created_at
    //         ];
    //     };

    //     $total = count($logs);


    //     $pages = ceil($total/$limit);

    //     return response()->json(
    //         array(
    //             'meta' => [
    //                 'page' => 1,
    //                 'pages' => $limit,
    //                 'perpage' => $limit,
    //                 'total' => $total,
    //                 'sort' => 'asc',
    //                 'field' => 'date'
    //             ],
    //             'data' => $datas
    //         ),
    //         200
    //     );
    // }

}
