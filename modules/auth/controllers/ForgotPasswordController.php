<?php

namespace Auth\Controllers;

use WebController;

class ForgotPasswordController extends WebController
{
	public function get()
	{
		view('auth::email');
	}

	public function post($f3)
	{}
}