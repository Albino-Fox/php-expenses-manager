<?php

use Illuminate\Database\Capsule\Manager as Capsule;

$capsule = new Capsule();

$capsule->addConnection([
    'driver' =>             $_ENV['DB_DRIVER'],
    'host' =>               $_ENV['DB_HOST'],
    'username' =>           $_ENV['DB_USERNAME'],
    'password' =>           $_ENV['DB_PASSWORD'],
    'database' =>           $_ENV['DB_DATABASE'],
    'charset' =>            $_ENV['DB_CHARSET'],
    'collation' =>          $_ENV['DB_COLLATION'],
    'prefix' =>             $_ENV['DB_PREFIX']
]);

$capsule->bootEloquent();