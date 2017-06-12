<?php

/**
 * Description of User_del_form
 *
 * @author Илья
 */
class User_del_form
{
    function GenArray($user_id)
    {
        
        $user = new User;
        
        $user->setId($user_id);
        

        
        $result['user_id'] = $user_id;
        $result['login'] = $user->getLogin();
        $result['description'] = $user->getDescription();
                
        return $result;
    }
        
}
