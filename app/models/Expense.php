<?php

use Illuminate\Database\Eloquent\Model as Eloquent;

class Expense extends Eloquent
{
    protected $table = 'expenses';
    protected $primaryKey = 'id';
    protected $fillable = ['user_id', 'category_id', 'amount', 'vendor_id', 'created_at'];
    public $timestamps = false;

    public function vendor()
    {
        return $this->belongsTo('Vendor', 'vendor_id');
    }
}
