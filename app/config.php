<?php
	//Constantes
	$configs = new HXPHP\System\Configs\Config;
	$configs->env->add('development');
	$configs->env->development->baseURI = '/FollowMeUp/';
	$configs->env->development->database->setConnectionData(array(
			'driver' => 'mysql',
			'host' => 'localhost',
			'user' => 'root',
			'password' => 'cp1205rm28f-',
			'dbname' => 'followmeup',
			'charset' => 'utf8'
	));
	$configs->env->development->auth->setURLs('/FollowMeUp/home','/FollowMeUp/login');


	$configs->env->add('production');

	$configs->env->production->baseURI = '/';

	$configs->env->production->database->setConnectionData(array(
			'driver' => 'mysql',
			'host' => 'followmeup.mysql.dbaas.com.br',
			'user' => 'followmeup',
			'password' => 'zszpuk541',
			'dbname' => 'followmeup',
			'charset' => 'utf8'
	));
	$configs->env->production->auth->setURLs('/home/','/login/');


		return $configs;
	/*
		//Globais
		$configs->global->models->directory = APP_PATH . 'models' . DS;

		$configs->global->views->directory = APP_PATH . 'views' . DS;
		$configs->global->views->extension = '.phtml';

		$configs->global->controllers->directory = APP_PATH . 'controllers' . DS;
		$configs->global->controllers->notFound = 'Error404Controller';

		$configs->title = 'Titulo customizado';

		//Configurações de Ambiente - Desenvolvimento
		$configs->env->add('development');

		$configs->env->development->baseURI = '/hxphp/';

		$configs->env->development->database->setConnectionData(array(
			'driver' => 'mysql',
			'host' => 'localhost',
			'user' => 'root',
			'password' => '',
			'dbname' => 'hxphp',
			'charset' => 'utf8'
		));

		$configs->env->development->mail->setFrom(array(
			'from' => 'Remetente',
			'from_mail' => 'email@remetente.com.br'
		));

		//Configurações de Ambiente - Produção
		$configs->env->add('production');

		$configs->env->production->baseURI = '/';

		$configs->env->production->database->setConnectionData(array(
			'driver' => 'mysql',
			'host' => 'localhost',
			'user' => 'usuariodobanco',
			'password' => 'senhadobanco',
			'dbname' => 'hxphp',
			'charset' => 'utf8'
		));

		$configs->env->production->mail->setFrom(array(
			'from' => 'Remetente',
			'from_mail' => 'email@remetente.com.br'
		));
	*/
	 


