<?php

/**
 * Description of User_del_form
 *
 * @author Илья
 */
class Question_create_form
{
    function GenArray()
    {
        
        $category = new Category();
        
        $result['categories'] = $category->simpleFullList();
                
        return $result;
    }
        
}
