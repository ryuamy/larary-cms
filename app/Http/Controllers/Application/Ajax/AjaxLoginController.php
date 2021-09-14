<?php

namespace App\Http\Controllers\Application\Ajax;

use App\Http\Controllers\Controller;
use App\Models\Users;
use App\Models\Userlogs;
use App\Models\Pagelogs;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AjaxLoginController extends Controller
{
    /**
     * User login
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function login(Request $request)
    {
        $rules = [
            'email' => 'required|email',
            'password' => 'required|alpha_num_spaces',
            /** reCaptcha */
            // 'g-recaptcha-response' => 'required|captcha',
            /** Laravel Captcha */
            'captcha' => 'required|captcha'
        ];

        $messages = [
            'email.required' => 'Email is required',
            'email.email' => 'Email format is invalid',
            'password.required' => 'Password is required',
            'captcha.string' => 'Password only accept alphanumeric and space',
            /** reCaptcha */
            // 'g-recaptcha-response.captcha' => 'Invalid captcha',
            /** Laravel Captcha */
            'captcha.required' => 'Captcha is required',
            'captcha.captcha' => 'Invalid captcha',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if($validator->fails()){
            $errors = str_replace( array('[', ']', '"'), '', json_encode($validator->errors()->all()) );

            insert_user_logs(
                0,
                'USERS',
                0,
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
            $check = DB::table('users')
                ->where('email', $request->email)
                ->first();

            $user_id = ($check) ? $check->id : 0;

            $remember_login = $request->remember != null ? true : false;

            if ( Auth::attempt(['email' => $request->email, 'password' => $request->password], $remember_login) ) {
                try {
                    if($check->status != 1) {
                        insert_user_logs(
                            $user_id,
                            'USERS',
                            $user_id,
                            'LOGIN',
                            'Failed to login due inactive user account'
                        );

                        return response()->json(
                            array(
                                'response' => 'failed',
                                'message' => 'User not active'
                            ),
                            400
                        );
                    }

                    insert_user_logs(
                        $user_id,
                        'USERS',
                        $user_id,
                        'LOGIN',
                        'Success login'
                    );

                    return response()->json(
                        array(
                            'response' => 'success',
                            'message' => 'User found',
                            'datas' => [
                                'redirect' => url('/home')
                            ]
                        ),
                        200
                    );
                } catch (Exception $error) {
                    insert_user_logs(
                        $user_id,
                        'USERS',
                        $user_id,
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
                insert_user_logs(
                    $user_id,
                    'USERS',
                    $user_id,
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

}
