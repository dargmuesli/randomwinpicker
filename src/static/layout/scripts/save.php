<?php
    session_start();

    require_once $_SERVER['SERVER_ROOT'] . '/layout/scripts/dotenv.php';

    $dbh = new PDO('pgsql:host='.$_ENV['PGSQL_HOST'].';port='.$_ENV['PGSQL_PORT'].';dbname='.$_ENV['PGSQL_DATABASE'], $_ENV['PGSQL_USERNAME'], $_ENV['PGSQL_PASSWORD']);

    $storage = 'Session';

    if (isset($_SESSION['email'])) {
        $stmt = $dbh->prepare('SELECT storage FROM accounts WHERE mail = :email');
        $stmt->bindParam(':email', $email);

        if (!$stmt->execute()) {
            throw new PDOException($stmt->errorInfo()[2]);
        }

        $storage = $stmt->fetch()[0];
    }

    if ($_POST['type'] == 'participants') {
        if ($storage == 'Session') {
            $_SESSION['participants'] = json_decode($_POST['content'], true);
            var_dump(json_decode($_POST['content'], true));
        } elseif ($storage == 'Cookies') {
            setcookie('participants', $_POST['content'], time() + (60 * 60 * 24 * 365), '/');
        }
    } elseif ($_POST['type'] == 'items') {
        if ($storage == 'Session') {
            $_SESSION['items'] = json_decode($_POST['content'], true);
        } elseif ($storage == 'Cookies') {
            setcookie('items', $_POST['content'], time() + (60 * 60 * 24 * 365), '/');
        }
    }
