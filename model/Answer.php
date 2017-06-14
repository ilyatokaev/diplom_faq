<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Category
 *
 * @author Илья
 */
class Answer
{
    
    
    private $questionId;
    
    public function getList()
    {
        $sql = "SELECT a.id 
                    , a.create_date
                    , u.login
                    , a.a_text
                FROM answers a
                    INNER JOIN users u
                        ON a.id_author = u.id
                WHERE a.id_q = :id_q
                ";
        
        $result['header'] = ["id", "Дата создания", "Автор", "Текст ответа"];
        
        if (!$st = Cfg::getDB()->prepare($sql)){
            die('Не удалось подготовить запрос на получение списка ответов!');
        }
        
        $st->bindParam('id_q', $this->getQuestionId(), PDO::PARAM_INT);
        
        
        if (!$st->execute()) {

            die('Не удалось выполнить запрос на получение списка ответов!');
        }
        
        $result['body'] = [];
        while ($row = $st->fetch(PDO::FETCH_ASSOC)){
            $result['body'][] = ['data' => $row];
        }

            
        return $result;
    }
    
    
    public function setQuestionId($questionId)
    {
        $this->questionId = $questionId;
    }
    

    public function getQuestionId()
    {
        return $this->questionId;
    }

}
