<?php
session_start();

//require_once 'set_connect.php';

//$db = set_connect();

require_once 'vendor/autoload.php';
require_once './model/User.php';
require_once './model/Category.php';
require_once './model/Question.php';
require_once './model/Answer.php';
require_once './Classes/ClientView.php';
require_once './Classes/Cfg.php';
require_once './templates/admin_desktop.php';
require_once './templates/user_password_change_form.php';
require_once './templates/user_del_form.php';
require_once './templates/category_del_form.php';
require_once './templates/qq_list.php';
require_once './templates/question_create_form.php';

/*$loader = new Twig_Loader_Filesystem('./templates');

$twig = new Twig_Environment($loader, array('cache'=>'./tmp/cache'
                                            , 'auto_reload'=>'true'));*/


$loader = new Twig_Loader_Filesystem('templates');

$twig = new Twig_Environment($loader, array('cache'=>'tmp/cache'
                                            , 'auto_reload'=>'true'));
