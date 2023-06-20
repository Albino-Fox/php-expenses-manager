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
            $vendor_name = $_POST['vendor_name'];  // assuming vendor_name is passed
    
            $category = Category::where('name', $category_name)->first();
            if (!$category) {
                echo('Category not found');
                return;
            }
    
            $vendor_id = null;
            if(!empty($vendor_name)) {
                $vendor = Vendor::where('name', $vendor_name)->first();
                if (!$vendor) {
                    echo('Vendor not found');
                    return;
                }
                $vendor_id = $vendor->id;
            } 
    
            $expense = new Expense;
            $expense->create([
                'user_id' => $_SESSION['user_id'],
                'category_id' => $category->id,
                'vendor_id' => $vendor_id,
                'amount' => $amount,
                'created_at' => date('Y-m-d H:i:s')  // current date-time
            ]);
            echo('Expense created: ' . $amount);
        } else {
            $categories = Category::where('user_id', $user_id)->get();
            $vendors = Vendor::where('user_id', $user_id)->get();
            $this->view('expenses/create', ['categories' => $categories, 'vendors' => $vendors]);
        }
    }    
    

    public function createCategory(){
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $user_id = $_SESSION['user_id'];
            $category_name = $_POST['category_name'];
    

            $category = Category::where('name', $category_name)->where('user_id', $user_id)->first();
            if(!$category){
            $category = new Category;
            $category->create([
                'name' => $category_name,
                'user_id' => $user_id
            ]);
            echo('Category created: ' . $category_name);
            }
            else {
                echo('Category already exists: ' . $category_name);
            }
        }
    }

    public function createVendor(){
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $vendor_name = $_POST['vendor_name'];
            $user_id = $_SESSION['user_id'];
    
            $vendor = Vendor::where('name', $vendor_name)->where('user_id', $user_id)->first();
            if (!$vendor) {
                $vendor = new Vendor;
                $vendor->create([
                    'name' => $vendor_name,
                    'user_id' => $user_id
                ]);
                echo('Vendor created: ' . $vendor_name);
            } else {
                echo('Vendor already exists: ' . $vendor_name);
            }
        }
    }
}