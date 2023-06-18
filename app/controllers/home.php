<?php

class Home extends Controller
{
    public function index($name = ''){
        echo("default params of home/index activated");

        $user = $this->model('User');
        $user->name = $name;
        
        $this->view('home/index', ['name' => $user->name]);
    }
}