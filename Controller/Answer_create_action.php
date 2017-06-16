<?php
//require_once 'start_init.php';
/**
 * Show_login_form Вызов формы авторизации
 *
 * @author Илья
 */
class Answer_create_action
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
        $answer->setQuestionId($this->getParams()['id_q']);
        $answer->setText($this->getParams()['a_text']);
        $answer->setIdAuthor($this->getParams()['id_author']);


        if ($answer->create()){

            header('Location: router.php?params=show_admin_desktop:answers:' . $answer->getQuestionId());
            /*$clientView = new ClientView("admin_desktop", [NULL, "answers", $answer->getQuestionId()]);
            $clientView->show();*/
        }

    }
}
