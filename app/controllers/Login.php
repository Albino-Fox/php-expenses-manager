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
            
            $login = rtrim(trim($login));
            $password = rtrim(trim($password));

            if (!isset($login[0]) || !isset($password[0])) {
                return $this->createMsg('error', 'Please fill in all fields');
            }
    
            $user = User::where('login', $login)->first();
            if ($user && password_verify($password, $user->password)) {
                $_SESSION['user_id'] = $user->id;
                $_SESSION['nickname'] = $user->login; //bruh
                return $this->createMsg('success', '');
            } else {
                return $this->createMsg('error', 'Incorrect login or password');
            }
        }
    }
    
}
