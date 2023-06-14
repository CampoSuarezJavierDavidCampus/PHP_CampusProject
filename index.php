<?php
require_once('vendor/autoload.php');
use Config\Connection;
use Router\Router;

$conn = (new Connection())->db('db_campus');    
$router = new Router($conn);
$conn = null;
echo $router->render();
