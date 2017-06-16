<?php
//require_once 'start_init.php';
/**
 * Show_login_form Вызов формы авторизации
 *
 * @author Илья
 */
class Login_action
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
        global $twig;


        $login = $this->getParams()['login'];
        $password = $this->getParams()['password'];

         $user = new User();

         if ($user->login($login, $password)){
             $_SESSION['userId'] = $user->getId();
             $_SESSION['userLogin'] = $user->getLogin();
             $_SESSION['userDescription'] = $user->getDescription();
             $_SESSION['roles'] = $user->getRolesString();
             //echo $twig->render('admin_desktop.twig');
             
             /*$clientView = new ClientView("admin_desktop", ["", "users"]);
             $clientView->show();*/
             header('Location: router.php?params=show_admin_desktop:users');

         } else {

             echo $twig->render('login_failed.twig');
         }
        
    }
}
