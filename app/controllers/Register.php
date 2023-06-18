<?php

class Register extends Controller
{
    public function index(){
        $this->view('register/index');
    }

    public function createUser(){
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $login = $_POST['login'];
            $password = $_POST['password']; // Remember to hash this before storing in a real application!
            $email = $_POST['email'];

            $user = new User;
            $user->create([
                'login' => $login,
                'password' => $password,
                'email' => $email
            ]);
            echo('User created: ' . $login);
        }
    }
}
