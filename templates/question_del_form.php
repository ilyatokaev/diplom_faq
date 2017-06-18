<?php

/**
 * Description of User_del_form
 *
 * @author Илья
 */
class Question_del_form
{
    function GenArray($questionId)
    {
        
        $question = new Question();
        $question->setId($questionId);
        $category = new Category();
        $category->setId($question->getCategoryId());
        
        $result['id_q'] = $question->getId();
        $result['category'] = $category->getCode();
        $result['author'] = $question->getAuthor();
        $result['email'] = $question->getEmail();
        $result['q_text'] = $question->getText();
        
        return $result;
    }
        
}
