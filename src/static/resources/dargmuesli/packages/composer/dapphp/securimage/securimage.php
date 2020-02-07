<?php
    include_once $_SERVER['DOCUMENT_ROOT'].'/resources/dargmuesli/filesystem/environment.php';

    // Load .env file
    load_env_file($_SERVER['SERVER_ROOT'].'/credentials');

    $securimage = new Securimage(array(
        'database_driver' => Securimage::SI_DRIVER_PGSQL,
        'database_host' => $_ENV['PGSQL_HOST'],
        'database_name' => $_ENV['PGSQL_DATABASE'].'_securimage',
        'database_pass' => $_ENV['PGSQL_PASSWORD'],
        'database_table' => 'securimage',
        'database_user' => $_ENV['PGSQL_USERNAME'],
        'no_session' => true,
        'skip_table_check' => false,
        'use_database' => true,
    ));