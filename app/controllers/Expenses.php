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
            $selected_date = $_POST['selected_date'];

            if(!isset(trim($selected_date)[0])){
                echo('Date is not selected');
                return;
            };
            echo ($selected_date);
            if (!isset(trim($amount)[0])) {
                echo('Amount is empty');
                return;
            }

            $category = Category::where('name', $category_name)->first();
            if (!$category) {
                echo('Category not found');
                return;
            }
    
            $vendor_id = null;
            if(isset(trim($vendor_name)[0])) {
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
                'date' => $selected_date
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
    
            if(!isset(trim($category_name)[0])){
                echo ('Category name is empty.');
                return;
            }

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
            
            if(!isset(trim($vendor_name)[0])){
                echo ('Vendor name is empty.');
                return;
            }

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