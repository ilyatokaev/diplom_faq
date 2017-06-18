<?php
//require_once 'start_init.php';
/**
 * Show_login_form Вызов формы авторизации
 *
 * @author Илья
 */
class Question_without_answer_update_action
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

    public function action()
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
            echo '<br><a href=router.php?params=show_admin_desktop:qq_without_answer>Вернуться к спску вопросов</a>';

        }
        
        return true;
    }
}
