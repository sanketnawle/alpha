<?php

// This is the configuration for yiic console application.
// Any writable CConsoleApplication properties can be configured here.
return array(
	'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
	'name'=>'My Console Application',

    'import'=>array(
        'application.models.*',
        'application.components.*',
    ),

	// preloading 'log' component
	'preload'=>array('log','nodeSocket'),


    'commandMap' => array(
        'node-socket' => 'application.extensions.yii-node-socket.lib.php.NodeSocketCommand'
    ),


	// application components
	'components'=>array(


        'nodeSocket' => array(
            'class' => 'ext.yii-node-socket.lib.php.NodeSocket',
            'host' => 'localhost',  // default is 127.0.0.1, can be ip or domain name, without http
            'port' => 3001,      // default is 3001, should be integer
            'allowedServerAddresses' => array('127.0.0.1')
        ),
//		'db'=>array(
//			'connectionString' => 'sqlite:'.dirname(__FILE__).'/../data/testdrive.db',
//		),
		// uncomment the following to use a MySQL database

		'db'=>array(
			'connectionString' => 'mysql:host=localhost;dbname=urlinq_beta',
			'emulatePrepare' => true,
			'username' => 'root',
			'password' => '',
			'charset' => 'utf8',
		),

		'log'=>array(
			'class'=>'CLogRouter',
			'routes'=>array(
				array(
					'class'=>'CFileLogRoute',
					'levels'=>'error, warning',
				),
			),
		),
	),
);