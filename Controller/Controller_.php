<?php
/**
 * Description of ControllerUser
 *
 * @author Илья
 */
class ControllerXX
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

}
