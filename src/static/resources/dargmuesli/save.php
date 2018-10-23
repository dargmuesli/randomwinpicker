<?php
    session_start();

    require_once $_SERVER['DOCUMENT_ROOT'] . '/resources/dargmuesli/database/pdo.php';
    require_once $_SERVER['DOCUMENT_ROOT'] . '/resources/dargmuesli/filesystem/environment.php';

    // Load .env file
    load_env_file($_SERVER['SERVER_ROOT'].'/credentials');

    // Get database handle
    $dbh = get_dbh($_ENV['PGSQL_DATABASE']);

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
