<?php
/**
 * Description of Cfg
 *
 * @author Илья
 */
class Cfg
{

    static function getDB()
    {
        $conn = new PDO(???????????????????????????????);
        return $conn;
    }
    
    static function getCurrentRoles()
    {
        return $_SESSION['roles'];
    }
    
    
    static function setCurrentRoles($roles)
    {
        $_SESSION['roles'];
    }
    
    
    static function getCurrentUserId()
    {
        return $_SESSION['userId'];
    }
    
    
}
