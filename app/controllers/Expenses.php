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

    public function getExpenses() {
        $user_id = $_SESSION['user_id'];
        $expenses = Expense::where('user_id', $user_id)
            ->with('vendor')
            ->with('account')
            ->with('category')
            ->get();
    
        $this->sendJson($expenses);
    }

    
    
    public function getExpensesInRange() {
        if(!isset($_GET['start']) || !isset($_GET['end'])){
            $this->sendJson(['status' => 'error', 'message' => 'start date and/or end date not provided.']);
            return;
        }
    
        $startDate = $_GET['start'];
        $endDate = $_GET['end'];
    
        $userId = $_SESSION['user_id'];
    
        $expenses = Expense::where('user_id', $userId)
            ->where('date', '>=', $startDate)
            ->where('date', '<=', $endDate)
            ->get();
    
        $this->sendJson($expenses->toArray());
    }
    
    public function getExpensesAmountStats(){
        $user_id = $_SESSION['user_id'];
        $expenses = Expense::where('user_id', $user_id)->get();

        $incomeAmount = 0;
        $expenseAmount = 0;
        
        foreach ($expenses as $expense) {
            if ($expense->type === 'I') {
                $incomeAmount += $expense->amount;
            } else {
                $expenseAmount += $expense->amount;
            }
        }
        
        $this->sendJson(['income' => $incomeAmount, 'expenses' => $expenseAmount]);
    }



    public function deleteCategories() {
        if(!isset($_POST['categories'])){
            $this->sendJson(['status' => 'error', 'message' => 'no selected items']);
            return;
        }
        $categoryIds = $_POST['categories'];

        $userId = $_SESSION['user_id'];
        $categories = Category::where('user_id', $userId)
                              ->whereIn('id', $categoryIds)
                              ->get();
    
        foreach ($categories as $category) {
            if ($category->expense()->count() == 0) {
                $category->delete();
            } else {$this->sendJson(['status' => 'error', 'category_name' => $category->name, 'message' => 'has dependencies']);}
        }
    
        $this->sendJson(['status' => 'success']);
    }

    public function deleteAccounts() {
        if(!isset($_POST['accounts'])){
            $this->sendJson(['status' => 'error', 'message' => 'no selected items']);
            return;
        }
        $accountIds = $_POST['accounts'];

        $userId = $_SESSION['user_id'];
        $accounts = Account::where('user_id', $userId)
                              ->whereIn('id', $accountIds)
                              ->get();
    
        foreach ($accounts as $account) {
            if ($account->expense()->count() == 0) {
                $account->delete();
            } else {$this->sendJson(['status' => 'error', 'account_name' => $account->name, 'message' => 'has dependencies']);}
        }
    
        $this->sendJson(['status' => 'success']);
    }

    public function deleteVendors() {
        if(!isset($_POST['vendors'])){
            $this->sendJson(['status' => 'error', 'message' => 'no selected items']);
            return;
        }
        $vendorIds = $_POST['vendors'];

        $userId = $_SESSION['user_id'];
        $vendors = Vendor::where('user_id', $userId)
                              ->whereIn('id', $vendorIds)
                              ->get();
    
        foreach ($vendors as $vendor) {
            if ($vendor->expense()->count() == 0) {
                $vendor->delete();
            } else {$this->sendJson(['status' => 'error', 'vendor_name' => $vendor->name, 'message' => 'has dependencies']);}
        }
    
        $this->sendJson(['status' => 'success']);
    }
    



    public function editCategories() {
        $this->editItem('Category');
    }
    
    public function editVendors() {
        $this->editItem('Vendor');
    }
    
    public function editAccounts() {
        $this->editItem('Account');
    }
    
    private function editItem($modelClass) {
        $id = $_POST['id'];
        $name = $_POST['name'];
    
        //validation maybe?

        $item = $modelClass::find($id);
        if ($item) {
            $item->name = $name;
            $item->save();
        }
    }    



    public function updateExpense() {
        // check if all required parameters are set

        if (!isset($_POST['id'], $_POST['category'], $_POST['amount'], $_POST['type'], $_POST['date'])) {
            $this->sendJson(['status' => 'error', 'message' => 'missing required parameters']);
            return;
        }
        
        $amount = $_POST['amount'];
        if (!isset($amount[0])) {
                return $this->createMsg('error', 'Amount is empty');
            }

        if (!is_numeric($amount) || $amount <= 0) {
            return $this->createMsg('error', 'Amount is incorrect');
        }


        $userId = $_SESSION['user_id'];
        $expenseId = $_POST['id'];

        
        
        $categoryId = null;
        $category = Category::where('user_id', $userId)->where('name', $_POST['category'])->first();
        if ($category) {
            $categoryId = $category->id;
        } else {
            $this->sendJson(['status' => 'error', 'message' => 'category not found']);
            return;
        }

        $vendorId = null;
        if (isset($_POST['vendor']) && $_POST['vendor'] != '') {
            $vendor = Vendor::where('user_id', $userId)->where('name', $_POST['vendor'])->first();
            if ($vendor) {
                $vendorId = $vendor->id;
            } else {
                $this->sendJson(['status' => 'error', 'message' => 'vendor not found']);
                return;
            }
        }

        $accountId = null;
        if (isset($_POST['account']) && $_POST['account'] != '') {
            $account = Account::where('user_id', $userId)->where('name', $_POST['account'])->first();
            if ($account) {
                $accountId = $account->id;
            } else {
                $this->sendJson(['status' => 'error', 'message' => 'account not found']);
                return;
            }
        }


        $type = $_POST['type'];
        $selected_date = $_POST['date'];
        
        //date validation (??)
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

        // check if the expense exists and belongs to the user
        $expense = Expense::where('user_id', $userId)
                          ->where('id', $expenseId)
                          ->first();
    
        if (!$expense) {
            $this->sendJson(['status' => 'error', 'message' => 'expense not found']);
            return;
        }
    
        // update the expense
        $expense->category_id = $categoryId;
        $expense->amount = $amount;
        $expense->type = $type;
        $expense->date = $selected_date;
    
        // check if vendor and account are set and update them if they are
        $expense->vendor_id = $vendorId;
        $expense->account_id = $accountId;
    
        // save the changes
        $expense->save();
    
        $this->sendJson(['status' => 'success']);
    }
    
    public function deleteExpense() {
        if (!isset($_POST['id'])) {
            $this->sendJson(['status' => 'error', 'message' => 'missing required parameters']);
            return;
        }
    
        $userId = $_SESSION['user_id'];
        $expenseId = $_POST['id'];
    
        $expense = Expense::where('user_id', $userId)->where('id', $expenseId)->first();
    
        if (!$expense) {
            $this->sendJson(['status' => 'error', 'message' => 'expense not found']);
            return;
        }
    
        $expense->delete();
    
        $this->sendJson(['status' => 'success']);
    }
    

    public function deleteSelected(){
        $ids = $_POST['ids'];
        foreach ($ids as $id) {
            $expense = Expense::find($id);
            if ($expense) {
                $expense->delete();
            }
        }
        return $this->sendJson(['status' => 'success', 'message' => 'expenses deleted']);
    }
    
}