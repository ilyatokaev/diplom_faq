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
class Category
{
    
    private $id;
    private $code;


    
    public function simpleFullList()
    {
        
        $sql = "SELECT cat.id, cat.code FROM categories cat";

        if (!$st = Cfg::getDB()->prepare($sql)){
            die('Не удалось подготовить запрос получения упрощенного списка категорий!');
        }
        
        if (!$st->execute()) {
            die('Не удалось выполнить запрос получения упрощенного списка категорий!');
        }
        
        $result = $st->fetchAll(PDO::FETCH_ASSOC);
            
        return $result;
        
    }

    
    public function fullList()
    {
        $sql = "SELECT cat.id
                        , cat.code
                        , IFNULL(qq.qq_quantity, 0) all_quantity
                        , IFNULL(pub.qq_quantity, 0) pub_quantity
                        , IFNULL(na.qq_quantity, 0) noanswer_quantity
                        , IFNULL(h.qq_quantity, 0) hidden_quantity
                        
                FROM categories cat
                    LEFT OUTER JOIN (
                                        SELECT q0.id_category, count(*) qq_quantity
                                        FROM qq q0
                                        GROUP BY q0.id_category
                                    ) qq
                                        
                        ON cat.id = qq.id_category
                    LEFT OUTER JOIN (
                                        SELECT q0.id_category, count(*) qq_quantity
                                        FROM qq q0
                                        WHERE q0.id_status = 2
                                        GROUP BY q0.id_category
                                    ) pub
                        ON cat.id = pub.id_category
                    LEFT OUTER JOIN (
                                        SELECT q0.id_category, count(*) qq_quantity
                                        FROM qq q0
                                        WHERE q0.id NOT IN (
                                                            SELECT id_q
                                                            FROM answers
                                                           )
                                        GROUP BY q0.id_category
                                    ) na
                        ON cat.id = na.id_category
                    LEFT OUTER JOIN (
                                        SELECT q0.id_category, count(*) qq_quantity
                                        FROM qq q0
                                        WHERE q0.id_status = 3
                                        GROUP BY q0.id_category
                                    ) h
                        ON cat.id = h.id_category

                ";
        
        $result['header'] = ["Id", "Тема", "Вопросов", "Опубликовано", "Без ответов", "Скрытых"];
        
        if (!$st = Cfg::getDB()->prepare($sql)){
            die('Не удалось подготовить запрос получения списка категорий!');
        }
        
        if (!$st->execute()) {

            die('Не удалось выполнить запрос получения списка категорий!');
        }
        
        $result['body'] = [];
        while ($row = $st->fetch(PDO::FETCH_ASSOC)){
            $result['body'][] = ['data' => $row];
        }
            
        return $result;
    }
    
    public function setId($id)
    {
        $this->id = $id;
        
        $sql = "SELECT code FROM categories WHERE id = :id";
        
        if (!$st = Cfg::getDB()->prepare($sql)){
            die('Не удалось подготовить запрос на получения темы!');
        }
        
        $st->bindParam(':id', $this->id, PDO::PARAM_INT);

        if (!$st->execute()){
            die('Не удалось выполнить запрос на получения темы!');
        }
        
        if (!$row = $st->fetch(PDO::FETCH_ASSOC)){
            die('Не удалось найти тему по Id!');
        }
        
        $this->setCode($row['code']);
        
    }
    
    public function getId()
    {
        return $this->id;
    }
    

    private function setCode($code)
    {
        $this->code = $code;
    }
    
    public function getCode()
    {
        return $this->code;
    }

    
    public function create($code)
    {
        
        $db = Cfg::getDB();
        
        $sql = "INSERT INTO categories (code) VALUES (:code)";
        
        if (!$st = $db->prepare($sql)){
            die('Не удалось подготовить запрос на создание категории!');
        }

        $st->bindParam(':code', $code, PDO::PARAM_STR);
        
        if (!$st->execute()) {

            die('Не удалось выполнить запрос на создание категории!!');
        }
        
        $this->setId($db->lastInsertId());
        $this->setCode($code);
        
        return $this->getId();
    }
    
    public function delete()
    {
        
        $db = Cfg::getDB();
        
        $sql = "DELETE FROM categories WHERE id = :id";
        
        if (!$st = $db->prepare($sql)){
            die('Не удалось подготовить запрос на удаление категории!');
        }

        $st->bindParam(':id', $this->getId(), PDO::PARAM_INT);
        
        if (!$st->execute()) {

            die('Не удалось выполнить запрос на удаление категории! Возможно это потму, что в категории содержатся вопросы!');
        }
        
        return TRUE;
    }

}
