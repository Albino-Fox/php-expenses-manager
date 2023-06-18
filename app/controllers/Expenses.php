<?php

class Expenses extends Controller
{
    public function __construct(){
        $this->checkLoggedIn();
    }

    public function index(){
        
        $user_id = $_SESSION['user_id'];
        $expenses = Expense::where('user_id', $user_id)->get();
        $this->view('expenses/index', ['expenses' => $expenses]);
    }

    public function createExpense(){

        $user_id = $_SESSION['user_id'];
    
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $category_name = $_POST['category_name'];
            $amount = $_POST['amount'];
    
            // Only find categories associated with the current user
            $category = Category::where('name', $category_name)->where('user_id', $user_id)->first();
            if (!$category) {
                echo('Category not found or you do not have access to this category');
                return;
            }
    
            $expense = new Expense;
            $expense->create([
                'user_id' => $user_id,
                'category_id' => $category->id,
                'amount' => $amount,
                'created_at' => date('Y-m-d H:i:s')  // current date-time
            ]);
            echo('Expense created: ' . $amount);
        } else {
            // Fetch categories associated with the user
            $categories = Category::where('user_id', $user_id)->get();
    
            // Pass the categories to the view
            $this->view('expenses/createExpense', ['categories' => $categories]);
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
