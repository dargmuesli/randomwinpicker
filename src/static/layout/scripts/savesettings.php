<?php
    session_start();

    require_once $_SERVER['SERVER_ROOT'] . '/layout/scripts/dotenv.php';

    $dbh = new PDO('pgsql:host='.$_ENV['PGSQL_HOST'].';port='.$_ENV['PGSQL_PORT'].';dbname='.$_ENV['PGSQL_DATABASE'], $_ENV['PGSQL_USERNAME'], $_ENV['PGSQL_PASSWORD']);

    $form = $_GET['form'];

    if (isset($_COOKIE['email'])) {
        $email = $_COOKIE['email'];
    } else {
        $email = $_SESSION['email'];
    }

    $stmt = $dbh->prepare("SELECT storage FROM accounts WHERE mail='" . $email . "'");

    if (!$stmt->execute()) {
        throw new Exception($stmt->errorInfo()[2]);
    }

    $storage = $stmt->fetch()[0];

    if ($form == 'privacyForm') {
        $stmt = $dbh->prepare("UPDATE accounts SET privacy='" . $_POST['privacy'] . "' WHERE mail='" . $email . "'");

        if (!$stmt->execute()) {
            throw new Exception($stmt->errorInfo()[2]);
        }
    } elseif ($form == 'viewForm') {
        $stmt = $dbh->prepare("UPDATE accounts SET view='" . $_POST['view'] . "' WHERE mail='" . $email . "'");

        if (!$stmt->execute()) {
            throw new Exception($stmt->errorInfo()[2]);
        }
        $_SESSION['view'] = $_POST['view'];
        if ($storage == 'Cookies') {
            setcookie('view', $_POST['view'], time() + (60 * 60 * 24 * 365), '/');
        }
    } elseif ($form == 'storageForm') {
        $stmt = $dbh->prepare("UPDATE accounts SET storage='" . $_POST['storage'] . "' WHERE mail='" . $email . "'");

        if (!$stmt->execute()) {
            throw new Exception($stmt->errorInfo()[2]);
        }
    } elseif ($form == 'youtubeForm') {
        $stmt = $dbh->prepare("UPDATE accounts SET youtube='" . $_POST['youtube'] . "' WHERE mail='" . $email . "'");

        if (!$stmt->execute()) {
            throw new Exception($stmt->errorInfo()[2]);
        }
    } elseif ($form == 'encodingForm') {
        $stmt = $dbh->prepare("UPDATE accounts SET encoding='" . $_POST['encoding'] . "' WHERE mail='" . $email . "'");

        if (!$stmt->execute()) {
            throw new Exception($stmt->errorInfo()[2]);
        }
    } elseif ($form == 'priceForm') {
        if ($_POST['prices'] == 'true') {
            $stmt = $dbh->prepare("UPDATE accounts SET prices='TRUE' WHERE mail='" . $email . "'");

            if (!$stmt->execute()) {
                throw new Exception($stmt->errorInfo()[2]);
            }
        } else {
            $stmt = $dbh->prepare("UPDATE accounts SET prices='FALSE' WHERE mail='" . $email . "'");

            if (!$stmt->execute()) {
                throw new Exception($stmt->errorInfo()[2]);
            }
            var_dump($_SESSION);
        }
    }
