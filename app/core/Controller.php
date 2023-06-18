<?php

class Controller
{
    protected function checkLoggedIn(){
        $allowed_routes = ['login', 'register'];

        if (!isset($_SESSION['user_id']) && !in_array($_GET['url'], $allowed_routes)) { //question mark
            header('Location: /login');
            exit;
        }
    }


    protected function model($model){
        require_once 'app/models/' . $model . '.php';
        return new $model();
    }

    protected function view($view, $data = []){
        require_once 'app/views/' . $view . '.php';
    }
} 