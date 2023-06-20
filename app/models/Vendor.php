<?php

use Illuminate\Database\Eloquent\Model as Eloquent;

class Vendor extends Eloquent
{
    protected $table = 'vendors';
    protected $primaryKey = 'id';
    public $timestamps = false;
    protected $fillable = ['name', 'user_id'];
    
    // Define the relationship to the Expense model
    public function expenses()
    {
        return $this->hasMany('Expense');
    }
}
