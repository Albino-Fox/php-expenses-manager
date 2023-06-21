<?php

require_once './vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable('.\\');
$dotenv->load();

require_once 'database.php';

require_once './app/core/App.php';
require_once './app/core/Controller.php';
