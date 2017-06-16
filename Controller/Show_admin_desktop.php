<?php
//require_once 'start_init.php';
/**
 * Show_login_form Вызов формы авторизации
 *
 * @author Илья
 */
class Show_admin_desktop
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

        $clientView = new ClientView("admin_desktop", $this->getParams());
        $clientView->show();
        
    }
}
