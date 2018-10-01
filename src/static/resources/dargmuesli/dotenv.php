<?php
    require_once $_SERVER['DOCUMENT_ROOT'] . '/resources/packages/composer/autoload.php';

    $dotenv = new Dotenv\Dotenv(dirname($_SERVER['DOCUMENT_ROOT']).'/credentials');
    $dotenv->load();
