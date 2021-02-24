<?php

return [
    /** reCaptcha */
    // 'secret' => env('NOCAPTCHA_SECRET'),
    // 'sitekey' => env('NOCAPTCHA_SITEKEY'),
    // 'options' => [
    //     'timeout' => 30,
    // ],
    /** Laravel Captcha */
    'default'   => [
        'length'    => 5,
        'width'     => 120,
        'height'    => 36,
        'quality'   => 100,
        'math'      => false, //Enable Math Captcha
        'expire'    => 60,   //Stateless/API captcha expiration
    ],
];
