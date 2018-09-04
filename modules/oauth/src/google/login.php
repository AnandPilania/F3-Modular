<?php

class Login {
	public function __construct($app, array $config, $loginer) {
		if ($config['google']['clientId'] == "" || $config['google']['clientSecret'] =="") {
			exit("clientId || clientSecret empty. Go To : <a href='https://console.developers.google.com'>Google Developer Console</a>");
		}

		include_once($config['src']."google/Google_Client.php");
		include_once($config['src']."google/contrib/Google_Oauth2Service.php");

		$Client = new Google_Client();
		$Client->setApplicationName($config['google']['ApplicationName']);
		$Client->setClientId($config['google']['clientId']);
		$Client->setClientSecret($config['google']['clientSecret']);
		$Client->setRedirectUri($config['login_url']."?oauth=google");
		$google_oauth = new Google_Oauth2Service($Client);

		if(isset($_GET['code'])){
			$Client->authenticate();
			$_SESSION['token'] = $Client->getAccessToken();
			//header('Location: ' . $Config['google']['login_url']);
		}

		if (isset($_SESSION['token'])) {
			$Client->setAccessToken($token);
		}

		if ($Client->getAccessToken()) {
			$UserData = $google_oauth->userinfo->get();
		    $data = array();
		    $data['oauth'] = "google";
			$data['uid'] = $UserData['id'];
			$data['name'] = $UserData['given_name'] ." ". $UserData['family_name'];
			$data['email'] = $UserData['email'];
			$data['gender'] = $UserData['gender'];
			$data['last_name'] = $UserData['given_name'];
			$data['first_name'] = $UserData['family_name'];
			$data['picture'] =  $UserData['picture'];
		    $loginer->user((object)$data);
			$_SESSION['sloginer'] = array("uid" => $data['uid'], "name" => $data['name'], "oauth" => $data['oauth']);
			unset($_SESSION['token']);
			header("location: ".$config['return_url']);
			exit();
		} else {
			$loginUrl = $Client->createAuthUrl();
			header("location: ".$loginUrl);
			exit();
		}
	}
}