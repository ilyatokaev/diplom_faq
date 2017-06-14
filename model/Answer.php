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
    private $text;
    private $idAuthor;
    
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
        
        $questionId = $this->getQuestionId();
        $st->bindParam(':id_q', $questionId, PDO::PARAM_INT);
        
        
        if (!$st->execute()) {

            die('Не удалось выполнить запрос на получение списка ответов!');
        }
        
        $result['body'] = [];
        while ($row = $st->fetch(PDO::FETCH_ASSOC)){
            $result['body'][] = ['data' => $row];
        }

            
        return $result;
    }

    public function getSimpleList()
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
        
        $questionId = $this->getQuestionId();
        $st->bindParam(':id_q', $questionId, PDO::PARAM_INT);
        
        
        if (!$st->execute()) {

            die('Не удалось выполнить запрос на получение списка ответов!');
        }
        

        $result = $st->fetchAll(PDO::FETCH_ASSOC);

            
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

    
    public function setText($text)
    {
        $this->text = $text;
    }
    
    public function getText()
    {
        return $this->text;
    }
    

    public function setIdAuthor($idAuthor)
    {
        $this->idAuthor = $idAuthor;
    }
    
    public function getIdAuthor()
    {
        return $this->idAuthor;
    }

    
    public function create()
    {

        $sql = "INSERT INTO answers (id_q, create_date, a_text, id_author)
                    VALUES (:id_q, :create_date, :a_text, :id_author)
               ";
        
        $db = Cfg::getDB();
        
        if (!$st = $db->prepare($sql)){
            die('Не удалось подготовить запрос на создание ответа!');
        }

        $st->bindParam(':id_q', $_POST['id_q'], PDO::PARAM_INT);
        $st->bindParam(':create_date', date(DATE_ATOM), PDO::PARAM_STR); 
        $st->bindParam(':a_text', $_POST['a_text'], PDO::PARAM_STR);
        $st->bindParam(':id_author', $_POST['id_author'], PDO::PARAM_STR);

        
        if (!$st->execute()) {
var_dump($_POST['id_q'],date(DATE_ATOM),$_POST['a_text'],$_POST['id_author'], $st->queryString);
            die('Не удалось выполнить запрос на создание ответа!');
        }
        
        return $db->lastInsertId();

    }

}
