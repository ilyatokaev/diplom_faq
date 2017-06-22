<?php
/**
 * Description of Autoloader
 *
 * @author Илья
 */
class AutoloaderFaq
{
    public static function loadClass($className)
    {
        if (file_exists('Classes/' . $className . '.php')){
            $required = 'Classes/' . $className . '.php';
        } elseif (file_exists('model/' . $className . '.php')){
            $required = 'model/' . $className . '.php';
        } elseif (file_exists('Controller/' . $className . '.php')){
            $required = 'Controller/' . $className . '.php';
        } elseif (file_exists('templates/' . $className . '.php')){
            $required = 'templates/' . $className . '.php';
        } else {
            die('Неизвестный класс ' . $className);
        }

        require_once $required;
    }
}
