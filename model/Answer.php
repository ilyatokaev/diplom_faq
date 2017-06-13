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
    
    static function getList($idQ)
    {
        $sql = "SELECT a.create_date
                    , u.login
                    , a.a_text
                FROM answers a
                    INNER JOIN users u
                        ON a.id_author = u.id
                WHERE a.id_q = :id_q
                ";
        
        if (!$st = Cfg::getDB()->prepare($sql)){
            die('Не удалось подготовить запрос на получение списка ответов!');
        }
        
        if (!$st->execute()) {

            die('Не удалось выполнить запрос на получение списка ответов!');
        }
        
        $result = $st->fetchAll(PDO::FETCH_ASSOC);
            
        return $result;
    }
}
