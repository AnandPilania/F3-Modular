<?php

return [
	'env' => 'dev',
	'status' => 'up',
	'lang' => 'en',
	'tz' => 'UTC',
	'charset' => 'UTF-8',
	'secret' => 'base64:q0qOrqLUldTC8rnfZDWi8+kOpQiGIlUF0q9MJzVf8BA=',
	'db_type' => 'jig',
	'db_host' => 'localhost',
	'db_port' => '3356',
	'db_user' => 'root',
	'db_pswd' => 'pswd',
	'db_name' => 'test',
	'db_path' => root_path('/storage/db/'),
	'session_db' => true,
	'csrf' => true,
	'cache' => true,
	'TEMP' => root_path('/storage/temp/'),
	'packages' => [
		'assets' => true,
		'mailer' => true,
		'events' => true,
		'middlewares' => true
	]
];