<?php
/**
 * Description of ControllerUser
 *
 * @author Илья
 */
class ControllerUser
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
    
    public function showLoginForm()
    {
        $clientView = new ClientView("login");
        $clientView->show();
    }
    
    
    public function login()
    {

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
             header('Location: router.php?params=Admin_showDesktop:users');

         } else {
            $clientView = new ClientView("login_failed");
            $clientView->show();

             //echo $twig->render('login_failed.twig');
         }
    }
    
    public function showPasswordChangeForm()
    {

        $user_id = $this->getParams()[1];

        $clientView = new ClientView("user_password_change_form", $user_id);
        $clientView->show();

    }
    
    public function passwordChange()
    {

        $user_id = $this->getParams()['user_id'];
        $newPassword = $this->getParams()['newPassword'];

        $user = new User();
        $user->setId($user_id);

        if ($user->setPassword($newPassword)){
            echo 'Пароль изменен.';
        }else{
            echo 'Не удалось изменить пароль!';
        }

        echo '<br><a href=router.php?params=Admin_showDesktop:users>Вернуться к спску пользователей</a>';

    }
    
    
    public function showDelForm()
    {
        $userId = $this->getParams()[1];

        $clientView = new ClientView("user_del_form", $userId);
        $clientView->show();
    }
    
    public function delete()
    {

        $user = new User;
        $user->setId($this->getParams()['user_id']);

        if ($user->delete()){
            header('Location: router.php?params=Admin_showDesktop:users');
        }
    }
    
    
    public function create()
    {

        $login = $this->getParams()['login'];
        $password = $this->getParams()['password'];
        $description = $this->getParams()['description'];

        $user = new User();


        if ($user->findLogin($login)){
            echo 'Пользователь с таким Логином уже существует!';
        }elseif ($user->create($login, $password, $description)){
            echo 'Пользователь создан';
        } else {
            echo 'Не удалось создать пользователя';
        }

        if (!$user->addRole('Admin')){
            die('Не удалось добавить роль пользователю!');
        }
        echo '<br><a href=router.php?params=Admin_showDesktop:users>Вернуться к списку пользователей</a>';


    }
    
    
    public function showCreateForm()
    {
        
        $clientView = new ClientView("user_create");
        $clientView->show();

    }
}
