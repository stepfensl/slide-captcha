<?php

namespace Dact\Admin\SlideCaptcha;

use Dcat\Admin\Extend\ServiceProvider;

class SlideCaptchaServiceProvider extends ServiceProvider
{
	protected $js = [
		'js/tn_code.js',
	];
	protected $css = [
		'css/style.css',
	];

	protected $exceptRoutes = [
		'auth' =>
		[
			'/auth/captcha',
			'/auth/check_captcha'
		]
	];

	public function register()
	{
		//

		   
	}

	public function init()
	{
		parent::init();
		
		//

	}

	public function settingForm()
	{
		return new Setting($this);
	}
}
