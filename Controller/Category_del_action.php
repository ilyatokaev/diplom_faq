<?php
//require_once 'start_init.php';
/**
 * Show_login_form Вызов формы авторизации
 *
 * @author Илья
 */
class Category_del_action
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
    $category = new Category();
    $category->setId($this->getParams()['category_id']);
    
    if ($category->delete()){
        header('Location: router.php?params=show_admin_desktop:qq_categories');

    }

    }
}
