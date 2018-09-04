<?php
namespace OAuth;
use Base;
use OAuth\Models\OAuth as Model;
class Loginer {
	protected $app, $loginType, $config, $model;

	function __construct(Base $app, $data) {
		$this->app = $app;
		$this->loginType = $data['loginer'];
		$this->config = $data['config'];
		$this->model = new Model();

		if (file_exists($file = $this->config['src'].$this->loginType."/login.php")) {
			include_once $file;
			$login = new \Login($app, $this->config, $this);
		} else {
			exit("Include File Not Exists");
		}
	}

	public function user($data) {
		$user = $this->model->load(array("oauth = ? AND uid = ?", $data->oauth, $data->uid));
		if($user->dry()) { $user->reset(); }
		$user->copyFrom($data, array_keys($user->getFieldConfiguration()));
		$user->date_modified = date("Y-m-d H:i:s", time());
		$user->save();
	}
}
