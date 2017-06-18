<?php

/**
 * Description of User_del_form
 *
 * @author Илья
 */
class Answer_edit_form
{
    function GenArray($answerId)
    {

        $answer = new Answer();
        
        $answer->setId($answerId);

        
        $result['id_answer'] = $answer->getId();
        $result['a_text'] = $answer->getText();
        
                
        return $result;
    }
        
}
