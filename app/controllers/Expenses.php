<?php

class Expenses extends Controller
{
    
    public function __construct(){
        $this->checkLoggedIn();
    }
    
    public function index(){
        
        $user_id = $_SESSION['user_id'];
        $expenses = Expense::where('user_id', $user_id)->with('vendor')->with('account')->get();
        $this->view('expenses/index', ['expenses' => $expenses]);
    }
    
    public function createExpense() {
        $response = [];

        $user_id = $_SESSION['user_id'];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $category_name = $_POST['category_name'];
            $amount = $_POST['amount'];
            $vendor_name = $_POST['vendor_name'];
            $account_name = $_POST['account_name'];
            $selected_date = $_POST['selected_date'];

            if(!isset(trim($selected_date)[0])){
                return $this->createMsg('error', 'Date is empty');
            }
    
            if (!isset(trim($amount)[0])) {
                return $this->createMsg('error', 'Amount is empty');
            }
    
            $category = Category::where('name', $category_name)->first();
            if (!$category) {
                return $this->createMsg('error', 'Category not found');
            }
    
            $vendor_id = null;
            if(isset(trim($vendor_name)[0])) {
                $vendor = Vendor::where('name', $vendor_name)->first();
                if (!$vendor) {
                    return $this->createMsg('error', 'Vendor not found');
                }
                $vendor_id = $vendor->id;
            } 
    
            $account_id = null;
            if(isset(trim($account_name)[0])) {
                $account = Account::where('name', $account_name)->first();
                if (!$account) {
                    return $this->createMsg('error', 'Account not found');
                }
                $account_id = $account->id;
            } 

            $expense = new Expense;
            $expense->create([
                'user_id' => $user_id,
                'category_id' => $category->id,
                'vendor_id' => $vendor_id,
                'account_id' => $account_id,
                'amount' => $amount,
                'date' => $selected_date
            ]);
            return $this->createMsg('success', 'Expense created: ' . $amount);
        } else {
            $categories = Category::where('user_id', $user_id)->get();
            $vendors = Vendor::where('user_id', $user_id)->get();
            $accounts = Account::where('user_id', $user_id)->get();
            $this->view('expenses/create', ['categories' => $categories, 'vendors' => $vendors, 'accounts' => $accounts]);
        }
    }    

    public function createCategory(){
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $user_id = $_SESSION['user_id'];
            $category_name = $_POST['category_name'];
    
            if(!isset(trim($category_name)[0])){
                return $this->createMsg('error', 'Category name is empty');
            }

            $category = Category::firstOrCreate([
                'name' => $category_name,
                'user_id' => $user_id
            ]);
            
            if ($category->wasRecentlyCreated) {
                return $this->createMsg('success', 'Category created: ' . $category_name);
            } else {
                return $this->createMsg('error', 'Category already exists: ' . $category_name);
            }
        }
    }

    public function createVendor(){
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $vendor_name = $_POST['vendor_name'];
            $user_id = $_SESSION['user_id'];
            
            if(!isset(trim($vendor_name)[0])){
                return $this->createMsg('error', 'Vendor name is empty');
            }

            $vendor = Vendor::firstOrCreate([
                'name' => $vendor_name,
                'user_id' => $user_id
            ]);
            
            if ($vendor->wasRecentlyCreated) {
                return $this->createMsg('success', 'Vendor created: ' . $vendor_name);
            } else {
                return $this->createMsg('error', 'Vendor already exists: ' . $vendor_name);
            }
        }
    }

    public function createAccount()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $account_name = $_POST['account_name'];
            $user_id = $_SESSION['user_id'];
            
            if(!isset(trim($account_name)[0])){
                return $this->createMsg('error', 'Account name is empty');
            }

            $account = Account::firstOrCreate([
                'name' => $account_name,
                'user_id' => $user_id
            ]);
            
            if ($account->wasRecentlyCreated) {
                return $this->createMsg('success', 'Account created: ' . $account_name);
            } else {
                return $this->createMsg('error', 'Account already exists: ' . $account_name);
            }
        }
    }

    public function getCategories(){
        $user_id = $_SESSION['user_id'];
        $categories = Category::where('user_id', $user_id)->get();
        echo(json_encode($categories));
    }

    public function getVendors(){
        $user_id = $_SESSION['user_id'];
        $vendors = Vendor::where('user_id', $user_id)->get();
        echo(json_encode($vendors));
    }
    
    public function getAccounts(){
        $user_id = $_SESSION['user_id'];
        $accounts = Account::where('user_id', $user_id)->get();
        echo(json_encode($accounts));
    }

}