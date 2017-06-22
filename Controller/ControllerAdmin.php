<?php

/**
 * Description of ControllerUser
 *
 * @author Илья
 */
class ControllerAdmin
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
    
    public function showDesktop()
    {
        $clientView = new ClientView("admin_desktop", $this->getParams());
        $clientView->show();
    }
}
