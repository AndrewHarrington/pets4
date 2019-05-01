<?php

//error reporting
ini_set('display_errors', 1);
error_reporting(E_ALL);

session_start();


require_once('vendor/autoload.php');

$f3 = Base::instance();

$f3->set('colors', array('pink', 'green', 'blue'));
$f3->set('habitats', array('rock', 'land', 'tree', 'water'));

require_once('model/validation-functions.php');

$f3->route('GET|POST /', function (){

    session_destroy();

    echo "<h1>My Pets</h1>";
    echo "<a href='order'>Order a Pet</a>";

});

$f3->route('GET /@animal', function($f3, $params)
{
    if($params['animal']=='dog')
    {
        echo "woof";
    }
    else if( $params['animal']=='cat')
    {
        echo "meow";
    }
    else
    {
        $f3->error(404);
    }
});

$f3->route("GET|POST /order", function($f3){

    if($_SERVER['REQUEST_METHOD'] == 'POST')
    {
        $valid = true;
        if(validString($_POST['name']))
        {
            $_SESSION['animal'] = $_POST['name'];
        }
        else
        {
            $f3->set("errors['animal']", "Please enter an animal");
            $valid = false;
        }
        if(validNum($_POST['quantity'])){
            $_SESSION['quan'] = $_POST['quantity'];
        }
        else{
            $f3->set("errors['quan']", "Please enter a valid quantity");
            $valid = false;
        }

        if($valid){
            $f3->reroute("/order2");
        }
    }

    $view = new Template();
    echo $view->render("views/views.html");
});

$f3->route("GET|POST /order2", function($f3){
    if($_SERVER['REQUEST_METHOD'] == 'POST')
    {
        $valid = true;

        if(validColor($_POST['color']))
        {
            $_SESSION['color'] = $_POST['color'];
        }
        else
        {
            $f3->set("errors['color']", "Please enter a color");
            $valid = false;
        }

        if(!empty($_POST['habitat'])) {
            $_SESSION['habitat'] = implode(', ', $_POST['habitat']);
        }
        else {
            $f3->set("errors['habitat']", "Please check a habitat");
            $valid = false;
        }

        if($valid){
            $f3->reroute("/results");
        }
    }




    $view = new Template();
    echo $view->render("views/views2.html");
});

$f3->route("GET|POST /results", function($f3){
    $view = new Template();
    echo $view->render("views/results.html");
});

$f3->run();
