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
    
    public function viewStatistics(){
        $user_id = $_SESSION['user_id'];

        $this->view('expenses/stats');
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
            $comment = trim($_POST['comment']);

            if (!isset($category_name[0])) {
                return $this->createMsg('error', 'Категория не установлена');
            }

            if (!isset($amount[0])) {
                return $this->createMsg('error', 'Сумма не установлена');
            }

            if (!is_numeric($amount) || $amount <= 0) {
                return $this->createMsg('error', 'Сумма некорректна');
            }

            //date validation - do i need this here?
            if(!isset($selected_date[0])){
                return $this->createMsg('error', 'Дата не установлена');
            }

            $selected_date = DateTime::createFromFormat('Y-m-d', $selected_date);

            if ($selected_date === false) {
                return $this->createMsg('error', 'Неподходящий формат даты');
            }

            $errors = DateTime::getLastErrors();

            if ($errors['error_count'] > 0 || $errors['warning_count'] > 0) {
                return $this->createMsg('error', 'Неправильная дата');
            }
            //end of date validation
    

            if (!isset($expense_type[0])) {
                return $this->createMsg('error', 'Тип транзакции не установлен');
            }
            
            if (!ctype_alpha($expense_type)) {
                return $this->createMsg('error', 'Тип транзакции некорректен');
            }

            if (strlen($expense_type) != 1) {
                return $this->createMsg('error', 'Тип транзакции должен быть (1) в длину');
            }
    
            $category = Category::where('name', $category_name)->first();
            if (!$category) {
                return $this->createMsg('error', 'Категория не найдена');
            }
    
            $vendor_id = null;
            if(isset(trim($vendor_name)[0])) {
                $vendor = Vendor::where('name', $vendor_name)->first();
                if (!$vendor) {
                    return $this->createMsg('error', 'Продавец не найден');
                }
                $vendor_id = $vendor->id;
            } 
    
            $account_id = null;
            if(isset(trim($account_name)[0])) {
                $account = Account::where('name', $account_name)->first();
                if (!$account) {
                    return $this->createMsg('error', 'Счёт не найден');
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
                'date' => $selected_date,
                'comment' => $comment
            ]);
            return $this->createMsg('success', 'Успех! Транзакция записана');
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
                return $this->createMsg('error', 'Имя категории не установлено');
            }

            $category = Category::firstOrCreate([
                'name' => $category_name,
                'user_id' => $user_id
            ]);
            
            if ($category->wasRecentlyCreated) {
                return $this->createMsg('success', 'Категория добавлена: ' . $category_name);
            } else {
                return $this->createMsg('error', 'Категория уже существует: ' . $category_name);
            }
        }
    }

    public function createVendor(){
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $vendor_name = $_POST['vendor_name'];
            $user_id = $_SESSION['user_id'];
            
            if(!isset(trim($vendor_name)[0])){
                return $this->createMsg('error', 'Название продавца не установлено');
            }

            $vendor = Vendor::firstOrCreate([
                'name' => $vendor_name,
                'user_id' => $user_id
            ]);
            
            if ($vendor->wasRecentlyCreated) {
                return $this->createMsg('success', 'Продавец добавлен: ' . $vendor_name);
            } else {
                return $this->createMsg('error', 'Продавец уже существует: ' . $vendor_name);
            }
        }
    }

    public function createAccount()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $account_name = $_POST['account_name'];
            $user_id = $_SESSION['user_id'];
            
            if(!isset(trim($account_name)[0])){
                return $this->createMsg('error', 'Название счёта не установлено');
            }

            $account = Account::firstOrCreate([
                'name' => $account_name,
                'user_id' => $user_id
            ]);
            
            if ($account->wasRecentlyCreated) {
                return $this->createMsg('success', 'Счёт добавлен: ' . $account_name);
            } else {
                return $this->createMsg('error', 'Счёт уже существует: ' . $account_name);
            }
        }
    }



    public function getCategories(){
        $user_id = $_SESSION['user_id'];
        $categories = Category::where('user_id', $user_id)->get();
    
        foreach ($categories as $category) {
            $category->is_used = Expense::where('category_id', $category->id)->exists();
        }
    
        $this->sendJson($categories);
    }

    public function getVendors(){
        $user_id = $_SESSION['user_id'];
        $vendors = Vendor::where('user_id', $user_id)->get();

        foreach ($vendors as $vendor) {
            $vendor->is_used = Expense::where('vendor_id', $vendor->id)->exists();
        }

        $this->sendJson($vendors);
    }
    
    public function getAccounts(){
        $user_id = $_SESSION['user_id'];
        $accounts = Account::where('user_id', $user_id)->get();

        foreach ($accounts as $account) {
            $account->is_used = Expense::where('account_id', $account->id)->exists();
        }

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
    
    public function getExpensesAmountStats() {
        $user_id = $_SESSION['user_id'];
        $expenseModel = new Expense();
    
        $amountStats = $expenseModel->getAmountStats($user_id);
    
        $this->sendJson($amountStats);
    }



    public function deleteCategories() {
        if(!isset($_POST['categories'])){
            return $this->createMsg('error', 'Элементы не выбраны');
        }
        $categoryIds = $_POST['categories'];

        $isUsed = false;

        $userId = $_SESSION['user_id'];
        $categories = Category::where('user_id', $userId)
                              ->whereIn('id', $categoryIds)
                              ->get();
    
        foreach ($categories as $category) {
            if ($category->expense()->count() == 0) {
                $category->delete();
            } else {
                $isUsed = true;
            }
        }
    
        if($isUsed) {
            {$this->createMsg('error', 'Используемые в существующих транзакциях записи не были удалены');}
        }
        else 
        {
            if(count($categories) == 1){
                $this->createMsg('success', 'Категория удалена');
            }
            else {
                $this->createMsg('success', 'Категории удалены');
            }
        }
    }

    public function deleteAccounts() {
        if(!isset($_POST['accounts'])){
            return $this->createMsg('error', 'Элементы не выбраны');
        }

        $isUsed = false;

        $accountIds = $_POST['accounts'];

        $userId = $_SESSION['user_id'];
        $accounts = Account::where('user_id', $userId)
                              ->whereIn('id', $accountIds)
                              ->get();
    
        foreach ($accounts as $account) {
            if ($account->expense()->count() == 0) {
                $account->delete();
            } else {
                $isUsed = true;
            }
        }

        if($isUsed) {
            {$this->createMsg('error', 'Используемые в существующих транзакциях записи не были удалены');}
        }
        else 
        {
            if(count($accounts) == 1){
                $this->createMsg('success', 'Счёт удалён');
            }
            else {
                $this->createMsg('success', 'Счета удалены');
            }
        }
    }

    public function deleteVendors() {
        if(!isset($_POST['vendors'])){
            return $this->createMsg('error', 'Элементы не выбраны');
        }

        $isUsed = false;

        $vendorIds = $_POST['vendors'];

        $userId = $_SESSION['user_id'];
        $vendors = Vendor::where('user_id', $userId)
                              ->whereIn('id', $vendorIds)
                              ->get();
    
        foreach ($vendors as $vendor) {
            if ($vendor->expense()->count() == 0) {
                $vendor->delete();
            } else {
                $isUsed = true;
            }
        }
        
        if($isUsed) {
            {$this->createMsg('error', 'Используемые в существующих транзакциях записи не были удалены');}
        }
        else 
        {
            if(count($vendors) == 1){
                $this->createMsg('success', 'Продавец удалён');
            }
            else{
                $this->createMsg('success', 'Продавцы удалены');
            }
        }
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
        $name = trim($_POST['name']);

        if(!isset($name[0])){
            return $this->createMsg('error', 'Введите название');
        }
    
        $item = $modelClass::find($id);
        if ($item) {
            $item->name = $name;
            $item->save();
        }

        $this->createMsg('success','Изменение прошло успешно');
    }    



    public function updateExpense() {
        // check if all required parameters are set

        if (!isset($_POST['id'], $_POST['category'], $_POST['amount'], $_POST['type'], $_POST['date'])) {
            $this->sendJson(['status' => 'error', 'message' => 'Отсутствуют некоторые параметры']);
            return;
        }
        
        $amount = $_POST['amount'];
        if (!isset($amount[0])) {
            return $this->createMsg('error', 'Сумма не установлена');
        }

        if (!is_numeric($amount) || $amount <= 0) {
            return $this->createMsg('error', 'Сумма некорректна');
        }


        $userId = $_SESSION['user_id'];
        $expenseId = $_POST['id'];

        
        
        $categoryId = null;
        $category = Category::where('user_id', $userId)->where('name', $_POST['category'])->first();
        if ($category) {
            $categoryId = $category->id;
        } else {
            $this->sendJson(['status' => 'error', 'message' => 'Категория не найдена']);
            return;
        }

        $vendorId = null;
        if (isset($_POST['vendor']) && $_POST['vendor'] != '') {
            $vendor = Vendor::where('user_id', $userId)->where('name', $_POST['vendor'])->first();
            if ($vendor) {
                $vendorId = $vendor->id;
            } else {
                $this->sendJson(['status' => 'error', 'message' => 'Продавец не найден']);
                return;
            }
        }

        $accountId = null;
        if (isset($_POST['account']) && $_POST['account'] != '') {
            $account = Account::where('user_id', $userId)->where('name', $_POST['account'])->first();
            if ($account) {
                $accountId = $account->id;
            } else {
                $this->sendJson(['status' => 'error', 'message' => 'Счёт не найден']);
                return;
            }
        }


        $type = $_POST['type'];
        //type validation
        if (!isset($type[0])) {
            return $this->createMsg('error', 'Тип транзакции не установлен');
        }
        
        if (!ctype_alpha($type)) {
            return $this->createMsg('error', 'Тип транзакции некорректен');
        }

        if (strlen($type) != 1) {
            return $this->createMsg('error', 'Тип транзакции должен быть (1) в длину');
        }
        //end of type validation
        
        $selected_date = trim($_POST['date']);
        $comment = trim($_POST['comment']);

        
        //date validation (??)
        if(!isset($selected_date[0])){
            return $this->createMsg('error', 'Дата не установлена');
        }

        $selected_date = DateTime::createFromFormat('Y-m-d', $selected_date);

        if ($selected_date === false) {
            return $this->createMsg('error', 'Неправильный формат даты');
        }

        $errors = DateTime::getLastErrors();

        if ($errors['error_count'] > 0 || $errors['warning_count'] > 0) {
            return $this->createMsg('error', 'Некорректная дата');
        }
        //end of date validation

        // check if the expense exists and belongs to the user
        $expense = Expense::where('user_id', $userId)
                          ->where('id', $expenseId)
                          ->first();
    
        if (!$expense) {
            $this->sendJson(['status' => 'error', 'message' => 'Транзакция не найдена']);
            return;
        }
    
        // update the expense
        $expense->category_id = $categoryId;
        $expense->amount = $amount;
        $expense->type = $type;
        $expense->date = $selected_date;
        $expense->comment = $comment;
    
        // check if vendor and account are set and update them if they are
        $expense->vendor_id = $vendorId;
        $expense->account_id = $accountId;
    
        // save the changes
        $expense->save();
    
        $this->createMsg('success', 'Транзакция обновлена');
    }
    
    public function deleteExpense() {
        if (!isset($_POST['id'])) {
            return $this->createMsg('error', 'Отсутствуют требуемые параметры');
        }
    
        $userId = $_SESSION['user_id'];
        $expenseId = $_POST['id'];
    
        $expense = Expense::where('user_id', $userId)->where('id', $expenseId)->first();
    
        if (!$expense) {
            return $this->createMsg('error', 'Транзакция не найдена');
        }
    
        $expense->delete();
    
        return $this->createMsg('success', 'Транзакция удалена');
    }
    

    public function deleteSelected(){
        if (!isset($_POST['ids'])) {
            return $this->createMsg('error', 'Отсутствуют требуемые параметры');
        }

        $userId = $_SESSION['user_id'];
        $ids = $_POST['ids'];
        
        foreach ($ids as $id) {
            $expense = Expense::where('user_id', $userId)->find($id);
            if(!$expense) {
                $this->sendJson(['status' => 'error', 'message' => 'Транзакция с id:' . $id . ' не найдена']);
            } else
            if ($expense) {
                $expense->delete();
            }
        }
        return $this->createMsg('success', 'Выбранные транзакции удалены');
    }
    
}