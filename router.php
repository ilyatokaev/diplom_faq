<?php

require_once 'start_init.php';
require_once './common_functions.php';


$method = $_SERVER['REQUEST_METHOD'];


if ($method === "POST"){
    $signal = $_POST['signal'];
    $params = $_POST;
    
}elseif ($method === "GET"){
    $params = $_GET['params'];
    $params = explode(":", $params);
    $signal = $params[0];
}

   
$controller = new $signal($params);
$controller->action();


