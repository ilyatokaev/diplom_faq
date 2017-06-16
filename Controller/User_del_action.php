<?php
//require_once 'start_init.php';
/**
 * Show_login_form Вызов формы авторизации
 *
 * @author Илья
 */
class User_del_action
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

    $user = new User;
    $user->setId($this->getParams()['user_id']);
    
    if ($user->delete()){
        header('Location: router.php?params=show_admin_desktop:users');
        
        /*$clientView = new ClientView("admin_desktop", [null, "users"]);
        $clientView->show();*/
    }


    }
}
