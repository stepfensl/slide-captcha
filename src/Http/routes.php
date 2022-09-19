<?php

use Dact\Admin\SlideCaptcha\Http\Controllers\AuthController;


$auth_controller = AuthController::class;

//滑动验证码验证码
$router->get('auth/login',  $auth_controller . '@getLogin');
$router->post('auth/login',  $auth_controller . '@postLogin');
$router->get('auth/logout',  $auth_controller . '@getLogout');
$router->get('/auth/captcha', $auth_controller . '@captcha');
$router->get('/auth/check_captcha', $auth_controller . '@checkCaptcha');
