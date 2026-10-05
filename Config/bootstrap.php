<?php

require_once __DIR__ . '/../vendor/autoload.php';

use Illuminate\Database\Capsule\Manager as Capsule;

$capsule = new Capsule;

$capsule->addConnection([
    'driver' => 'sqlsrv',
    'host' => 'localhost\\SQLEXPRESS01',
    'database' => 'JobPortalDb',
    'username' => '',
    'password' => '',
    'charset' => 'utf8',
    'prefix' => '',
    'trust_server_certificate' => true,
]);

$capsule->setAsGlobal();
$capsule->bootEloquent();