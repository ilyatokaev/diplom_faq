<?php
session_start();

require_once 'vendor/autoload.php';

$loader = new Twig_Loader_Filesystem('templates');

$twig = new Twig_Environment($loader, array('cache'=>'tmp/cache'
                                            , 'auto_reload'=>'true'));

require_once './Classes/AutoloaderFaq.php';
spl_autoload_register(['AutoloaderFaq', 'loadClass']);
