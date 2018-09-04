<?php

return [
	'ASSETS' => [
		'auto_include' => true,
		'greedy' => false,
		'filter' => [
			'js' => 'minify,combine',
			'css' => 'minify,combine',
		],
		'public_path' => '/compressed/',
		//'combine' => [
			//'public_path' => 'ui-assets/compressed/',
			//'exclude' => ".*(\/plugin\/).*",
			//'slots' => [
				//'30' => 'custom',
			//],
		//],
		//'minify' => [
			//'public_path' => 'ui-assets/compressed/',
			//'exclude' => ".*(.min.).*"
			//'inline' => true
		//],
		'timestamps' => true
		//'fixRelativePaths' => 'relative',
		//'handle_inline' = true
		//'prepend_base' = true
	]
];