<?php

use Illuminate\Database\Eloquent\Model as Eloquent;

class Vendor extends Eloquent
{
    protected $table = 'vendors';
    protected $primaryKey = 'id';
    public $timestamps = false;
    protected $fillable = ['name', 'user_id'];
    
    public function expense()
    {
        return $this->hasMany('Expense');
    }
}
