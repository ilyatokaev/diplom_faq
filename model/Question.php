<?php
/**
 * Description of Question
 *
 * @author Илья
 */
class Question
{
    //put your code here
    
    private $Id;
    private $categoryId;
    private $text;
    private $author;
    private $email;
    
    public function setId($id)
    {
        $this->id = $id;
    }
    
    public function getId()
    {
        return $this->id;
    }

    
    public function setCategoryId($categoryId)
    {
        $this->categoryId = $categoryId;
    }
    
    public function getCategoryId()
    {
        return $this->categoryId;
    }


    public function setText($text)
    {
        $this->text = $text;
    }
    
    public function getText()
    {
        return $this->text;
    }


    public function setAuthor($author)
    {
        $this->author = $author;
    }
    
    public function getAuthor()
    {
        return $this->author;
    }


    public function setEmail($email)
    {
        $this->email = $email;
    }
    
    public function getEmail()
    {
        return $this->email;
    }
    
    
    public function listOneCategory()
    {
    
        $sql = "SELECT q.create_date
                    , q.q_text
                    , q.author
                    , q.email
                    , IFNULL(a.answers_quantity, 'Ожидает ответа')
                    , s.description
                    
                FROM qq q
                    LEFT OUTER JOIN (
                                        SELECT a0.id_q, count(*) answers_quantity
                                        FROM answers a0
                                        GROUP BY a0.id_q
                                    ) a
                        ON q.id = a.id_q
                    INNER JOIN qq_statuses s ON q.id_status = s.id
                WHERE q.id_category = :id_category
                ";
        
        $result['header'] = ["Дата создания", "Вопрос", "Автор", "E-mail", "Ответов", "Статус"];
        
        if (!$st = Cfg::getDB()->prepare($sql)){
            die('Не удалось подготовить запрос на получение списка вопросов!');
        }
        
        $st->bindParam(':id_category', $this->getCategoryId(), PDO::PARAM_STR);
        
        if (!$st->execute()) {
var_dump($this->getCategoryId(), $st->queryString);
            die('Не удалось выполнить запрос на получение списка вопросов!');
        }
        
        $result['body'] = [];
        while ($row = $st->fetch(PDO::FETCH_ASSOC)){
            $result['body'][] = ['data' => $row];
        }
            
        return $result;

    }
    

}
