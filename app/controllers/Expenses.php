<?php

class Expenses extends Controller
{
    public function index(){
        $user_id = $_SESSION['user_id'];
        $expenses = Expense::where('user_id', $user_id)->get();
        $this->view('expenses/index', ['expenses' => $expenses]);
    }
}
