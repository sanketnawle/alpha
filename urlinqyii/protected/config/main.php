<?php

// uncomment the following to define a path alias
// Yii::setPathOfAlias('local','path/to/local-folder');

// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.
include 'db_config.php';
return array(
    'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
    'name'=>'My Web Application',
//    'timeZone' => 'UTC',
    // preloading 'log' component
    'preload'=>array('log','nodeSocket'),

    // autoloading model and component classes
    'import'=>array(
        'application.models.*',
        'application.components.*',
        'ext.YiiMailer.YiiMailer',
        'ext.yii-node-socket.lib.php.NodeSocket.php'
    ),

    'modules'=>array(
        // uncomment the following to enable the Gii tool
        //*
        'gii'=>array(
            'class'=>'system.gii.GiiModule',
            'password'=>'test',
            // If removed, Gii defaults to localhost only. Edit carefully to taste.
            'ipFilters'=>array('127.0.0.1','::1'),
        )

    ),











    // application components
    'components'=>array(



        'nodeSocket' => array(
            'class' => 'ext.yii-node-socket.lib.php.NodeSocket',
            'host' => 'localhost',  // default is 127.0.0.1, can be ip or domain name, without http
            'port' => 3001,      // default is 3001, should be integer
            'allowedServerAddresses'=>array('127.0.0.1')
        ),





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
                //'<action:(fileUpload|contact|login|test|json|home|register|logout|timezone|onboard|sendVerificationEmail|verify|finishOnboarding|resendVerificationEmail|sendVerificationEmailFunction|sendReset|reset|doReset)>'=>'site/<action>',



                //Redirect program url to department
                //added for Touro univ
                'program/<id:\d+>'=>'department/view',
                'program/<id:\d+>/<action:\w+>/'=>'department/<action>',
                'program/<action:\w+>'=>'department/<action>',

                'search' => 'search/view',
                'calendar' => 'calendar/view',


                '<controller:\w+>/<id:\d+>'=>'<controller>/view',



                'home/feed' => 'feed/getHomePosts',
                'profile/<id:\d+>/feed' => 'feed/getProfilePosts',
                'class/<id:[\w|-]+>/feed' => 'feed/getClassPosts',

                'course/<id:[\w|\-|\s]+>/feed' => 'feed/getCoursePosts',
                //'course/<id>' => 'course/view',
                //'course/<id>' => 'partial/course',

                'club/<id:[\w|-]+>/feed' => 'feed/getClubPosts',
                'department/<id:[\w|-]+>/feed' => 'feed/getDepartmentPosts',
                'school/<id:[\w|-]+>/feed' => 'feed/getSchoolPosts',
                'post/<id:\d+>/feed' => 'feed/getPost',



                '<controller:\w+>/<id:\d+>/<action:\w+>/'=>'<controller>/<action>',


                '<controller:\w+>/<action:\w+>'=>'<controller>/<action>',



                '<action:\w+>'=>'site/<action>',

                'post/json' => '/post/index',
                'about' => '/site/page/view/about',

              'club/test'=>'club/test',



//                'post/create'=> 'post/create',
                'post/<id:\d+>/update' => 'post/update',
                'post/<id:\d+>/delete' => 'post/delete',
                'post/<id:\d+>/like' => 'post/like',
                'post/<id:\d+>/unlike' => 'post/unlike',

                'reply/<id:\d+>/update' => 'reply/update',
                'reply/<id:\d+>/delete' => 'reply/delete',
                'reply/<id:\d+>/upvote' => 'reply/upvote',
                'reply/<id:\d+>/downvote' => 'reply/downvote',

                'department/test'=>'department/test',

                //'club/<id:\d+>/members'=>'club/members',
                //'club/<id:\d+>/member/remove'=>'club/removeMember',

                //'search/<q>' => 'search/json', //going to need to redirect to search/view, by passing the JSON there
                //urlinq.com/getposts
                'getposts'=>'profile/getPosts',
                'search/'=>'search/view',
                'search/json'=>'search/json',

                'file/upload'=>'site/fileUpload',




            ),
        ),
        //*/
//		'db'=>array(
//			'connectionString' => 'sqlite:'.dirname(__FILE__).'/../data/testdrive.db',
//		),

        // uncomment the following to use a MySQL database

//		'db'=>array(
//			'connectionString' => 'mysql:host=localhost;dbname=urlinq_new',
//			'emulatePrepare' => true,
//			'username' => 'root',
//			'password' => '',
//			'charset' => 'utf8',
//		),
        'db'=>get_db_array(),
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