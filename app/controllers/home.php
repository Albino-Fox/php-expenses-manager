<?php

class Home extends Controller
{
    public function index($name = ''){
        echo("default params of home/index activated");
        
        $this->view('home/index', ['name' => $name]);
    }

    public function createUser(){
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $login = $_POST['login'];
            $password = $_POST['password'];
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

    public function createCategory(){
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = $_POST['name'];
            $user_id = $_POST['user_id'];
    
            $category = new Category;
            $category->create([
                'name' => $name,
                'user_id' => $user_id
            ]);
            echo('Category created: ' . $name);
        }
    }
    
    public function createExpense(){
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $user_id = $_POST['user_id'];
            $category_id = $_POST['category_id'];
            $amount = $_POST['amount'];
    
            $expense = new Expense;
            $expense->create([
                'user_id' => $user_id,
                'category_id' => $category_id,
                'amount' => $amount,
                'created_at' => date('Y-m-d H:i:s')  // Use the current date and time
            ]);
            echo('Expense created: ' . $amount);
        }
    }

    public function viewExpenses($user_id = ''){
        $expenses = Expense::where('user_id', $user_id)->get();
        $this->view('home/expenses', ['expenses' => $expenses]);
    }
    
}
