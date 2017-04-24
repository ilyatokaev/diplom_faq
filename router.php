<?php

require_once 'start_init.php';
require_once './common_functions.php';


$method = $_SERVER['REQUEST_METHOD'];

if ($method === "POST"){
    $signal = $_POST['signal'];
    
}elseif ($method === "GET"){
    $params = $_GET['params'];
    $params = explode(":", $params);
    $signal = $params[0];
}

var_dump($signal);

//Вызов формы авторизации
if($signal === "show_login_form"){
    echo $twig->render('login.twig');

// Авторизация    
}elseif ($signal === "login_action"){

    if ($method === "GET"){
        $login = $params[1];
        $password = $params[2];
    }elseif ($method === "POST")
    {
        $login = $_POST['login'];
        $password = $_POST['login'];
    }
        
    $user = new User();
    
   
    if ($user->login($login, $password)){
        $_SESSION['userId'] = $user->getId();
        $_SESSION['userLogin'] = $user->getLogin();
        $_SESSION['userDescription'] = $user->getDescription();
        
        echo "Удачный логин";
        
    } else {
        echo "Неудачный логин";
        echo $twig->render('login_failed.twig');
    }
}