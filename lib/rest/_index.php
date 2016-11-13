<?php
require 'Slim/Slim.php';

\Slim\Slim::registerAutoloader();

$app = new \Slim\Slim();

// add new Route 
$app->get("/", function () {
    echo "<h1>Probando Slim</h1>";
});
$app->run();
