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
    
    public function createMsg($status, $message){
        $response['status'] = $status;
        $response['message'] = $message;
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode($response);
        exit;
    }
    
    protected function model($model){
        require_once 'app/models/' . $model . '.php';
        return new $model();
    }
    
    protected function view($view, $data = []){
        ob_start();
        require_once 'app/views/' . $view . '.php';
        $output = ob_get_clean();

        ob_start();
        require_once 'app/views/partials/jslinks.php';
        $scripts = ob_get_clean();

        ob_start();
        require_once 'app/views/partials/navbar.php';
        $navbar = ob_get_clean();

        if (strpos($output, '<!--NAVBAR_PLACEHOLDER-->') !== false) {
            $output = str_replace('<!--NAVBAR_PLACEHOLDER-->', $navbar, $output);
        }
    
        if (strpos($output, '<!--SCRIPTS_PLACEHOLDER-->') !== false) {
            $output = str_replace('<!--SCRIPTS_PLACEHOLDER-->', $scripts, $output);
        }

        echo $output;
    }
} 