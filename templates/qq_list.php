<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of admin_desktop
 *
 * @author Илья
 */
class Qq_list
{
    private $templateName = "qq_list";

    
    function GenArray(){
        
        $result['data'] = Question::qqListWithAnswers();
        
        return $result;
    }
    
}
