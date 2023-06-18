<?php

class Register extends Controller
{
    public function index(){
        $this->view('register/index');
    }

    public function createUser(){
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $login = $_POST['login'];
            $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
            $email = $_POST['email'];
    
            // Check if user already exists
            $existingUser = User::where('login', $login)->first();
            if ($existingUser) {
                echo('User with this login already exists');
                return;
            }
    
            // Input validation (as an example)
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                echo('Invalid email format');
                return;
            }
    
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
