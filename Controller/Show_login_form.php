<?php
//require_once 'start_init.php';
/**
 * Show_login_form Вызов формы авторизации
 *
 * @author Илья
 */
class Show_login_form
{
    public function __construct($params)
    {
    }

    public function action()
    {
        global $twig;

        echo $twig->render('login.twig');
    }
}
