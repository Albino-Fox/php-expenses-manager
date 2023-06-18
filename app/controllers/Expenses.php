<?php

class Expenses extends Controller
{
    public function index(){
        $this->checkLoggedIn();

        $user_id = $_SESSION['user_id'];
        $expenses = Expense::where('user_id', $user_id)->get();
        $this->view('expenses/index', ['expenses' => $expenses]);
    }

    public function createExpense(){
        $this->checkLoggedIn();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $category_name = $_POST['category_name'];
            $amount = $_POST['amount'];
    
            $category = Category::where('name', $category_name)->first();
            if (!$category) {
                echo('Category not found');
                return;
            }
    
            $expense = new Expense;
            $expense->create([
                'user_id' => $_SESSION['user_id'],
                'category_id' => $category->id,
                'amount' => $amount,
                'created_at' => date('Y-m-d H:i:s')  // current date-time
            ]);
            echo('Expense created: ' . $amount);
        } else {
            $this->view('expenses/createExpense');
        }
    }
    

    public function createCategory(){
        $this->checkLoggedIn();
        
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
