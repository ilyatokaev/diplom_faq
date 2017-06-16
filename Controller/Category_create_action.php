<?php
//require_once 'start_init.php';
/**
 * Show_login_form Вызов формы авторизации
 *
 * @author Илья
 */
class Category_create_action
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

        $categoryCode = $this->getParams()['code'];

        $category = new Category();
        $category->create($categoryCode);

        echo 'Тема создана.';
        echo '<br><a href=router.php?params=show_admin_desktop:qq_categories>Вернуться к спску тем</a>';


    }
}
