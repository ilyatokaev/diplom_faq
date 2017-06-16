<?php
//require_once 'start_init.php';
/**
 * Show_login_form Вызов формы авторизации
 *
 * @author Илья
 */
class Show_question_status_invers_action
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
            header('Location: router.php?params=show_admin_desktop:qq:' . $question->getCategoryId());
            /*$clientView = new ClientView("admin_desktop", [NULL, "qq", $question->getCategoryId()]);
            $clientView->show();*/
        }

    }
}
