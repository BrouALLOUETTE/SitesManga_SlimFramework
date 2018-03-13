<?php

use Slim\Http\Request;
use Slim\Http\Response;

//route création bdd
$app->get('/mangbd',function (Request $request, Response $response)
{
	$this->db;// connexion base

    //addresse laravel: https://laravel.com/docs/4.2/schema
	$capsule = new \Illuminate\Database\Capsule\Manager;

    // test existance de la table
    $capsule::schema()->dropIfExists('manga_lists');
    $capsule::schema()->create('manga_lists', function (\Illuminate\Database\Schema\Blueprint $table)
    {
        $table->increments('id');
        $table->string('Name')->default('');
        $table->string('Autor')->default('');
        $table->string('Published')->default('');
        $table->string('Volume')->default('');
        $table->string('Status')->default('');
        $table->text('Description')->default('');
    });
    return $this->renderer->render($response, 'index.phtml', ["mangalist"=>$mangalist]);
});

$app->get('/user',function (Request $request, Response $response)
{

    $this->db;// connexion base

    //addresse laravel: https://laravel.com/docs/4.2/schema
    $capsule = new \Illuminate\Database\Capsule\Manager;

    // test existance de la table
    $capsule::schema()->dropIfExists('user');
    $capsule::schema()->create('user', function (\Illuminate\Database\Schema\Blueprint $user)
    {
        $table->increments('id');
        $table->string('Name')->default('');
        $table->string('Password')->default('');
    });
    return $this->renderer->render($response, 'index.phtml', ["mangalist"=>$mangalist]);
});

// route -> formulaire d'ajout
$app->get('/formulaire', function (Request $request, Response $response) {
    // Render index view
    return $this->renderer->render($response, 'formulaire.phtml');
});

// add item
$app->post('/ajout', function(Request $request,Response $response,array $args)
{
    if (!empty($request->getParam('Name'))) $name = strip_tags($request->getParam('Name'));
    if (!empty($request->getParam('Autor'))) $Autor=strip_tags($request->getParam('Autor'));
    if (!empty($request->getParam('Published'))) $Published=strip_tags($request->getParam('Published'));
    if (!empty($request->getParam('Volume'))) $Volume=strip_tags($request->getParam('Volume'));
    if (!empty($request->getParam('Status'))) $Status=strip_tags($request->getParam('Status'));
    if (!empty($request->getParam('Description'))) $Description=strip_tags($request->getParam('Description'));

    //verification du formulaire
    if (!empty($name) && !empty($Autor) && !empty($Published)  && !empty($Volume) && !empty($Status) && !empty($Description))
    {
        // connexion a la base
        $this->db;

        // ajout dans la bd
        $manga_list=new manga_list;
        $manga_list->name=$name;
        $manga_list->Autor=$Autor;
        $manga_list->Published=$Published;
        $manga_list->Volume=$Volume;
        $manga_list->Status=$Status;
        $manga_list->Description=$Description;
        $manga_list->save();

        $mangalist = manga_list::all();
        return $this->renderer->render($response, 'index.phtml', ["mangalist"=>$mangalist]);

    }
    else
    {
        $mangalist = manga_list::all();
        return $this->renderer->render($response, 'index.phtml', ["mangalist"=>$mangalist]);
    }
});

//route -> formulaire delete item
$app->get('/formulaire_sup.phtml', function (Request $request, Response $response) {
    // Render index view
    return $this->renderer->render($response, 'formulaire_sup.phtml');
});

//delete item
$app->get("/delete", function(Request $request,Response $response,array $args){

    $id=$request->getParam('id');
    $this->db;

    $manga_list = manga_list::find($id);
    $manga_list->delete();

    $mangalist = manga_list::all();
    return $this->renderer->render($response, 'index.phtml', ["mangalist"=>$mangalist]);
});

// route -> formulaire d'édition
$app->get('/formulaire_edit.phtml', function (Request $request, Response $response) {
    $id=$request->getParam('id');
    $this->db;
    // $id = $args['id'];
    $mangalist = manga_list::find($id);
    return $this->renderer->render ($response, "formulaire_edit.phtml", ["mangalist" => $mangalist]);
});

// edit and show one item
$app->post('/edit', function(Request $request,Response $response,array $args) {
    // echo 'ok';
    $name = $request->getParam('name');
    $Autor=$request->getParam('Autor');
    $Published=$request->getParam('Published');
    $Volume=$request->getParam('Volume');
    $Status=$request->getParam('Status');
    $Description=$request->getParam('Description');
    $id=$request->getParam('id');

    // connexion à la bdd
    $this->db;

    // update dans la bdd
    $manga_list= manga_list::find($id);
    $manga_list->name=$name;
    $manga_list->Autor=$Autor;
    $manga_list->Published=$Published;
    $manga_list->Volume=$Volume;
    $manga_list->Status=$Status;
    $manga_list->Description=$Description;

    $manga_list->save();

    $mangalist = manga_list::all();
    return $this->renderer->render($response, 'index.phtml', ["mangalist"=>$mangalist]);
});


// Show all
$app->get('/', function (Request $request, Response $response, array $args) {
        $this->db;
        $mangalist = manga_list::all();

        return $this->renderer->render($response, 'index.phtml', ["mangalist"=>$mangalist]);
});

$app->get('/index.phtml', function (Request $request, Response $response, array $args) {
        $this->db;
        $mangalist = manga_list::all();

        return $this->renderer->render($response, 'index.phtml', ["mangalist"=>$mangalist]);
});

// show one item
$app->get('/show_one.phtml', function (Request $request, Response $response, array $args) {
    $id=$request->getParam('id');
    $this->db;
    // $id = $args['id'];
    $mangalist = manga_list::find($id);
    return $this->renderer->render ($response, "show_one.phtml", ["mangalist" => $mangalist]);
});
