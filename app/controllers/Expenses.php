<?php

class Expenses extends Controller
{
    public function __construct(){
        $this->checkLoggedIn();
    }

    public function index(){

        $user_id = $_SESSION['user_id'];
        $expenses = Expense::where('user_id', $user_id)->with('vendor')->get();
        $this->view('expenses/index', ['expenses' => $expenses]);
    }
    
    public function createExpense() {

        $user_id = $_SESSION['user_id'];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $category_name = $_POST['category_name'];
            $amount = $_POST['amount'];
            $vendor_name = $_POST['vendor_name'];
    
            // Check if the category exists
            $category = Category::where('name', $category_name)->where('user_id', $_SESSION['user_id'])->first();
            if (!$category) {
                echo('Category not found');
                return;
            }
    
            // Check if a vendor was provided and if it exists
            $vendor_id = null;
            if (!empty($vendor_name)) {
                $vendor = Vendor::where('name', $vendor_name)->first();
                if (!$vendor) {
                    $vendor = new Vendor;
                    $vendor->create([
                        'name' => $vendor_name,
                        'user_id' => $user_id
                    ]);
                    echo('Vendor created: ' . $vendor_name);
                }
                $vendor_id = $vendor->id;
            }
    
            $expense = new Expense;
            $expense->create([
                'user_id' => $_SESSION['user_id'],
                'category_id' => $category->id,
                'amount' => $amount,
                'vendor_id' => $vendor_id,
                'created_at' => date('Y-m-d H:i:s')  // current date-time
            ]);
            echo('Expense created: ' . $amount);
        } else {
            $categories = Category::where('user_id', $user_id)->get();
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
