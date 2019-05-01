<?php

//error reporting
ini_set('display_errors', 1);
error_reporting(E_ALL);

session_start();


require_once('vendor/autoload.php');

$f3 = Base::instance();

$f3->set('colors', array('pink', 'green', 'blue'));

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
        if(validString($_POST['name']))
        {
            $_SESSION['animal'] = $_POST['name'];
            $f3->reroute("/order2");
        }
        else
        {
            $f3->set("errors['animal']", "Please enter an animal");
        }
    }

    $view = new Template();
    echo $view->render("views/views.html");
});

$f3->route("GET|POST /order2", function($f3){

    if($_SERVER['REQUEST_METHOD'] == 'POST')
    {
        if(validColor($_POST['color']))
        {
            $_SESSION['color'] = $_POST['color'];
            $f3->reroute("/results");
        }
        else
        {
            $f3->set("errors['color']", "Please enter a color");
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
