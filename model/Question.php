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

            die('Не удалось выполнить запрос на получение списка вопросов!');
        }
        
        $result['body'] = [];
        while ($row = $st->fetch(PDO::FETCH_ASSOC)){
            $result['body'][] = ['data' => $row];
        }
            
        return $result;

    }
    
    static function qqListWithAnswers($id_category = NULL)
    {
        $sql = "SELECT q.create_date
                    , q.author
                    , c.code
                    , q.q_text
                FROM qq q
                    INNER JOIN categories c
                        ON q.id_category = c.id
                WHERE q.id IN (
                                SELECT a0.id_q
                                FROM ANSWERS a0
                              )
                ";
        if (isset($id_category)) {
            $sql = $sql . " AND q.id_category = :id_category";
        }
        
        if (!$st = Cfg::getDB()->prepare($sql)){
            die('Не удалось подготовить запрос на получение списка фопросов с ответами');
        }

        
        if (isset($id_category)) {
            $st->bindParam(':id_category', $id_category, PDO::PARAM_INT);
        }

        
        if (!$st->execute()){
            die('Не удалось выполнить запрос на получение списка вопросов с ответами');
        }
        
        
        $result = [];
        while ($row = $st->fetch(PDO::FETCH_ASSOC)){
            $result[] = $row;
        }
        
        foreach ($result as $key => $row){
            $result[$key]['answers'] = Answer::getList($result[$key]['id']);
        }
        
        return $result;

    }

    public function create()
    {
        $sql = "INSERT INTO qq (id_category, create_date, q_text, author, email, id_status)
                    VALUES (:id_category, :create_date, :q_text, :author, :email, :id_status)
               ";
        
        $db = Cfg::getDB();
        
        if (!$st = $db->prepare($sql)){
            die('Не удалось подготовить запрос на создание вопроса!');
        }

        $st->bindParam(':id_category', $_POST['id_category'], PDO::PARAM_INT);
        $st->bindParam(':create_date', date(DATE_ATOM), PDO::PARAM_STR); 
        $st->bindParam(':q_text', $_POST['q_text'], PDO::PARAM_STR);
        $st->bindParam(':author', $_POST['author'], PDO::PARAM_STR);
        $st->bindParam(':email', $_POST['email'], PDO::PARAM_STR);
        $st->bindParam(':id_status', "2", PDO::PARAM_INT);
        
        if (!$st->execute()) {
            die('Не удалось выполнить запрос на создание вопроса!');
        }
        
        return $db->lastInsertId();
        
    }
    
}
