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


if (!strpos(Cfg::getCurrentRoles(), "Admin")){
    if ($signal != 'show_question_create_form' 
            & $signal != 'show_login_form' 
            & $signal != 'question_create_action'
            & $signal != 'show_qq_list'
            & $signal != 'login_action'
            )
    {
        die('!!!Доступ запрещен!!!');
    }
}

$controller = new $signal($params);
$controller->action();


