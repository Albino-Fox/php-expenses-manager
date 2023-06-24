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
}
