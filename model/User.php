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
        $this->db = new PDO("mysql:host=localhost;dbname=diplom;charset=UTF8", "faqclient", "pin12cher28");

        $sql = "SELECT 1 FROM users";

        if (!$st = $this->db->prepare($sql)){
            die("Не удалось подготовить запрос на проверку наличия пользователей!");
        }

        if (!$st->execute()){
            die("Не удалось выполнить запрос на проверку наличия пользователей!");
        }

        if (!$st->fetch()){
            $sql = "INSERT INTO users (login, description, password_hash) VALUES ('admin', 'Админ поумолчанию', :password_hash)";

            if (!$st = $this->db->prepare($sql)){
                die("Не удалось подготовить запрос на создание админа поумолчанию!");
            }

            $st->bindParam(":password_hash", $this->password_hash('admin', 'admin'), PDO::PARAM_STR);
            
            if (!$st->execute()){
                die("Не удалось выполнить запрос на создание админа поумолчанию!");
            }
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
            $sql = "SELECT 1 FROM users WHERE login = :login";

            if (!$st = $this->db->prepare($sql)){
                die("Не удалось подготовить запрос на поиск пользователя!");
            }
            
            $st->bindParam(":login", $login, PDO::PARAM_STR);
            
            if (!$st->execute()){
                die("Не удалось выполнить запрос на поиск пользователя!");
            }

            if ($st->fetch()){
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
    public function create($login, $password, $desription = NULL)
    {
            $sql = "INSERT INTO users (login, password_hash, description) VALUES(:login, :password_hash, :description";

            if (!$st = $this->db->prepare($sql)){
                die("Не удалось подготовить запрос на создание пользователя!");
            }
            
            $st->bindParam(":login", $login, PDO::PARAM_STR);
            $st->bindParam(":password_hash", $this->password_hash($login, $password), PDO::PARAM_STR);
            $st->bindParam(":description", $description, PDO::PARAM_STR);
            
            return $st->execute();

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
    public function delete($id)
    {
            $sql = "DELETE FROM users WHERE id = :id";

            if (!$st = $this->db->prepare($sql)){
                die("Не удалось подготовить запрос на удвление пользователя!");
            }
            
            $st->bindParam(":id", $id, PDO::PARAM_INT);
            
            return $st->execute();

    }

    
    /*******************
     * update($description)
     * Обновляет пользователя
     * 
     * Входящие параметры:
     *                      $id - Удаляемого пользователя
     * 
     * Возвращаемое значение :
     *                         TRUE - если пользователь удачно удален
     *                         FALSE - в случае, если удалить не удалось
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
     * fullList($description)
     * Возвращает полный список всех пользователей
     * 
     * Возвращаемое значение : array
     */
    public function fullList()
    {
            $sql = "SELECT id, login, description FROM users";

            if (!$st = $this->db->prepare($sql)){
                die("Не удалось подготовить запрос на получение списка пользователей!");
            }
            
            $st->bindParam(":id", $id, PDO::PARAM_INT);
            $st->bindParam(":description", $description, PDO::PARAM_STR);
            
            if (!$st->execute()){
                die("Не удалось подготовить запрос на получение списка пользователей!");
            }
            
            $resultList = array();
            
            while ($row = $st->fetch(PDO::FETCH_ASSOC)){
                $row['roles'] = $this->getRolesString($row['id']);
                $resultList[] = $row;
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
            $sql = "SELECT 1 FROM users WHERE login = :login AND password_hash = :password_hash";

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
    public function getRoles($id)
    {
        $sql = "SELECT r.id r.code 
                FROM roles r
                    INNER JOIN (
                                SELECT id_role 
                                FROM lnk_users_roles 
                                WHERE id_user = :id_user
                               ) l 
                          ON r.id = l.id_role";

        if (!$st = $this->db->prepare($sql)){
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
    public function getRolesString($id)
    {
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
    
}
