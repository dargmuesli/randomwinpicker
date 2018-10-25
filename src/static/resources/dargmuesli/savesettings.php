<?php
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }

    include_once $_SERVER['DOCUMENT_ROOT'].'/resources/dargmuesli/filesystem/environment.php';

    // Load .env file
    load_env_file($_SERVER['SERVER_ROOT'].'/credentials');

    // Get database handle
    $dbh = get_dbh($_ENV['PGSQL_DATABASE']);

    $form = $_GET['form'];

    if (isset($_COOKIE['email'])) {
        $email = $_COOKIE['email'];
    } else {
        $email = $_SESSION['email'];
    }

    // Initialize the required table
    init_table($dbh, 'accounts');

    $stmt = $dbh->prepare('SELECT storage FROM accounts WHERE mail = :email');
    $stmt->bindParam(':email', $email);

    if (!$stmt->execute()) {
        throw new PDOException($stmt->errorInfo()[2]);
    }

    $storage = $stmt->fetch()[0];

    if ($form == 'privacyForm') {
        $stmt = $dbh->prepare('UPDATE accounts SET privacy = :privacy WHERE mail = :email');
        $stmt->bindParam(':privacy', $_POST['privacy']);
        $stmt->bindParam(':email', $email);

        if (!$stmt->execute()) {
            throw new PDOException($stmt->errorInfo()[2]);
        }
    } elseif ($form == 'viewForm') {
        $stmt = $dbh->prepare('UPDATE accounts SET view = :view WHERE mail = :email');
        $stmt->bindParam(':view', $_POST['view']);
        $stmt->bindParam(':email', $email);

        if (!$stmt->execute()) {
            throw new PDOException($stmt->errorInfo()[2]);
        }
        $_SESSION['view'] = $_POST['view'];
        if ($storage == 'Cookies') {
            setcookie('view', $_POST['view'], time() + (60 * 60 * 24 * 365), '/');
        }
    } elseif ($form == 'storageForm') {
        $stmt = $dbh->prepare('UPDATE accounts SET storage = :storage WHERE mail = :email');
        $stmt->bindParam(':storage', $_POST['storage']);
        $stmt->bindParam(':email', $email);

        if (!$stmt->execute()) {
            throw new PDOException($stmt->errorInfo()[2]);
        }
    } elseif ($form == 'youtubeForm') {
        $stmt = $dbh->prepare('UPDATE accounts SET youtube = :youtube WHERE mail = :email');
        $stmt->bindParam(':youtube', $_POST['youtube']);
        $stmt->bindParam(':email', $email);

        if (!$stmt->execute()) {
            throw new PDOException($stmt->errorInfo()[2]);
        }
    } elseif ($form == 'encodingForm') {
        $stmt = $dbh->prepare('UPDATE accounts SET encoding = :encoding WHERE mail = :email');
        $stmt->bindParam(':encoding', $_POST['encoding']);
        $stmt->bindParam(':email', $email);

        if (!$stmt->execute()) {
            throw new PDOException($stmt->errorInfo()[2]);
        }
    } elseif ($form == 'priceForm') {
        if ($_POST['prices'] == 'true') {
            $stmt = $dbh->prepare('UPDATE accounts SET prices = true WHERE mail = :email');
            $stmt->bindParam(':email', $email);

            if (!$stmt->execute()) {
                throw new PDOException($stmt->errorInfo()[2]);
            }
        } else {
            $stmt = $dbh->prepare('UPDATE accounts SET prices = false WHERE mail = :email');
            $stmt->bindParam(':email', $email);

            if (!$stmt->execute()) {
                throw new PDOException($stmt->errorInfo()[2]);
            }
            var_dump($_SESSION);
        }
    }
