<?php
/**
 * Description of User
 *
 * @author Илья
 */
class User
{
    private $id;
    private $login;
    private $description;
    private $db;
    
    //public function __construct($db)
    public function __construct()
    {
        //$this->db = $db;
        //$this->db = new PDO("mysql:host=localhost;dbname=diplom;charset=UTF8", "faqclient", "pin12cher28");
        
        $this->db = Cfg::getDB();

        $sql = "SELECT 1 FROM users";

        if (!$st = $this->db->prepare($sql)){
            die("Не удалось подготовить запрос на проверку наличия пользователей!");
        }

        if (!$st->execute()){
            die("Не удалось выполнить запрос на проверку наличия пользователей!");
        }

        if (!$st->fetch()){
            //$sql = "INSERT INTO users (login, description, password_hash) VALUES ('admin', 'Админ поумолчанию', :password_hash)";
            $this->create("admin", "admin", "Админ поумолчанию");
            
            if (!$this->addRole('Admin')){
                die('Не удалось добавить роль пользователю!');
            }

            /*if (!$st = $this->db->prepare($sql)){
                die("Не удалось подготовить запрос на создание админа поумолчанию!");
            }

            $st->bindParam(":password_hash", $this->password_hash('admin', 'admin'), PDO::PARAM_STR);
            
            if (!$st->execute()){
                die("Не удалось выполнить запрос на создание админа поумолчанию!");
            }*/
        }

    }

    
    /*******************
     * findLogin($login)
     * Проверяет надичие пользователя с указанным логином
     * 
     * Входящие параметры:
     *                      $login - Логин пользователя
     * 
     * Возвращаемое значение bool:
     *                              TRUE - если пользователь с таким логином существует
     *                              FALSE - в противном случае
     */
    public function findLogin($login)
    {
            $sql = "SELECT id FROM users WHERE login = :login";

            if (!$st = $this->db->prepare($sql)){
                die("Не удалось подготовить запрос на поиск пользователя!");
            }
            
            $st->bindParam(":login", $login, PDO::PARAM_STR);
            
            if (!$st->execute()){
                die("Не удалось выполнить запрос на поиск пользователя!");
            }

            if ($row = $st->fetch()){

                $this->setId($row['id']);
                return TRUE;
            }

            return FALSE;
    }

    
    /*******************
     * create($login, $password, $desription = NULL)
     * Создает пользователя
     * 
     * Входящие параметры:
     *                      $login - Логин пользователя
     *                      ;password - Пароль пользователя
     * 
     * Возвращаемое значение :
     *                         TRUE - если пользователь удачно создан
     *                         FALSE - в случае, если создать не удалось
     */
    public function create($login, $password, $description = NULL)
    {
            $sql = "INSERT INTO users (login, password_hash, description) VALUES(:login, :password_hash, :description)";

            if (!$st = $this->db->prepare($sql)){
                die("Не удалось подготовить запрос на создание пользователя!");
            }
            
            $st->bindParam(":login", $login, PDO::PARAM_STR);
            $st->bindParam(":password_hash", $this->password_hash($login, $password), PDO::PARAM_STR);
            $st->bindParam(":description", $description, PDO::PARAM_STR);

            if (!$st->execute()){
                die('Не удалось выполнить запрос на создание пользователя!"');
            }
            
            $result = $this->findLogin($login);
            
            
            return $result;

    }

    
    /*******************
     * delete($id)
     * Удаляет пользователя
     * 
     * Входящие параметры:
     *                      $id - Удаляемого пользователя
     * 
     * Возвращаемое значение :
     *                         TRUE - если пользователь удачно удален
     *                         FALSE - в случае, если удалить не удалось
     */
    public function delete($id = NULL)
    {

            if (!isset($id)){
                $id = $this->getId();
            }
            
            $db = Cfg::getDB();
            
            $db->beginTransaction();
            
            $this->deleteAllRoles();
            
            $sql = "DELETE FROM users WHERE id = :id";

            if (!$st = $this->db->prepare($sql)){
                //$db->rollBack();
                $db->rollBack();
                die("Не удалось подготовить запрос на удаление пользователя!");
            }
            
            $st->bindParam(":id", $id, PDO::PARAM_INT);
            $result = $st->execute();
            
            if (!$result){
var_dump($st->queryString);
                $db->rollBack();
                die("Не удалось выполнить запрос на удаление пользователя!");
            }
            
            $db->commit();
            
            return $result;

    }

     /*******************
     * deleteAllRoles($id)
     * Удаляет пользователя
     * 
     * Входящие параметры:
     *                      $id - Удаляемого пользователя
     * 
     * Возвращаемое значение :
     *                         TRUE - если пользователь удачно удален
     *                         FALSE - в случае, если удалить не удалось
     */
    private function deleteAllRoles()
    {
            $sql = "DELETE FROM lnk_users_roles WHERE id_user = :id";

            if (!$st = $this->db->prepare($sql)){
                die("Не удалось подготовить запрос на удвление всех ролий пользователя!");
            }
            
            $st->bindParam(":id", $this->getId(), PDO::PARAM_INT);
            
            $result = $st->execute();
            
            if (!$result){
                die("Не удалось выполнить запрос на удвление всех ролий пользователя!");
            }
            
            return $result;

    }
    
    /*******************
     * update($id, $description)
     * Обновляет пользователя
     * 
     * Входящие параметры:
     *                      $id - Удаляемого пользователя
     *                      $description - новое описание
     * 
     * Возвращаемое значение :
     *                         BOOL - по результату операции
     */
    public function update($id, $desription = NULL)
    {
            $sql = "UPDATE users SET description = :description WHERE id = :id";

            if (!$st = $this->db->prepare($sql)){
                die("Не удалось подготовить запрос на обновление пользователя!");
            }
            
            $st->bindParam(":id", $id, PDO::PARAM_INT);
            $st->bindParam(":description", $description, PDO::PARAM_STR);
            
            return $st->execute();

    }

    
    /*******************
     * fullList()
     * Возвращает полный список всех пользователей
     * 
     * Возвращаемое значение : array
     */
    static function fullList()
    {
            $sql = "SELECT id, login, description FROM users";
            $resultList = array();
            $resultList['header'] = ['ID', 'Login', 'Описание', 'Роли'];

            //if (!$st = $this->db->prepare($sql)){
            if (!$st = Cfg::getDB()->prepare($sql)){
                die("Не удалось подготовить запрос на получение списка пользователей!");
            }
            
            /*$st->bindParam(":id", $id, PDO::PARAM_INT);
            $st->bindParam(":description", $description, PDO::PARAM_STR);*/
            
            if (!$st->execute()){
                die("Не удалось подготовить запрос на получение списка пользователей!");
            }
            
            
            while ($row = $st->fetch(PDO::FETCH_ASSOC)){
                $currentUser = new User();

                $row['roles'] = $currentUser->getRolesString($row['id']);
                $resultList['body'][] = ['data' => $row];
            }

            return $resultList;
    }
    
    
    /*******************
     * login($login, $password)
     * Авторизует пользователя, инициализирует его
     * 
     * Входящие параметры:
     *                      $id - ID пользователя
     * 
     */
    public function login($login, $password)
    {
            $sql = "SELECT id, login, description FROM users WHERE login = :login AND password_hash = :password_hash";

            if (!$st = $this->db->prepare($sql)){
                die("Не удалось подготовить запрос на поиск пользователя и пароля!");
            }
            
            $st->bindParam(":login", $login, PDO::PARAM_STR);
            $st->bindParam(":password_hash", $this->password_hash($login, $password), PDO::PARAM_STR);
            
            if (!$st->execute()){
                die("Не удалось выполнить запрос на поиск пользователя и пароля!");
            }
            
            if (!$row = $st->fetch(PDO::FETCH_ASSOC)){
                return FALSE;
            }

            $this->id = $row['id'];
            $this->login = $row['login'];
            $this->description = $row['description'];
            
            return TRUE;
            
    }


    /*******************
     * getRoles($id)
     * Получение ролей пользователя
     * 
     * Входящие параметры:
     *                      $id - ID пользователя
     * 
     * Возвращаемое значение :
     *                         Двумерный массив ролей пользователя: 
     *                                                              ['id'] - ID роли
     *                                                              ['code'] - символьный код роли
     * 
     *                         FALSE - в случае, если удалить не удалось
     */
    public function getRoles($id = NULL)
    {
        if (!isset($id)){
            $id = $this->getId();
        }
        
        $sql = "SELECT r.id, r.code 
                FROM roles r
                    INNER JOIN (
                                SELECT id_role 
                                FROM lnk_users_roles 
                                WHERE id_user = :id_user
                               ) l 
                          ON r.id = l.id_role";

        //if (!$st = $this->db->prepare($sql)){
        if (!$st = Cfg::getDB()->prepare($sql)){
            die("Не удалось подготовить запрос на получение ролей пользователя!");
        }

        $st->bindParam(":id_user", $id, PDO::PARAM_INT);
        

        if (!$st->execute()){
            die("Не удалось выполнить запрос на получение ролей пользователя!");
        }

        $roles = array();
        while ($row = $st->fetch(PDO::FETCH_ASSOC)){
            $roles[] = array('id'=>$row['id'], 'code'=>$row['code']);
        }

        return $roles;
        
    }

    
    /*******************
     * getRolesString($id)
     * Получение списка ролей пользователя в виде строки
     * 
     * Входящие параметры: $id - ID пользователя
     * 
     * Возвращаемое значение :
     *                         Строка ролей, разделенных слэшом и начинающаяся со слэша - если роли найдены
     * 
     *                         пустая строка - в случае, если роли не найдены
     */
    public function getRolesString($id = NULL)
    {
        
        
        if (!isset($id)){
            $id = $this->getId();
        }
 
        
        $resultString = "";
        
        foreach ($this->getRoles($id) as $role){
            $resultString = $resultString . "/" . $role['code'];
        }

        return $resultString;
    }

    public function getId()
    {
        return $this->id;
    }
    
    public function getLogin()
    {
        return $this->login;
    }
    
    public function getDescription()
    {
        return $this->description;
    }
    
    /*******************
     * password_hash($login, $password)
     * Генерит hash по логину и паролю
     * 
     * Входящие параметры:
     *                      $id - Удаляемого пользователя
     * 
     * Возвращаемое значение :
     *                         TRUE - если пользователь удачно удален
     *                         FALSE - в случае, если удалить не удалось
     */
    private function password_hash($login, $password)
    {
            return md5($login . "122876588" . $password);
    }


    /*******************
     * setPassword($id, $password)
     * Устанавливает пароль пользователя
     * 
     * Входящие параметры:
     *                      $id - Id пользователя
     *                      $password - новый пароль
     * 
     * Возвращаемое значение :
     *                         Bool по результатам операции
     */
    public function setPassword($password = NULL)
    {
            $sql = "UPDATE users SET password_hash = :password_hash WHERE id = :id";

            if (!$st = $this->db->prepare($sql)){
                die("Не удалось подготовить запрос на обновление пользователя!");
            }
            
            $st->bindParam(":id", $this->getId(), PDO::PARAM_INT);
            $st->bindParam(":password_hash", $this->password_hash($this->login, $password), PDO::PARAM_STR);
            
            return $st->execute();

    }

    public function addRole($roleCode)
    {
            $sql = "SELECT id FROM roles WHERE code = :roleCode";
            
            if (!$st = $this->db->prepare($sql)){
                die("Не удалось подготовить запрос на получение id роли!");
            }
            
            $st->bindParam(":roleCode", $roleCode, PDO::PARAM_STR);
            
            if (!$st->execute()){

                die("Не удалось выполнить запрос на получение id роли!");
            }
            
            if (!$row = $st->fetch()){
                die("В справочнике отсутствует роль " . $roleCode);
            }
                
            $id_role = $row['id'];
  
    
            $sql = "INSERT INTO lnk_users_roles (id_user, id_role) VALUES (:id_user, :id_role)";


            if (!$st = $this->db->prepare($sql)){
                die("Не удалось подготовить запрос на добавление роли пользователю!");
            }
            
            $st->bindParam(":id_user", $this->getId(), PDO::PARAM_INT);
            $st->bindParam(":id_role", $id_role, PDO::PARAM_STR);
            
            $result = $st->execute();
            
            if (!$result) {
                die("Не удалось выполнить запрос на добавление роли пользователю!");
            }
            
            return $result;

    }
    
    public function setId($user_id)
    {
        $sql = "SELECT id, login, description FROM users WHERE id = :user_id";

        if (!$st = $this->db->prepare($sql)){
            die("Не удалось подготовить запрос на поиск пользователя по id!");
        }

        $st->bindParam(":user_id", $user_id, PDO::PARAM_STR);

        if (!$st->execute()){

            die("Не удалось выполнить запрос на поиск пользователя по id!");
        }
        
        if (!$row = $st->fetch()){
            die("Не найден id пользователя в БД!");
        }

        $this->id = $user_id;
        $this->setLogin($row['login']);
        $this->setDescription($row['description']);
        
    }
    
    private function setLogin($login)
    {
        $this->login = $login;
    }
    
    private function setDescription($description)
    {
        $this->description = $description;
    }
    

    
}
