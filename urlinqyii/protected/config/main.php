<?php

// uncomment the following to define a path alias
// Yii::setPathOfAlias('local','path/to/local-folder');

// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.
return array(
	'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
	'name'=>'My Web Application',

	// preloading 'log' component
	'preload'=>array('log'),

	// autoloading model and component classes
	'import'=>array(
		'application.models.*',
		'application.components.*',
	),

	'modules'=>array(
		// uncomment the following to enable the Gii tool
		//*
		'gii'=>array(
			'class'=>'system.gii.GiiModule',
			'password'=>'test',
			// If removed, Gii defaults to localhost only. Edit carefully to taste.
			'ipFilters'=>array('127.0.0.1','::1'),
		),
		//*/
	),

	// application components
	'components'=>array(
		'user'=>array(
			// enable cookie-based authentication
			'allowAutoLogin'=>true,
		),
		// uncomment the following to enable URLs in path-format
		//*
//		'urlManager'=>array(
//            'urlFormat'=>'path',
//            'showScriptName'=>false,
//            'rules'=>array(
//
//                '' => 'site/index',
//                'test' => 'site/test',
//
//            ),
//		),
        'urlManager'=>array(
            'urlFormat'=>'path',
            'showScriptName'=>false,
            'caseSensitive'=>false,

            //MUST ENABLE mod_rewrite IN APACHE AND HAVE PROPER .htaccess file FOR CLEAN URLS TO WORK
            'rules'=>array(
                //Maps multiple views in one line
                '<action:(contact|login|test|json|home)>'=>'site/<action>',
                'post/json' => '/post/index',
                'about' => '/site/page/view/about',


                '<controller:\w+>/<id:\d+>'=>'<controller>/view',


                'department/test'=>'department/test',

                'club/<id:\d+>/members'=>'club/members',
                'club/<id:\d+>/member/remove'=>'club/removeMember',


                //urlinq.com/getposts
                'getposts'=>'profile/getPosts',
                'search/json'=>'search/json',

                'file/upload'=>'site/fileUpload'
                //'<controller:\w+>/<action:\w+>/<id:\d+>'=>'<controller>/<action>',
//                '<controller:\w+>/<action:\w+>'=>'<controller>/<action>',


            ),
        ),
		//*/
//		'db'=>array(
//			'connectionString' => 'sqlite:'.dirname(__FILE__).'/../data/testdrive.db',
//		),
		// uncomment the following to use a MySQL database

		'db'=>array(
			'connectionString' => 'mysql:host=localhost;dbname=urlinq_new',
			'emulatePrepare' => true,
			'username' => 'root',
			'password' => '',
			'charset' => 'utf8',
		),

		'errorHandler'=>array(
			// use 'site/error' action to display errors
			'errorAction'=>'site/error',
		),
		'log'=>array(
			'class'=>'CLogRouter',
			'routes'=>array(
				array(
					'class'=>'CFileLogRoute',
					'levels'=>'error, warning',
				),
				// uncomment the following to show log messages on web pages
				/*
				array(
					'class'=>'CWebLogRoute',
				),
				*/
			),
		),
	),

	// application-level parameters that can be accessed
	// using Yii::app()->params['paramName']
	'params'=>array(
		// this is used in contact page
		'adminEmail'=>'webmaster@example.com',
	),
);