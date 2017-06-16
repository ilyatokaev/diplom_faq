<?php

/**
 * Description of UserView
 *
 * @author Илья
 */
class ClientView
{
    
    private $viewName;
    private $params;
            
    function __construct($viewName, $params = NULL)
    {
        $this->setViewName($viewName);
        $this->setParams($params);
    }
            
    private function setViewName($value){
        $this->viewName = $value;
    }
    
    private function setParams($value){
        $this->params = $value;
    }
            
    //function show($viewName, $mode = NULL)
    function show()
    {
        
        global $twig;
        
        if (file_exists("templates/" . $this->viewName . ".php")){

            $view = new $this->viewName();
            $array = $view->genArray($this->params);

            echo $twig->render($this->viewName . ".twig", $array);
        } else {
            echo $twig->render($this->viewName . ".twig");
        }
        
    }
    
}
