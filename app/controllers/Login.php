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
            $login = trim($_POST['login']);
            $password = trim($_POST['password']);

            if (!isset($login[0]) || !isset($password[0])) {
                return $this->createMsg('error', 'Пожалуйста, заполните все поля');
            }
    
            $user = User::where('login', $login)->first();
            if ($user && password_verify($password, $user->password)) {
                $_SESSION['user_id'] = $user->id;
                $_SESSION['nickname'] = $user->login;
                return $this->createMsg('success', '');
            } else {
                return $this->createMsg('error', 'Неправильный логин или пароль');
            }
        }
    }
    
}
