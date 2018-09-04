<?php
class Login {
	public function __construct($app, array $config, $loginer) {
		if ($config['facebook']['app_id'] == "" || $config['facebook']['app_secret'] =="") {
			exit("app_id || app_secret empty. Go To : <a href='https://developers.fecebook.com'> Facebook Developers</a>");
		}

		require_once $config['src'].'facebook/autoload.php';

		$fb = new Facebook\Facebook([
		  'app_id' => $config['facebook']['app_id'],
		  'app_secret' => $config['facebook']['app_secret'],
		  'default_graph_version' => $config['facebook']['default_graph_version'],
		 ]);

		$helper = $fb->getRedirectLoginHelper();

		try {
		 	$accessToken = $helper->getAccessToken();
		} catch(Facebook\Exceptions\FacebookResponseException $e) {
		   	exit("<p>".$e->getMessage()."</p>");
		} catch(Facebook\Exceptions\FacebookSDKException $e) {
		   	exit("<p>".$e->getMessage()."</p>");
		}

		if (isset($accessToken)) {

		    $UserData = $fb->get('me?fields=id,name,email,gender,last_name,first_name,picture.height(200).width(200)', (string) $accessToken);
			$UserData = $UserData->getGraphNode()->asArray();
		    $data = array();
		    $data['oauth'] = "facebook";
			$data['uid'] = $UserData['id'];
			$data['name'] = $UserData['name'];
			$data['email'] = $UserData['email'];
			$data['gender'] = $UserData['gender'];
			$data['last_name'] = $UserData['last_name'];
			$data['first_name'] = $UserData['first_name'];
			$data['picture'] =  $UserData['picture']['url'];
		    $loginer->user((object)$data);
			$_SESSION['sloginer'] = array("uid" => $data['uid'], "name" => $data['name'], "oauth" => $data['oauth']);
			unset($_SESSION['FBRLH_state']);
			header("location: ".$config['return_url']);
			exit();

		} else {
			$loginUrl = $helper->getLoginUrl($config['login_url']."?oauth=facebook", ['email']);
			header("location: ".$loginUrl);
			exit();
		}
	}
}