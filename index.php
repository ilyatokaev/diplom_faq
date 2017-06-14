<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);


require_once 'start_init.php';

/*$data = array();
for ($i = 1; $i < 2; $i++){
    $data[] = [
                "date" => date("d.m.Y  H.m.s")
                , "author" => "Автор-" . $i
                , "category" => "Категория-" . $i
                , "text" => "Текст вопроса-" . $i
                , "answers" => [0 => [
                                      "date" => date("d.m.Y  H.m.s")
                                      , "author" => "Автор ответа - 1"
                                      , "text" => "Текст ответа-1"
                                     ],
                                1 => [
                                      "date" => date("d.m.Y  H.m.s")
                                      , "author" =>  "Автор ответа2 - "
                                      , "text" => "Текст ответа-2"
                                     ]
                                ]
              ];
}

echo $twig->render('qq_list.twig', array('data' => $data));*/
//echo $twig->render('login_failed.twig');
//echo $twig->render('test.twig');
//$clientView = new ClientView("admin_desktop", ["users"]);
//$clientView->show("admin_desktop", "users");
//echo 'STARTTTT';
$clientView = new ClientView("qq_list");

$clientView->show();