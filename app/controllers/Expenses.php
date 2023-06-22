<?php

class Expenses extends Controller
{
    
    public function __construct(){
        $this->checkLoggedIn();
    }
    
    public function index(){
        
        $user_id = $_SESSION['user_id'];
        $expenses = Expense::where('user_id', $user_id)->with('vendor')->with('account')->get();
        
        $incomeAmount = 0;
        $expenseAmount = 0;
        
        foreach ($expenses as $expense) {
            if ($expense->type === 'I') {
                $incomeAmount += $expense->amount;
            } else {
                $expenseAmount += $expense->amount;
            }
        }
        
        $difference = $incomeAmount - $expenseAmount;
        
        $this->view('expenses/index', ['expenses' => $expenses, 
        'incomeAmount' => $incomeAmount,
        'expenseAmount' => $expenseAmount,
        'difference' => $difference]);
    }
    
    public function createExpense() {

        $user_id = $_SESSION['user_id'];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $category_name = trim($_POST['category_name']);
            $amount = trim($_POST['amount']);
            $expense_type = trim($_POST['expense_type']);
            $vendor_name = trim($_POST['vendor_name']);
            $account_name = trim($_POST['account_name']);
            $selected_date = trim($_POST['selected_date']);


            //date validation - do i need this here?
            if(!isset($selected_date[0])){
                return $this->createMsg('error', 'Date is empty');
            }

            $selected_date = DateTime::createFromFormat('Y-m-d', $selected_date);

            if ($selected_date === false) {
                return $this->createMsg('error', 'Invalid date format');
            }

            $errors = DateTime::getLastErrors();

            if ($errors['error_count'] > 0 || $errors['warning_count'] > 0) {
                return $this->createMsg('error', 'Invalid date');
            }
            //end of date validation
    
            if (!isset($amount[0])) {
                return $this->createMsg('error', 'Amount is empty');
            }

            if (!is_numeric($amount) || $amount <= 0) {
                return $this->createMsg('error', 'Amount is incorrect');
            }

            if (!isset($expense_type[0])) {
                return $this->createMsg('error', 'Expense type is empty');
            }
            
            if (!ctype_alpha($expense_type)) {
                return $this->createMsg('error', 'Expense type is incorrect');
            }

            if (strlen($expense_type) != 1) {
                return $this->createMsg('error', 'Expense type must be (1) in length');
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
                'type' => $expense_type,
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
        $this->sendJson($categories);
    }

    public function getVendors(){
        $user_id = $_SESSION['user_id'];
        $vendors = Vendor::where('user_id', $user_id)->get();
        $this->sendJson($vendors);
    }
    
    public function getAccounts(){
        $user_id = $_SESSION['user_id'];
        $accounts = Account::where('user_id', $user_id)->get();
        $this->sendJson($accounts);
    }

    public function update()
    {
        $expenseId = $_POST['expense_id'];
        $field = $_POST['field'];
        $value = $_POST['value'];

        // validate the amount
        if ($field === 'amount' && (!is_numeric($value) || $value <= 0)) {
            http_response_code(400);
            return $this->createMsg('error', 'Invalid amount');
        }
        if ($value > PHP_INT_MAX) {
            http_response_code(400);
            return $this->createMsg('error', 'Amount is too big');
        }

        // validate the date
        if ($field === 'date') {
            $date = DateTime::createFromFormat('Y-m-d', $value);

            if ($date === false) {
                http_response_code(400);
                return $this->createMsg('error', 'Invalid date format');
            }

            $errors = DateTime::getLastErrors();

            if ($errors['error_count'] > 0 || $errors['warning_count'] > 0) {
                http_response_code(400);
                return $this->createMsg('error', 'Invalid date');
            }
        }

        $expense = Expense::find($expenseId);
        $expense->$field = $value;
        $expense->save();

        return $this->createMsg('success', 'Expense updated');
    }

    public function deleteSelected(){
        $ids = $_POST['ids'];
        foreach ($ids as $id) {
            $expense = Expense::find($id);
            if ($expense) {
                $expense->delete();
            }
        }
        return $this->createMsg('success', 'Expenses deleted');
    }
    
}