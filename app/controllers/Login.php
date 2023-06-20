<?php

class Login extends Controller
{
    public function __construct(){
        $this->checkLoggedIn();
    }
    
    public function index(){
        $this->view('login/index');
    }

    public function loginUser(){
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $login = $_POST['login'];
            $password = $_POST['password'];
    
            // Input validation (as an example)
            if (empty($login) || empty($password)) {
                echo('Please fill in all fields');
                return;
            }
    
            $user = User::where('login', $login)->first();
            if ($user && password_verify($password, $user->password)) {
                $_SESSION['user_id'] = $user->id;
                echo('Logged in: ' . $login);
            } else {
                echo('Incorrect login or password');
            }
        }
    }
    
}
