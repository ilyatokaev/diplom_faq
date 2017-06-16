<?php
//require_once 'start_init.php';
/**
 * Show_login_form Вызов формы авторизации
 *
 * @author Илья
 */
class Question_create_action
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

        $question = new Question();
        $question->setText($this->getParams()['q_text']);
        $question->setAuthor($this->getParams()['author']);
        $question->setEmail($this->getParams()['email']);

        if ($question->create()){
            echo 'Вопрос создан и будетопублекован после модерации и появления ответов.';
            echo '<br><a href=router.php?params=show_qq_list>Вернуться к спску вопросов</a>';

        }
    }
}
