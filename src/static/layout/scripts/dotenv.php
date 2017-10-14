<?php
    require_once $_SERVER['SERVER_ROOT'] . '/resources/packages/composer/autoload.php';

    $dotenv = new Dotenv\Dotenv(dirname($_SERVER['SERVER_ROOT']).'/credentials');
    $dotenv->load();
