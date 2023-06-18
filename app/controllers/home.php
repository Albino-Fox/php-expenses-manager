<?php

class Home extends Controller
{
    public function index($name = ''){
        echo("default params of home/index activated");
        
        $this->view('home/index', ['name' => $name]);
    }

    public function create($login = '', $pass = ''){
        User::create([
            'login' => $login,
            'password' => $pass
        ]);
        echo($login . ' ' . $pass);
    }
}