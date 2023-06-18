<?php

class Expenses extends Controller
{
    public function index(){
        $user_id = $_SESSION['user_id'];
        $expenses = Expense::where('user_id', $user_id)->get();
        $this->view('expenses/index', ['expenses' => $expenses]);
    }

    public function createExpense(){
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $category_id = $_POST['category_id'];
            $amount = $_POST['amount'];
    
            $expense = new Expense;
            $expense->create([
                'user_id' => $_SESSION['user_id'],
                'category_id' => $category_id,
                'amount' => $amount,
                'created_at' => date('Y-m-d H:i:s')  // current date-time
            ]);
            echo('Expense created: ' . $amount);
        } else {
            $this->view('expenses/createExpense');
        }
    }

    public function createCategory(){
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = $_POST['name'];
            $user_id = $_SESSION['user_id'];
    
            $category = new Category;
            $category->create([
                'name' => $name,
                'user_id' => $user_id
            ]);
            echo('Category created: ' . $name);
        } else {
            $this->view('expenses/createCategory');
        }
    }
    
}
