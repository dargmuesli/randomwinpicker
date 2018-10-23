<?php
    include_once $_SERVER['DOCUMENT_ROOT'].'/layout/scripts/dotenv.php';

    $dbh = new PDO('pgsql:host='.$_ENV['PGSQL_HOST'].';port='.$_ENV['PGSQL_PORT'].';dbname='.$_ENV['PGSQL_DATABASE'], $_ENV['PGSQL_USERNAME'], $_ENV['PGSQL_PASSWORD']);

    $encoding = 'UTF-8';

    if (isset($email)) {
        $stmt = $dbh->prepare('SELECT encoding FROM accounts WHERE mail = :email');
        $stmt->bindParam(':email', $email);

        if (!$stmt->execute()) {
            throw new PDOException($stmt->errorInfo()[2]);
        }

        $encoding = $stmt->fetch()[0];
    }
