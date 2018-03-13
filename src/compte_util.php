<?php

use Slim\Http\Request;
use Slim\Http\Response;

// create one user
app->get('/userbd',function (Request $request, Response $response)
{
	//connection to base
	$this->db;

	// adresse laravel
	$capsule = new \Illuminate\Database\Capsule\Manager; 

	$capsule::schema()->dropIfExists('user');
	$capsule::schema()->create('manga_lists', function (\Illuminate\Database\Schema\Blueprint $user)
	{
		$user->increments('id');
		$user->string('user');
		$user->string('password');
	});
});

//route -> add user
app->get('/AjoutUser',function (Request $request, Response $response)
{
	if (!empty($request->getParam('user'))) $name = strip_tags($request->getParam('user'));
	if (!empty($request->getParam('password'))) $name = strip_tags($request->getParam('password'));

	if (!empty($user) && !empty($password))
	{
		$this->db;
		$user=new user;
		$user->user=$user;
		$user->user=$user;
		echo 'user added';
	}
	else echo 'user dont added '
});