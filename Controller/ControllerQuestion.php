<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ControllerQuestion
 *
 * @author Илья
 */
class ControllerQuestion
{
      
    private $params;
    
    public function __construct($params)
    {
        $this->setParams($params);
    }
    
    private function setParams($params)
    {
        $this->params = $params;
    }
    
    private function getParams()
    {
        return $this->params;
    }
    
    public function userList()
    {
        $clientView = new ClientView("qq_list");
        $clientView->show();
    }
    
    
    public function showCreateForm()
    {
        $clientView = new ClientView("question_create_form");
        $clientView->show();
    }

    
    public function create()
    {
        $question = new Question();
        $question->setText($this->getParams()['q_text']);
        $question->setAuthor($this->getParams()['author']);
        $question->setEmail($this->getParams()['email']);
        $question->setCategoryId($this->getParams()['id_category']);

        
        if ($question->create()){
            echo 'Вопрос создан и будет опубликован после модерации и появления ответов.';
            echo '<br><a href=router.php?params=Question_userList>Вернуться к спску вопросов</a>';
        }
        
    }
    
    public function statusInvers()
    {
        $id_q = $this->getParams()[1];

        $question = new Question();
        $question->setId($id_q);

        $statusId = $question->getStatusId();


        if ( (int)$statusId === 2){
            $result = $question->setStatusHidden();
        }elseif ((int)$statusId  === 3){
            $result = $question->setStatusPublic();
        } else {

            die('Неизвестный исходный статус вопроса!');
        }

        if ($result){
            header('Location: router.php?params=Admin_showDesktop:qq:' . $question->getCategoryId());
        }

    }
    
    
    public function showDelForm()
    {
        $questionId = $this->getParams()[1];
        
        $clientView = new ClientView("question_del_form", $questionId);
        $clientView->show();
    }
    
    
    public function delete()
    {
        $question = new Question();
        $question->setId($this->getParams()['id_q']);

        if ($question->delete()){
            header('Location: router.php?params=Admin_showDesktop:qq:' . $question->getCategoryId());
        }

    }

    
    public function showEditForm()
    {
        $questionId = $this->getParams()[1];
        
        $clientView = new ClientView("question_edit_form", $questionId);
        $clientView->show();
    }
    
    
    public function update()
    {
        $questionId = $this->getParams()['id_q'];
        


        $question = new Question();
        $question->setId($questionId);

        $oldCategoryId = $question->getCategoryId();
        
        $question->setCategoryId($this->getParams()['id_category']);
        $question->setText($this->getParams()['q_text']);
        $question->setAuthor($this->getParams()['author']);
        $question->setEmail($this->getParams()['email']);


        if ($question->update()){
            echo 'Вопрос изменен.';
            echo '<br><a href=router.php?params=Admin_showDesktop:qq:' . $oldCategoryId . '>Вернуться к спску вопросов</a>';

        }
        
        return true;

    }
    
    
    public function showWithoutAnswerDelForm()
    {
        $questionId = $this->getParams()[1];
        
        $clientView = new ClientView("question_without_answer_del_form", $questionId);
        $clientView->show();
    }
    
    
    public function withoutAnswerDelete()
    {
        $question = new Question();
        $question->setId($this->getParams()['id_q']);

        if ($question->delete()){
            header('Location: router.php?params=Admin_showDesktop:qq_without_answer');
        }
    }
    

    public function showWithoutAnswerEditForm()
    {
        $questionId = $this->getParams()[1];
        
        $clientView = new ClientView("question_without_answer_edit_form", $questionId);
        $clientView->show();
    }
    
    
    public function withoutAnswerUpdate()
    {
        $questionId = $this->getParams()['id_q'];
        

        $question = new Question();
        $question->setId($questionId);

        $oldCategoryId = $question->getCategoryId();
        
        $question->setCategoryId($this->getParams()['id_category']);
        $question->setText($this->getParams()['q_text']);
        $question->setAuthor($this->getParams()['author']);
        $question->setEmail($this->getParams()['email']);


        if ($question->update()){
            echo 'Вопрос изменен.';
            echo '<br><a href=router.php?params=Admin_showDesktop:qq_without_answer>Вернуться к спску вопросов</a>';

        }
        
        return true;

    }
}
