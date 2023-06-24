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
            $password = $_POST['password'];

            $login = trim(strip_tags($login));
            $password = trim(strip_tags($password));

            if (!isset($login[0]) || !isset($password[0])) {
                return $this->createMsg('error', 'Please fill in all fields');
            }

            if (strlen($login) < 4 || strlen($login) > 32) {
                return $this->createMsg('error', 'Login must be between 4 and 30 characters');
            }
            
            if (!preg_match('/^[a-zA-Z0-9_]+$/', $login)) {
                return $this->createMsg('error', 'Login must only contain letters, numbers and \'_\' character');
            }
    
            if (strlen($password) < 8) {
                return $this->createMsg('error', 'Password must be at least 8 characters');
            }

            if (!preg_match('/^(\d+|[a-zA-Z0-9\!\@\#\$\%\^\&\*]+)$/', $password)) {
                return $this->createMsg('error', 'Password must contain only latin letters, numbers and special characters (!@#$%^&*?)');
            }


            $password = password_hash($password, PASSWORD_DEFAULT);
    

            $user = User::firstOrNew([
                'login' => $login
            ]);
            
            if ($user->wasRecentlyCreated) {
                $user->password = $password;
                $user->save();
                $this->createDefaultCategories($user->id);
                $this->createDefaultAccounts($user->id);
                return $this->createMsg('success', '');
            } else {
                return $this->createMsg('error', 'User already exists: ' . $login);
            }
        }
    }
    
    public function createDefaultCategories($user_id){
        $default_categories = ['Еда', 'Жильё', 'Развлечения', 'Машина'];
    
        foreach ($default_categories as $category_name) {
            $category = new Category;
            $category->create([
                'name' => $category_name,
                'user_id' => $user_id
            ]);
        }
    }

    public function createDefaultAccounts($user_id){
        $default_accounts = ['Наличные', 'Копилка', 'Виза'];
    
        foreach ($default_accounts as $account_name) {
            $account = new Account;
            $account ->create([
                'name' => $account_name,
                'user_id' => $user_id
            ]);
        }
    }
}
