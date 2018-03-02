<?php

namespace Auth\Controllers;

use WebController;
use Auth\Models\User;
use Auth\Models\Activation;

class SignupController extends WebController
{
	public function get($f3)
	{
		view('auth::signup');
	}

	public function post($f3)
	{
		$data = $f3->get('POST');
		$validator = $this->validate($data, [
			'first_name' => 'required|min:3',
			'last_name' => 'required|min:3',
			'email' => 'required|email|unique:Auth\Models\User',
			'password' => 'required|min:6'
		]);
		if(!$validator->passed()) {
			view('auth::signup', ['errors' => $validator->errors()]);
		}
	}
}