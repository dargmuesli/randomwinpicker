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

    function init_table($dbh, $tableName)
    {
        $columnConfig = null;
        $sqlIntegration = null;

        switch ($tableName) {
            case 'accounts':
                $columnConfig = '
                    id serial PRIMARY KEY NOT NULL,
                    mail character varying(75) NOT NULL,
                    prices boolean DEFAULT true NOT NULL';
                break;
            default:
                throw new Exception('"'.$tableName.'" has no deployable configuration!');
        }

        $tableExists = table_exists($dbh, $tableName);
        $stmt = $dbh->query('CREATE TABLE IF NOT EXISTS '.$tableName.' ('.$columnConfig.');');

        if (!$stmt) {
            throw new PDOException('Could not create table "'.$tableName.'".');
        }

        if (!is_null($sqlIntegration) && !$tableExists) {
            $stmt = $dbh->query($sqlIntegration);

            if (!$stmt) {
                throw new PDOException('Could not execute SQL integration instruction "'.$sqlIntegration.'".');
            }
        }
    }

    function table_exists($dbh, $tableName)
    {
        return $dbh
            ->query('SELECT EXISTS (SELECT 1 FROM pg_tables WHERE schemaname = \'public\' AND tablename = \''.$tableName.'\')')
            ->fetch()['exists'];
    }
