<?php

/**
 * Description of User_del_form
 *
 * @author Илья
 */
class Category_del_form
{
    function GenArray($category_id)
    {

        $category = new Category();
        
        $category->setId($category_id);
        

        
        $result['category_id'] = $category_id;
        $result['code'] = $category->getCode();
                
        return $result;
    }
        
}
