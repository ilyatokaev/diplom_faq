<?php
//require_once 'start_init.php';
/**
 * Show_login_form Вызов формы авторизации
 *
 * @author Илья
 */
class Show_user_password_change_form
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

    $user_id = $this->getParams()[1];

    $clientView = new ClientView("user_password_change_form", $user_id);
    $clientView->show();


    }
}
