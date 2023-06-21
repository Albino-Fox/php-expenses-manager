<?php

class Register extends Controller
{
    public function index(){
        if(isset($_SESSION['user_id'])){
            $this->view('home/index');
            return;
        }
        $this->view('register/index');
    }

    public function createUser(){
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $login = $_POST['login'];
            $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
            // $email = $_POST['email'];
    
            $existingUser = User::where('login', $login)->first();
            if ($existingUser) {
                return $this->createMsg('error', 'User with this login already exists');
            }
    
            // if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            //     return $this->createMsg('error', 'Invalid email format');
            // }
    

            $user = new User;
            $new_user = $user->create([
                'login' => $login,
                'password' => $password,
                // 'email' => $email
            ]);
            
            $this->createDefaultCategories($new_user->id);
            $this->createDefaultAccounts($new_user->id);

            return $this->createMsg('success', 'User created: ' . $login);
        }
    }
    
    public function createDefaultCategories($user_id){
        $default_categories = ['Food', 'Rent', 'Entertainment', 'Car']; //expaand
    
        foreach ($default_categories as $category_name) {
            $category = new Category;
            $category->create([
                'name' => $category_name,
                'user_id' => $user_id
            ]);
        }
    }

    public function createDefaultAccounts($user_id){
        $default_accounts = ['Cash', 'Checking', 'Savings', 'Visa']; //expaand
    
        foreach ($default_accounts as $account_name) {
            $account = new Account;
            $account ->create([
                'name' => $account_name,
                'user_id' => $user_id
            ]);
        }
    }
}
