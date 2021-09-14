<?php

namespace App\Http\Controllers\Application\Ajax;

use App\Http\Controllers\Controller;

class AjaxCaptchaController extends Controller
{
    /**
     * Reload image captcha / non reCaptcha
     *
     * @return \Illuminate\Http\Response
     */
    public function reload_captcha()
    {
        return response()->json(['captcha'=> captcha_img()]);
    }

}
