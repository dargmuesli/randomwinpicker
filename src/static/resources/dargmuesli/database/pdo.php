<?php
    include_once $_SERVER['DOCUMENT_ROOT'].'/resources/dargmuesli/filesystem/environment.php';
    include_once $_SERVER['DOCUMENT_ROOT'].'/resources/dargmuesli/database/whitelist.php';
    include_once $_SERVER['DOCUMENT_ROOT'].'/resources/packages/composer/autoload.php';

    // Get the PDO instance for a database
    function get_dbh($dbhName)
    {
        // Load .env file
        load_env_file($_SERVER['SERVER_ROOT'].'/credentials');

        // Limit table access
        $whiteList = array($_ENV['PGSQL_DATABASE'], 'server');

        if (in_array($dbhName, $whiteList)) {
            return new PDO('pgsql:host='.$_ENV['PGSQL_HOST'].';port='.$_ENV['PGSQL_PORT'].';dbname='.$dbhName, $_ENV['PGSQL_USERNAME'], $_ENV['PGSQL_PASSWORD']);
        } else {
            throw new Exception('"'.$dbhName.'" is not whitelisted!');
        }
    }
