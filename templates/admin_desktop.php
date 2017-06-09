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
class admin_desktop
{
    private $templateName = "admin_desktop";

    function GenArray($mode = NULL)
    {
        if ($this->templateName == "admin_desktop"){
            
            if (!isset($mode)){
                $mode = "users";
            }
            
            if ($mode === "qq_categories"){
                $result = [
                    'title' => "Список тем"
                    , 'sidebar' => [
                        "Создать новую категорию"
                    ]
                    , 'data' => Category::fullList()
                ];
                
            }elseif ($mode === "users"){
                
                $result = $this->genArrayUsers();
                
                //$result['table']['data'] = Preporator::addHrefColumn($result['table']['data']
                  //      , "router.php?params=show_user_edit_form:", "id", "изменить");
                
            }
        }
        return $result;
    }
    
    private function genArrayUsers()
    {
        $user = new User();
                
        $result = [
            'title' => "Пользователи",
            'sidebar' => [
                            [
                                'itemText' => "Создать",
                                'itemHref' => "router.php?params=show_user_create_form"
                            ],
                            [
                                'itemText' => "Отчеты",
                                'itemHref' => "#"
                            ]
            ],
            'table' => $user->fullList(),
        ];

        $array = $result['table']['data'];
        
        $result['table']['data'] = array();
        
        foreach ($array as $key => $row){

            $result['table']['data'][$key]['hrefPasswordChange'] = "router.php?params=show_user_password_change_form:" . $row['id'];
            $result['table']['data'][$key]['hrefUserDel'] = "router.php?params=show_user_del_form:" . $row['id'];

            foreach ($row as $fieldKey => $value){
                $result['table']['data'][$key][$fieldKey] =  htmlspecialchars($value);
            }
        }
        
        return $result;
    }
    
}
