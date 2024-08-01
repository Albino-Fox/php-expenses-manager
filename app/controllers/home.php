<?php

class Home extends Controller
{
    public function index(){
        $this->view('home/index');
    }
    
    public function viewExpenses(){
        if (isset($_SESSION['user_id'])) {
            $expenses = Expense::where('user_id', $_SESSION['user_id'])->get();
            $this->view('expenses/index', ['expenses' => $expenses]);
        } else {
            $this->createMsg('error', 'Вам нужно авторизоваться, чтобы увидеть расходы');
        }
    }  
}
