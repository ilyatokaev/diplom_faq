<?php
//require_once 'start_init.php';
/**
 * Show_login_form Вызов формы авторизации
 *
 * @author Илья
 */
class User_password_change_action
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

        $user_id = $this->getParams()['user_id'];
        $newPassword = $this->getParams()['newPassword'];

        $user = new User();
        $user->setId($user_id);

        if ($user->setPassword($newPassword)){
            echo 'Пароль изменен.';
        }else{
            echo 'Не удалось изменить пароль!';
        }

        echo '<br><a href=router.php?params=show_admin_desktop:users>Вернуться к спску пользователей</a>';


    }
}
