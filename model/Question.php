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
    private $statusId;
    
    public function setId($id)
    {
        $this->id = $id;
        
        $sql = "SELECT q_text, id_status, id_category, author, email FROM qq WHERE id = :id";
        
        if (!$st = Cfg::getDB()->prepare($sql)){
            die('Не удалось подготовить запрос на получения Вопроса!');
        }
        
        $st->bindParam(':id', $this->id, PDO::PARAM_INT);

        if (!$st->execute()){
            die('Не удалось выполнить запрос на получения Вопроса!');
        }
        
        if (!$row = $st->fetch(PDO::FETCH_ASSOC)){

            die(__CLASS__ . ' Не удалось найти вопрос по Id!');
        }
        
        $this->setText($row['q_text']);
        $this->setStatusId($row['id_status']);
        $this->setCategoryId($row['id_category']);
        $this->setAuthor($row['author']);
        $this->setEmail($row['email']);

    }
    
    public function getId()
    {
        return $this->id;
    }
    
    private function setStatusId($statusId)
    {
        $this->statusId = $statusId;
    }

    public function getStatusId()
    {
        return $this->statusId;
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
    
        $sql = "SELECT q.id
                    , q.create_date
                    , q.q_text
                    , q.author
                    , q.email
                    , IFNULL(a.answers_quantity, 'Ожидает ответа')
                    , s.code
                    
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
        
        $result['header'] = ["id", "Дата создания", "Вопрос", "Автор", "E-mail", "Ответов", "Статус"];
        
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
    
public function listWithoutAnswer()
    {
    
        $sql = "SELECT q.id
                    , q.create_date
                    , c.code category
                    , q.q_text
                    , q.author
                    , q.email
                    , s.code status
                FROM qq q
                    INNER JOIN qq_statuses s ON q.id_status = s.id
                    INNER JOIN categories c ON q.id_category = c.id
                WHERE q.id NOT IN (
                                    SELECT a0.id_q
                                    FROM answers a0
                                  )
                ";
        
        $result['header'] = ["id", "Дата создания", "Тема", "Вопрос", "Автор", "E-mail", "Статус"];
        
        if (!$st = Cfg::getDB()->prepare($sql)){
            die('Не удалось подготовить запрос на получение списка вопросов без ответов!');
        }

        if (!$st->execute()) {

            die('Не удалось выполнить запрос на получение списка вопросов без ответов!');
        }
        
        $result['body'] = [];
        while ($row = $st->fetch(PDO::FETCH_ASSOC)){
            $result['body'][] = ['data' => $row];
        }
            
        return $result;

    }
    
    static function qqListWithAnswers($id_category = NULL)
    {
        $sql = "SELECT q.id
                    , q.create_date date
                    , q.author
                    , c.code category
                    , q.q_text text
                FROM qq q
                    INNER JOIN categories c
                        ON q.id_category = c.id
                WHERE q.id IN (
                                SELECT a0.id_q
                                FROM answers a0
                              ) 
                      AND q.id_status <> 3
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
        
        
        //$result = [];
        $result = $st->fetchAll(PDO::FETCH_ASSOC);
        /*while ($row = $st->fetch(PDO::FETCH_ASSOC)){
            $result[] = $row;
        }*/
        
        foreach ($result as $key => $row){
            $answer = new Answer();
            $answer->setQuestionId($result[$key]['id']);
            $result[$key]['answers'] = $answer->getSimpleList();
        }
        
        return $result;

    }

    public function create()
    {
        $sql = "INSERT INTO qq (id_category, create_date, q_text, author, email)
                    VALUES (:id_category, :create_date, :q_text, :author, :email)
               ";
        
        $db = Cfg::getDB();
        
        if (!$st = $db->prepare($sql)){
            die('Не удалось подготовить запрос на создание вопроса!');
        }

        /*$st->bindParam(':id_category', $_POST['id_category'], PDO::PARAM_INT);
        $st->bindParam(':create_date', date(DATE_ATOM), PDO::PARAM_STR); 
        $st->bindParam(':q_text', $_POST['q_text'], PDO::PARAM_STR);
        $st->bindParam(':author', $_POST['author'], PDO::PARAM_STR);
        $st->bindParam(':email', $_POST['email'], PDO::PARAM_STR);*/

        $st->bindParam(':id_category', $this->getCategoryId(), PDO::PARAM_INT);
        $st->bindParam(':create_date', date(DATE_ATOM), PDO::PARAM_STR); 
        $st->bindParam(':q_text', $this->getText(), PDO::PARAM_STR);
        $st->bindParam(':author', $this->author, PDO::PARAM_STR);
        $st->bindParam(':email', $this->getEmail(), PDO::PARAM_STR);

        
        if (!$st->execute()) {
            die('Не удалось выполнить запрос на создание вопроса!');
        }
        
        return $db->lastInsertId();
        
    }
    
    public function setStatusPublic()
    {
        
        $sql = "UPDATE qq SET id_status = 2 WHERE id = :id";
        
        $db = Cfg::getDB();
        
        if (!$st = $db->prepare($sql)){
            die('Не удалось подготовить запрос на публикацию вопроса!');
        }
        
        $st->bindParam(':id', $this->getId(), PDO::PARAM_INT);
        
        if (!$st->execute()) {
            die('Не удалось выполнить запрос на публикацию вопроса!');
        }
        
        return TRUE;

        
    }


    public function setStatusHidden()
    {
        
        $sql = "UPDATE qq SET id_status = 3 WHERE id = :id";
        
        $db = Cfg::getDB();
        
        if (!$st = $db->prepare($sql)){
            die('Не удалось подготовить запрос на скрытие вопроса!');
        }
        
        $st->bindParam(':id', $this->getId(), PDO::PARAM_INT);
        
        if (!$st->execute()) {
            die('Не удалось выполнить запрос на скрытие вопроса!');
        }
        
        return TRUE;

        
    }
    
    public function delete()
    {
        
        $sql = "DELETE FROM qq WHERE id = :id";
        
        $db = Cfg::getDB();
        
        if (!$st = $db->prepare($sql)){
            die('Не удалось подготовить запрос на удаление вопроса!');
        }
        
        $st->bindParam(':id', $this->getId(), PDO::PARAM_INT);
        
        if (!$st->execute()) {
            die('Не удалось выполнить запрос на удаление вопроса! Возможно причина в том, что в вопросе содержатся ответы!');
        }
        
        return TRUE;

        
    }

    public function update()
    {
        $sql = "UPDATE qq  SET id_category = :id_category
                            , create_date = :create_date
                            , q_text = :q_text
                            , author = :author
                            , email = :email
                WHERE id = :id            
                ";
        
        $db = Cfg::getDB();
        
        if (!$st = $db->prepare($sql)){
            die('Не удалось подготовить запрос на создание вопроса!');
        }

        /*$st->bindParam(':id_category', $_POST['id_category'], PDO::PARAM_INT);
        $st->bindParam(':create_date', date(DATE_ATOM), PDO::PARAM_STR); 
        $st->bindParam(':q_text', $_POST['q_text'], PDO::PARAM_STR);
        $st->bindParam(':author', $_POST['author'], PDO::PARAM_STR);
        $st->bindParam(':email', $_POST['email'], PDO::PARAM_STR);
        $st->bindParam(':id', $_POST['id_q'], PDO::PARAM_INT);*/
        
        $st->bindParam(':id_category', $this->getCategoryId(), PDO::PARAM_INT);
        $st->bindParam(':create_date', date(DATE_ATOM), PDO::PARAM_STR); 
        $st->bindParam(':q_text', $this->getText(), PDO::PARAM_STR);
        $st->bindParam(':author', $this->getAuthor(), PDO::PARAM_STR);
        $st->bindParam(':email', $this->getEmail(), PDO::PARAM_STR);
        $st->bindParam(':id', $this->getId(), PDO::PARAM_INT);        

        
        if (!$st->execute()) {
            die('Не удалось выполнить запрос на создание вопроса!');
        }
        
        return true;
        
    }
    
}
