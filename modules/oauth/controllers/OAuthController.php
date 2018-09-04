<?php

namespace OAuth\Controllers;

use WebController;
use OAuth\Loginer;

class OAuthController extends WebController
{
	public function login($app)
	{
		$config = $app->get('oauth');
		$oauth = $app->get('GET.oauth');

		if(!$oauth) {
			exit("login url is Not valid");
		}

		if(!isset($_SESSION['sloginer'])) {
			if(in_array($oauth, array_keys($config)) == false || @$config[$oauth]['status'] != 1) {
				exit("Login Type Not allowed or Not exists");
			}
		}

		$loginer = new Loginer($app, [
			"loginer" => $oauth,
			"config" => $config
		]);
	}

	public function logout($f3)
	{
		$f3->clear('SESSION.sloginer');
		reroute($f3->get('oauth.return_url'));
	}

	public function example($f3)
	{
		echo 'example';
	}
}