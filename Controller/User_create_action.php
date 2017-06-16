<?php
//require_once 'start_init.php';
/**
 * Show_login_form Вызов формы авторизации
 *
 * @author Илья
 */
class User_create_action
{
    private $params;
    
    public function __construct($params)
    {
        $this->setParams($params);

    }

    private function setParams($params)
    {
        $this->params = $params;
    }

    private function getParams()
    {
        return $this->params;
    }

    public function action()
    {

        $login = $this->getParams()['login'];
        $password = $this->getParams()['password'];
        $description = $this->getParams()['description'];

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
        echo '<br><a href=router.php?params=show_admin_desktop:users>Вернуться к списку пользователей</a>';



    }
}
