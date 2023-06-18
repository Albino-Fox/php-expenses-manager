<?php

use Illuminate\Database\Eloquent\Model as Eloquent;

class Expense extends Eloquent
{
    protected $primaryKey = 'id';
    public $timestamps = false;
    protected $fillable = ['user_id', 'category_id', 'amount', 'created_at'];
}
