<?php

// uncomment the following to define a path alias
// Yii::setPathOfAlias('local','path/to/local-folder');

// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.

Yii::setPathOfAlias('bootstrap', dirname(__FILE__).'/../extensions/bootstrap');



return array(
    
 

	   'theme'=>'bootstrap', // requires you to copy the theme under your themes directory
	'modules'=>array(
		'gii'=>array(
			'generatorPaths'=>array(
				'bootstrap.gii',
			),
		),
	),
	'components'=>array(
		'bootstrap'=>array(
			'class'=>'bootstrap.components.Bootstrap',
		),
	),
   
	'aliases' => array(
		'bootstrap' => realpath(__DIR__ . '/../extensions/bootstrap'),
		'yiiwheels' => realpath(__DIR__ . '/../extensions/yiiwheels'),
	),
	'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
	
	'name'=>'My Web Application',
	   // 'theme' => 'bootstrap', // requires you to copy the theme under your themes directory
	// preloading 'log' component
	'preload' => array('log'), //'bootstrap'),
	// autoloading model and component classes
	'import' => array(
		
		'bootstrap.*',
		'bootstrap.components.*',
		'bootstrap.models.*',
		'bootstrap.controllers.*',
		'bootstrap.helpers.*',
		'bootstrap.widgets.*',
		'bootstrap.extensions.*',
	   
		  
		 
		 'application.modules.*',
		'application.models.*',
		'application.components.*',
		'application.widgets.bootstrap.*',
		'bootstrap.helpers.TbHtml',
	),


	'modules'=>array(
		   
		// uncomment the following to enable the Gii tool
		'bootstrap' => array(
				'class' => 'bootstrap.BootStrapModule'
					),
			
		'gii'=>array(
			'class'=>'system.gii.GiiModule',
			'password'=>'flow37',
			// If removed, Gii defaults to localhost only. Edit carefully to taste.
			'ipFilters'=>array('127.0.0.1','::1'),
		),
		
	),

	// application components
	'components'=>array(
		'user'=>array(
			// enable cookie-based authentication
			'allowAutoLogin'=>true,
						
		),
		'bootstrap' => array (
			'class' => 'bootstrap.components.TbApi',
			),
		'yiiwheels' => array (
			'class' => 'yiiwheels.YiiWheels',
			),
				'bsHtml' => array(
						'class' => 'bootstrap.components.BSHtml'
					),
				  
				 
		// uncomment the following to enable URLs in path-format
		
		'urlManager'=>array(
			'urlFormat'=>'path',
			'rules'=>array(
							  
								'gii'=>'gii',
								'gii/<controller:\w+>'=>'gii/<controller>',
								'gii/<controller:\w+>/<action:\w+>'=>'gii/<controller>/<action>',
				'<controller:\w+>/<id:\d+>'=>'<controller>/view',
								/*
				'<controller:\w+>/<action:\w+>/<id:\d+>'=>'<controller>/<action>',
				'<controller:\w+>/<action:\w+>'=>'<controller>/<action>',
								 * */
								 
			),
		),
		/*
		'db'=>array(
			'connectionString' => 'sqlite:'.dirname(__FILE__).'/../data/testdrive.db',
		),
				 
				 */
		// uncomment the following to use a MySQL database
		
		'db'=>array(
			'connectionString' => 'mysql:host=localhost:3306;dbname=SydeGig',
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
		'Niyi Odumosu'=>'niyi@sydegig.com',
	),
);