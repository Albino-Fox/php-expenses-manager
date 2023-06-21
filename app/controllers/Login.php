<?php

class Login extends Controller
{
    public function index(){
        if(isset($_SESSION['user_id'])){
            $this->view('home/index');
            return;
        }
        $this->view('login/index');
    }

    public function loginUser(){
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $login = $_POST['login'];
            $password = $_POST['password'];
            
            if (empty($login) || empty($password)) {
                return $this->createMsg('error', 'Please fill in all fields');
            }
    
            $user = User::where('login', $login)->first();
            if ($user && password_verify($password, $user->password)) {
                $_SESSION['user_id'] = $user->id;
                return $this->createMsg('success', 'Logged in: ' . $login);
            } else {
                return $this->createMsg('error', 'Incorrect login or password');
            }
        }
    }
    
}
