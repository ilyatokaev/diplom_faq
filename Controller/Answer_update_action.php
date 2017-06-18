<?php
//require_once 'start_init.php';
/**
 * Show_login_form Вызов формы авторизации
 *
 * @author Илья
 */
class Answer_update_action
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
        $answer = new Answer();
        $answer->setId($this->getParams()['id_answer']);
        $answer->setText($this->getParams()['a_text']);


        if ($answer->update()){
            header('Location: router.php?params=show_admin_desktop:answers:' . $answer->getQuestionId());

        }

    }
}
