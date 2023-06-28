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
                return $this->createMsg('error', 'Пожалуйста, заполните все поля');
            }

            if (strlen($login) < 4 || strlen($login) > 32) {
                return $this->createMsg('error', 'Логин должен быть длиной между 4 и 30 символами');
            }
            
            if (!preg_match('/^[a-zA-Z0-9_]+$/', $login)) {
                return $this->createMsg('error', 'Логин может содержать только латинские буквы, цифры и \'_\' символ');
            }
    
            if (strlen($password) < 8) {
                return $this->createMsg('error', 'Пароль должен быть длиной минимум 8 символов');
            }

            if (!preg_match('/^(\d+|[a-zA-Z0-9\!\@\#\$\%\^\&\*]+)$/', $password)) {
                return $this->createMsg('error', 'Пароль может содержать только латинские буквы, цифры и специальные символы (!@#$%^&*?)');
            }


            $password = password_hash($password, PASSWORD_DEFAULT);
    
            $user = User::where('login', $login)->first();

            if ($user === null) {
                $user = new User();
                $user->login = $login;
                $user->password = $password;
                $user->save();

                $this->createDefaultCategories($user->id);
                $this->createDefaultAccounts($user->id);

                return $this->createMsg('success', '');
            } else {
                return $this->createMsg('error', 'Пользователь уже существует: ' . $login);
            }
        }
    }
    
    public function createDefaultCategories($user_id){
        $default_categories = ['Еда', 'Жильё', 'Развлечения', 'Зарплата', 'Автомобиль'];
    
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
