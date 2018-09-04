<?php

return [
	'reloadr' => [
		'freq' => 5000,
		'dirs' => [ 'resources/', 'public/assets/' ],
		'files' => null,
		'filter' => [
			'except' => '.git',
			'accept' => [ 'php', 'htm', 'html', 'css', 'js' ]
		]
	]
];