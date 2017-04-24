<?php
session_start();

//require_once 'set_connect.php';

//$db = set_connect();

require_once 'vendor/autoload.php';
require_once './model/User.php';

$loader = new Twig_Loader_Filesystem('./templates');

$twig = new Twig_Environment($loader, array('cache'=>'./tmp/cache'
                                            , 'auto_reload'=>'true'));
