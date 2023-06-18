<?php

class Controller
{
    protected function checkLoggedIn(){
        if (!isset($_SESSION['user_id'])) {
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