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

$className = explode("_", $signal, 2);
$methodName = $className[1];
$className = 'Controller' . $className[0];


if (!strpos(Cfg::getCurrentRoles(), "Admin")){
    if ($signal != 'Question_showCreateForm' 
            & $signal != 'User_showLoginForm' 
            & $signal != 'Question_create'
            & $signal != 'Question_userList'
            & $signal != 'User_login'
            )
    {
        die('!!!Доступ запрещен!!!');
    }
}


$controller = new $className($params);
$controller->$methodName();

