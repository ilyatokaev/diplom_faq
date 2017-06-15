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

    //function GenArray($mode = NULL, $params = NULL)
    function GenArray($params = [])
    {
        
        if ($this->templateName == "admin_desktop"){
            
            if (!isset($params[1])){
                $mode = "users";
            } else {
                $mode = $params[1];
            }
            
            if ($mode === "qq_categories"){
                $result = $this->genArrayCategories();
                
            }elseif ($mode === "users"){
                $result = $this->genArrayUsers();
                
            }elseif ($mode === "qq"){
                $currentCategoryId = $params[2];
                $result = $this->genArrayQQ($currentCategoryId);
            
            }elseif ($mode === "answers"){
                $currentQuestionId = $params[2];
                $result = $this->genArrayAnswers($currentQuestionId);
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
                            ]
            ],
            'table' => $user->fullList(),
        ];

        foreach ($result['table']['body'] as $key => $row){
                $result['table']['body'][$key]['actions'] = [
                                                              [
                                                                'title' => "Изменить пароль",
                                                                'href' => "router.php?params=show_user_password_change_form:" . $row['data']['id']
                                                              ],
                                                              [
                                                                'title' => "Удалить пользователя",
                                                                'href' => "router.php?params=show_user_del_form:" . $row['data']['id']
                                                              ]
                                                            ];

            foreach ($row['data'] as $fieldKey => $value){
                $result['table']['body'][$key]['data'][$fieldKey] =  htmlspecialchars($value);
            }
        }
        
        return $result;
    }
    
    private function genArrayCategories()
    {
        $category = new Category();
                
        $result = [
            'title' => "Темы",
            'sidebar' => [
                            [
                                'itemText' => "Создать",
                                'itemHref' => "router.php?params=show_category_create_form"
                            ]
            ],
            'table' => $category->fullList(),
        ];

        foreach ($result['table']['body'] as $key => $row){
                $result['table']['body'][$key]['actions'] = [
                                                              [
                                                                'title' => "Вопросоы",
                                                                'href' => "router.php?params=show_admin_desktop:qq:" . $row['data']['id']
                                                              ],
                                                              [
                                                                'title' => "Удалить",
                                                                'href' => "router.php?params=show_category_del_form:" . $row['data']['id']
                                                              ]
                                                            ];

            foreach ($row['data'] as $fieldKey => $value){
                $result['table']['body'][$key]['data'][$fieldKey] =  htmlspecialchars($value);
            }
        }
        
        return $result;
        
        
    }


    private function genArrayQQ($categoryId)
    {
        
        $question = new Question();
        $question->setCategoryId($categoryId);
        
        $category = new Category();
        $category->setId($categoryId);
                
        $result = [
            'title' => "Вопросы по теме - " . $category->getCode(),
            'sidebar' => [
            ],
            'table' => $question->listOneCategory(),
        ];

        foreach ($result['table']['body'] as $key => $row){
                $result['table']['body'][$key]['actions'] = [
                                                              [
                                                                'title' => ($row['data']['code'] === "HIDDEN") ? "Опубликовать" : "Скрыть",
                                                                'href' => "router.php?params=show_question_status_invers_action:" . $row['data']['id']
                                                              ],
                                                              [
                                                                'title' => "Удалить",
                                                                'href' => "router.php?params=show_category_del_form:" . $row['data']['id']
                                                              ],
                                                              [
                                                                'title' => "Редактировать вопрос",
                                                                'href' => "router.php?params=show_category_del_form:" . $row['data']['id']
                                                              ],
                                                              [
                                                                'title' => "Ответы",
                                                                'href' => "router.php?params=show_admin_desktop:answers:" . $row['data']['id']
                                                              ]
                                                            ];


            foreach ($row['data'] as $fieldKey => $value){
                $result['table']['body'][$key]['data'][$fieldKey] =  htmlspecialchars($value);
            }
        }
        
        return $result;
        
        
    }

    private function genArrayAnswers($questionId)
    {
        
        $answer = new Answer();
        $answer->setQuestionId($questionId);
        
        $question = new Question();
        $question->setId($questionId);
                
        $result = [
            'title' => "Ответы на вопрос - " . $question->getText(),
            'sidebar' => [
                            [
                                'itemText' => "Создать",
                                'itemHref' => "router.php?params=show_answer_create_form:" . $questionId
                            ]
            ],

            'table' => $answer->getList(),
        ];

        foreach ($result['table']['body'] as $key => $row){
                $result['table']['body'][$key]['actions'] = [
                                                              [
                                                                'title' => "Редактировать ответ",
                                                                'href' => "router.php?params=show_category_del_form:" . $row['data']['id']
                                                              ],
                                                              [
                                                                'title' => "Удалить",
                                                                'href' => "router.php?params=show_category_del_form:" . $row['data']['id']
                                                              ]
                                                            ];


            foreach ($row['data'] as $fieldKey => $value){
                $result['table']['body'][$key]['data'][$fieldKey] =  htmlspecialchars($value);
            }
        }
        
        return $result;
        
        
    }

    
}
