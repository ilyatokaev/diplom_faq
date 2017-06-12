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
        $password = $_POST['password'];
    }
        
    $user = new User();
   
    if ($user->login($login, $password)){
        $_SESSION['userId'] = $user->getId();
        $_SESSION['userLogin'] = $user->getLogin();
        $_SESSION['userDescription'] = $user->getDescription();
        $_SESSION['roles'] = $user->getRolesString();
        echo $twig->render('admin_desktop.twig');
        
    } else {

        echo $twig->render('login_failed.twig');
    }

// Вызов панели администратора
}elseif ($signal === "show_admin_desktop"){
    //$clientView = new ClientView("admin_desktop", $params[1]);
    $clientView = new ClientView("admin_desktop", $params);
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
    
    if (!$user->addRole('Admin')){
        die('Не удалось добавить роль пользователю!');
    }
    echo '<br><a href=router.php?params=show_admin_desktop:users>Вернуться к спску пользователей</a>';

// Вызов формы создания пользователя
}elseif ($signal === "show_user_create_form"){
     $clientView = new ClientView("user_create");
     $clientView->show();
     

// Вызов формы удаления пользователя
}elseif ($signal === "show_user_del_form"){
    $clientView = new ClientView("user_del_form", $params[1]);
    $clientView->show();

// Вызов формы удаления пользователя
}elseif ($signal === "user_del_action"){
    $user = new User;
    $user->setId($_POST['user_id']);
    
    if ($user->delete()){
        $clientView = new ClientView("admin_desktop", "users");
        $clientView->show();
    }
}


// Вызов формы изменения пароля пользователя
elseif ($signal === "show_user_password_change_form"){
    $user_id = $params[1];
    $clientView = new ClientView("user_password_change_form", $user_id);
    $clientView->show();
}

// Изменение пароля пользователя    
elseif ($signal === "user_password_change_action"){

    if ($method === "GET"){
        $user_id = $params[1];
        $password = $params[2];
    }elseif ($method === "POST")
    {
        $user_id = $_POST['user_id'];
        $newPassword = $_POST['newPassword'];
    }
        
    $user = new User();
    $user->setId($user_id);

    if ($user->setPassword($newPassword)){
        echo 'Пароль изменен.';
    }else{
        echo 'Не удалось изменить пароль!';
    }
    
    echo '<br><a href=router.php?params=show_admin_desktop:users>Вернуться к спску пользователей</a>';

// Вызов формы создания темы
}elseif ($signal === "show_category_create_form"){
     $clientView = new ClientView("category_create_form");
     $clientView->show();
}

// Создание темы
elseif ($signal === "category_create_action"){

    if ($method === "GET"){
        $categoryCode = $params[1];
    }elseif ($method === "POST")
    {
        $categoryCode = $_POST['code'];
    }
        
    $category = new Category();
    $category->create($categoryCode);

    echo 'Тема создана.';
    echo '<br><a href=router.php?params=show_admin_desktop:qq_categories>Вернуться к спску тем</a>';


// Вызов формы удаления темы
}elseif ($signal === "show_category_del_form"){
    $clientView = new ClientView("category_del_form", $params[1]);
    $clientView->show();

// Вызов формы удаления темы
}elseif ($signal === "category_del_action"){
    $category = new Category();
    $category->setId($_POST['category_id']);
    
    if ($category->delete()){
        $clientView = new ClientView("admin_desktop", "qq_categories");
        $clientView->show();
    }
}
