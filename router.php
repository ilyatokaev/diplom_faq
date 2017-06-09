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
        echo $twig->render('admin_desktop.twig');
        
    } else {

        echo $twig->render('login_failed.twig');
    }

// Вызов панели администратора
}elseif ($signal === "show_admin_desktop"){
    $clientView = new ClientView("admin_desktop", $params[1]);
    $clientView->show();

    
// Создание пользователя    
}elseif ($signal === "user_create_action"){

    if ($method === "GET"){
        $login = $params[1];
        $password = $params[2];
        $description = $params[3];
    }elseif ($method === "POST")
    {
        $login = $_POST['login'];
        $password = $_POST['password'];
        $description = $_POST['description'];
    }
        
    $user = new User();
    

    if ($user->findLogin($login)){
        echo 'Пользователь с таким Логином уже существует!';
    }elseif ($user->create($login, $password, $description)){
        echo 'Пользователь создан';
    } else {
        echo 'Не удалось создать пользователя';
    }
    echo '<br><a href=router.php?params=show_admin_desktop:users>Вернуться к спску пользователей</a>';

// Вызов формы создания пользователя
}elseif ($signal === "show_user_create_form"){
     $clientView = new ClientView("user_create");
     $clientView->show();
     

// Вызов формы удаления пользователя
}elseif ($signal === "show_user_del_form"){
    $clientView = new ClientView("user_del", $params[1]);
    $clientView->show();
}