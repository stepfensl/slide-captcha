<?php

namespace Dact\Admin\SlideCaptcha\Http\Controllers;

use Dact\Admin\SlideCaptcha\SlideCaptchaServiceProvider;
use Dcat\Admin\Admin;
use Dcat\Admin\Http\Controllers\AuthController as BaseAuthController;
use Dcat\Admin\Layout\Content;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class AuthController extends BaseAuthController
{
    protected $view = 'stepfensl.slide-captcha::login';

    /**
     * Show the login page.
     *
     * @return Content|\Illuminate\Http\RedirectResponse
     */
    public function getLogin(Content $content)
    {
        if ($this->guard()->check()) {
            return redirect($this->getRedirectPath());
        }
        Admin::js('vendor/dcat-admin-extensions/stepfensl/slide-captcha/js/tn_code.js');
        Admin::css('vendor/dcat-admin-extensions/stepfensl/slide-captcha/css/style.css');

        return $content->full()->body(Admin::view($this->view));
    }


    /**
     * Handle a login request.
     *
     * @param  Request  $request
     * @return mixed
     */
    public function postLogin(Request $request)
    {
        $credentials = $request->only([$this->username(), 'password']);
        $remember = (bool) $request->input('remember', false);

        /** @var \Illuminate\Validation\Validator $validator */
        $validator = Validator::make($credentials, [
            $this->username()   => 'required',
            'password'          => 'required',
        ]);

        if ($validator->fails()) {
            return $this->validationErrorsResponse($validator);
        }

        if (SlideCaptchaServiceProvider::setting('enbale')) {
            $key = 'admin_captcha_key';
            if (session($key) != 'ok') {
                return $this->response()->error("请验证验证码");
            }
            session()->forget($key, null);
        }

        if ($this->guard()->attempt($credentials, $remember)) {
            return $this->sendLoginResponse($request);
        }

        return $this->validationErrorsResponse([
            $this->username() => $this->getFailedLoginMessage(),
        ]);
    }

    public function captcha()
    {
        $captcha = app('slide_captcha');

        $captcha->build();
        $captcha->imgout(1, 1);
    }

    public function checkCaptcha()
    {
        $captcha = app('slide_captcha');
        $captcha->setDrawLogo();
        if ($captcha->check()) {
            $key = 'admin_captcha_key';
            Session::put($key, 'ok');
            $_SESSION['tncode_check'] = 'ok';
            return "ok";
        } else {
            $_SESSION['tncode_check'] = 'error';
            return "error";
        }
    }
}
