<?php
/**
 * Description of ControllerUser
 *
 * @author Илья
 */
class ControllerAnswer
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

    
    public function showCreateForm()
    {
        $questionId = $this->getParams()[1];
        
        $clientView = new ClientView("answer_create_form", $questionId);
        $clientView->show();
    }
    
    
    public function create()
    {

         $answer = new Answer();
         $answer->setQuestionId($this->getParams()['id_q']);
         $answer->setText($this->getParams()['a_text']);
         $answer->setIdAuthor($this->getParams()['id_author']);


         if ($answer->create()){

             header('Location: router.php?params=Admin_showDesktop:answers:' . $answer->getQuestionId());
         }

     }
     
     
     public function showEditForm()
     {
        $answerId = $this->getParams()[1];
        
        $clientView = new ClientView("answer_edit_form", $answerId);
        $clientView->show();
     }
     
     
     public function update()
     {
        $answer = new Answer();
        $answer->setId($this->getParams()['id_answer']);
        $answer->setText($this->getParams()['a_text']);


        if ($answer->update()){
            header('Location: router.php?params=Admin_showDesktop:answers:' . $answer->getQuestionId());

        }
     }
     
     
     public function showDelForm()
     {
        $answerId = $this->getParams()[1];
        
        $clientView = new ClientView("answer_del_form", $answerId);
        $clientView->show();
     }
     
     
     public function delete()
     {
        $answer = new Answer();
        $answer->setId($this->getParams()['id_answer']);


        if ($answer->delete()){
            header('Location: router.php?params=Admin_showDesktop:answers:' . $answer->getQuestionId());

        }
     }
     
}
