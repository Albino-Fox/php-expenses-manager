<?php

class Logout extends Controller
{
    public function index(){
        session_unset();
        session_destroy();
        // Redirect user to the login page
        header("Location: /login");
    }
}
