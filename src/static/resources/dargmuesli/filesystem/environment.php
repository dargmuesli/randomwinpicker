<?php
    include_once $_SERVER['DOCUMENT_ROOT'].'/resources/packages/composer/autoload.php';

    function load_env_file($folder, $file = 'randomwinpicker.env', $override = false)
    {
        $dotenv = new Dotenv\Dotenv($folder, $file);
        ($override) ? $dotenv->overload() : $dotenv->load();
        return $dotenv;
    }
