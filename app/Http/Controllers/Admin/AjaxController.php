<?php

namespace App\Http\Controllers\Admin;

// use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Admins;
use App\Models\Adminlogs;
use App\Models\Userlogs;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Validator;

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
        $table = $request->input('table');
        $title = $request->input('title');

        $bulk = $request->input('bulk');
        $bulk = rtrim($bulk, ', ');

        $ids = explode(',', $bulk);

        $status = $request->input('status');

        foreach($ids as $id) {
            DB::table($table)->where('id', $id)->update( ['status' => $status] );

            $data_log = new Adminlogs();
            $data_log->admin_id         = Auth::user()->id;
            $data_log->table            = $table;
            $data_log->table_id         = $id;
            if($status == -1) {
                $data_log->action       = 'DELETE';
            } else {
                $data_log->action       = 'UPDATE';
            }
            $data_log->action_detail    = 'Change '.$title.' status with id '.$id.' to '.$status;
            $data_log->ipaddress        = get_client_ip();
            $data_log->save();
        }

        $response = response()->json(
            array(
                'msg'   => 'success',
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
     */
    public function delete_data(Request $request)
    {
        $table = $request->input('table');
        $title = $request->input('title');
        $id = $request->input('id');

        DB::table($table)->where('id', $id)->update([
            'status'        => -1,
            'updated_by'    => Auth::user()->id,
        ]);

        $data_log = new Adminlogs();
        $data_log->admin_id         = Auth::user()->id;
        $data_log->table            = $table;
        $data_log->table_id         = $id;
        $data_log->action           = 'DELETE';
        $data_log->action_detail    = 'Delete '.$title;
        $data_log->ipaddress        = get_client_ip();
        $data_log->save();

        $response = response()->json(
            array(
                'msg'   => 'success',
                'datas' => []
            ), 
            200
        );
        return $response;
    }

    public function login(Request $request)
    {
        $rules = [
            'username'  => 'required|email',
            'password'  => 'required|alpha_num_spaces'
        ];

        $messages = [
            'username.required' => 'Email is required',
            'username.email'    => 'Email format invalid',
            'password.required' => 'Password is required',
            'password.string'   => 'Password only accept alphanumeric and space'
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if($validator->fails()){
            return response()->json(
                array(
                    'response'  => 'failed',
                    'message'   => $validator->errors()->all(),
                    'datas'     => [
                        'errors'    => $validator->errors()->all()
                    ]
                ), 
                400
            );
        } else {
            $check = DB::table('admins')
                ->where('email', $request->username)
                ->first();
            
            $admin_id = ($check) ? $check->id : 0;

            $remember_login = $request->remember != null ? true : false;

            if ( Auth::guard('admin')->attempt(['email' => $request->username, 'password' => $request->password], $remember_login) ) {
                try {
                    if($check->status != 1) {
                        $data_log = new Adminlogs();
                        $data_log->admin_id         = $admin_id;
                        $data_log->table            = 'ADMINS';
                        $data_log->table_id         = $admin_id;
                        $data_log->action           = '';
                        $data_log->action_detail    = 'Failed to login due inactive admin account';
                        $data_log->ipaddress        = get_client_ip();
                        $data_log->save();

                        return response()->json(
                            array(
                                'response'  => 'failed',
                                'message'   => 'Admin not active'
                            ), 
                            400
                        );
                    }

                    $data_log = new Adminlogs();
                    $data_log->admin_id         = $admin_id;
                    $data_log->table            = 'ADMINS';
                    $data_log->table_id         = $admin_id;
                    $data_log->action           = '';
                    $data_log->action_detail    = 'Success login';
                    $data_log->ipaddress        = get_client_ip();
                    $data_log->save();
                    
                    return response()->json(
                        array(
                            'response'  => 'success',
                            'message'   => 'Admin found',
                            'datas'     => [
                                'redirect' => url('/admin/dashboard')
                            ]
                        ), 
                        200
                    );
                } catch (Exception $error) {
                    return response()->json(
                        array(
                            'response'  => 'failed',
                            'message'   => $error->getMessage(),
                            'datas'     => [
                                'exception'    => $error->getMessage()
                            ]
                        ), 
                        500
                    );
                }
            } else {
                $data_log = new Adminlogs();
                $data_log->admin_id         = $admin_id;
                $data_log->table            = 'ADMINS';
                $data_log->table_id         = $admin_id;
                $data_log->action           = '';
                $data_log->action_detail    = 'Attempting to login with incorrect password';
                $data_log->ipaddress        = get_client_ip();
                $data_log->save();

                return response()->json(
                    array(
                        'response'  => 'failed',
                        'message'   => 'Incorrect email or password',
                    ), 
                    400
                );
            }
        }
    }
}
