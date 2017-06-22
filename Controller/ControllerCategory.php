<?php
/**
 * Description of ControllerUser
 *
 * @author Илья
 */
class ControllerCategory
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
    
    
    public function showCreateForm()
    {
        $clientView = new ClientView("category_create_form");
        $clientView->show();
    }
    
    
    public function create()
    {
        $categoryCode = $this->getParams()['code'];

        $category = new Category();
        $category->create($categoryCode);

        echo 'Тема создана.';
        echo '<br><a href=router.php?params=Admin_showDesktop:qq_categories>Вернуться к спску тем</a>';
    }
    
    
    public function showDelForm()
    {
       $categoryId = $this->getParams()[1];

        $clientView = new ClientView("category_del_form", $categoryId);
        $clientView->show();
    }
    
    
    public function delete()
    {
        $category = new Category();
        $category->setId($this->getParams()['category_id']);

        if ($category->delete()){
            header('Location: router.php?params=Admin_showDesktop:qq_categories');

        }
    }

}
