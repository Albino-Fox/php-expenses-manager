<?php

use Illuminate\Database\Eloquent\Model as Eloquent;

class Account extends Eloquent
{
    protected $table = 'accounts';
    protected $primaryKey = 'id';
    protected $fillable = ['name', 'user_id'];
    public $timestamps = false;

    public function expenses()
    {
        return $this->hasMany('Expense');
    }
}
