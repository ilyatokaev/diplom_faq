<?php
//require_once 'start_init.php';
/**
 * Show_login_form Вызов формы авторизации
 *
 * @author Илья
 */
class Question_without_answer_del_action
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
        $question->setId($this->getParams()['id_q']);

        if ($question->delete()){
            header('Location: router.php?params=show_admin_desktop:qq_without_answer');
        }

    }
}
