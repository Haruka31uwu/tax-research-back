<?php

$container->set('database', function() {
	return (object) [
		'default' => [
			"DB_HOST" => 'localhost',
			"DB_NAME" => 'taxresearch3',
			"DB_USER" => 'root',
			"DB_PASS" => '123456',
			"DB_CHAR" => 'utf8'
		]
	];
});