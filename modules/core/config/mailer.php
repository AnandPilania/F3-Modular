<?php

return [
	'mailer' => [
		'smtp' => [
			'host' => 'smtp.domain.com',
			'port' => 25,
			'user' => 'username',
			'pw' => 'password',
			'scheme' => null, // SSL, TLS
		],
		'from_mail' => 'info@domain.de',
		'from_name' => 'Web Application',
		'errors_to' => 'error@domain.com',
		'return_to' => 'bounce@domain.com',
		'on' => [
			'failure' => '\MailTest::logError',
			'ping' => '\MailTest::traceMail',
			'jump' => '\MailTest::traceClick',
			'jumplinks' => true,
			'storage_path' => root_path('storage/logs/')
		]
	]
];