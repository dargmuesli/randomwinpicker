<?php
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }

    include_once $_SERVER['DOCUMENT_ROOT'].'/resources/dargmuesli/database/pdo.php';
    include_once $_SERVER['DOCUMENT_ROOT'].'/resources/dargmuesli/filesystem/environment.php';

    // Load .env file
    load_env_file($_SERVER['SERVER_ROOT'].'/credentials');

    // Get database handle
    $dbh = get_dbh($_ENV['PGSQL_DATABASE']);

    $participants = null;

    if (isset($email) && isset($_COOKIE['participants'])) {
        if (count($_COOKIE['participants']) > 0) {
            $participants = $_COOKIE['participants'];
        }
    } elseif (isset($_SESSION['participants'])) {
        if (count($_SESSION['participants']) > 0) {
            $participants = $_SESSION['participants'];
        }
    }

    $items = null;

    if (isset($email) && isset($_COOKIE['items'])) {
        if (count($_COOKIE['items']) > 0) {
            $items = $_COOKIE['items'];
        }
    } elseif (isset($_SESSION['items'])) {
        if (count($_SESSION['items']) > 0) {
            $items = $_SESSION['items'];
        }
    }

    if (sizeof($participants) < sizeof($items)) {
        switch ($lang) {
            case 'de':
                $_SESSION['error'] = 'Zu viele Gewinne für zu wenig Teilnehmer! Wer soll das alles gewinnen?!';
                break;
            default:
                $_SESSION['error'] = 'Too many items for too few participants! Who shall win all that?!';
                break;
        }
    }

    if (is_array($participants)) {
        $participants = htmlspecialchars_decode(json_encode($participants), ENT_NOQUOTES);
    }

    if (is_array($items)) {
        $items = htmlspecialchars_decode(json_encode($items), ENT_NOQUOTES);
    }

    $quantity = -1;

    if (isset($_SESSION['quantity'])) {
        $quantity = $_SESSION['quantity'];
    }

    $stmt = $dbh->prepare('SELECT prices FROM accounts WHERE mail = :email');
    $stmt->bindParam(':email', $email);

    if (!$stmt->execute()) {
        throw new PDOException($stmt->errorInfo()[2]);
    }

    $pricesQuery = $stmt->fetch()[0];
    $prices = $pricesQuery[0][0];
