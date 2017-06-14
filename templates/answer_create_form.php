<?php

/**
 * Description of User_del_form
 *
 * @author Илья
 */
class Answer_create_form
{
    
    
    public function GenArray($questionId)
    {
        
        $result['id_author'] = Cfg::getCurrentUserId();
        $result['id_q'] = $questionId;
                
        return $result;
    }
        
}
