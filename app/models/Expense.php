<?php

use Illuminate\Database\Eloquent\Model as Eloquent;

class Expense extends Eloquent
{
    protected $table = 'expenses';
    protected $primaryKey = 'id';
    protected $fillable = ['user_id', 'category_id', 'amount', 'type', 'vendor_id', 'account_id', 'comment', 'date'];
    public $timestamps = false;

    public function vendor()
    {
        return $this->belongsTo('Vendor', 'vendor_id');
    }

    public function account()
    {
        return $this->belongsTo('Account', 'account_id');
    }

    public function category()
    {
        return $this->belongsTo('Category', 'category_id');
    }

    public function getAmountStats($userId) {
        $expenses = $this::where('user_id', $userId)->get();
    
        $incomeAmount = 0;
        $expenseAmount = 0;
        
        foreach ($expenses as $expense) {
            if ($expense->type === 'I') {
                $incomeAmount += $expense->amount;
            } else {
                $expenseAmount += $expense->amount;
            }
        }
    
        return ['income' => $incomeAmount, 'expenses' => $expenseAmount];
    }
    
    public function getCategoryDistribution($userId) {
        $categories = $this::select('category_id', $this->getConnection()->raw('SUM(amount) as total'))
                        ->where('user_id', $userId)
                        ->groupBy('category_id')
                        ->get();
    
        $categoryDistribution = [];
        foreach ($categories as $category) {
            $categoryDistribution[] = [
                'category_id' => $category->category_id,
                'total' => $category->total,
            ];
        }
    
        return $categoryDistribution;
    }
    
    
}
