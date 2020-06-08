<?php
    include_once $_SERVER['DOCUMENT_ROOT'].'/resources/packages/composer/autoload.php';

    function load_env_file($folder, $file = 'randomwinpicker.env', $override = false)
    {
        $dotenv = null;

        if ($override) {
            $dotenv = Dotenv\Dotenv::createMutable($folder, $file);
            $dotenv->overload();
        } else {
            $dotenv = Dotenv\Dotenv::createImmutable($folder, $file);
            $dotenv->load();
        }

        return $dotenv;
    }
