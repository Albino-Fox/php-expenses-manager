<?php

use Illuminate\Database\Eloquent\Model as Eloquent;

class Category extends Eloquent
{
    protected $table = 'categories';
    protected $primaryKey = 'id';
    protected $fillable = ['name', 'user_id'];
    public $timestamps = false;
}
