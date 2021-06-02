<?php
$methods = [
	'submitAmbassador' => [
		'params' => [
			[
				'name' => 'title',
				'source' => 'p',
				'required' => true,
				'default' => 'ONPU',
			],
			[
				'name' => 'text',
				'source' => 'p',
				'required' => true,
				'default' => 'Hello, student',
			],
			[
				'name' => 'date',
				'source' => 'p',
				'required' => false,
			],
			[
				'name' => 'attachment',
				'source' => 'p',
				'required' => true,
				'default' => 'path',
			],
			[
				'name' => 'hashtags',
				'source' => 'p',
				'required' => false,
				'default' => '#OPU',
			],
			[
				'name' => 'geo',
				'source' => 'p',
				'required' => false,
				'default' => 'Odessa',
			],
		]
	]
];