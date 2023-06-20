<?php

use Illuminate\Database\Eloquent\Model as Eloquent;

class User extends Eloquent
{
    public $name;


    protected $table = 'users';
    protected $primaryKey = 'id';
    protected $fillable = ['login', 'password', 'email'];
    
    public $timestamps = false;
}