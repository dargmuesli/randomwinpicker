<?php
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }

    // References
    include_once $_SERVER['DOCUMENT_ROOT'].'/resources/dargmuesli/database/pdo.php';
    include_once $_SERVER['DOCUMENT_ROOT'].'/resources/dargmuesli/filesystem/environment.php';
    include_once $_SERVER['DOCUMENT_ROOT'].'/resources/dargmuesli/mail.php';
    include_once $_SERVER['DOCUMENT_ROOT'].'/resources/dargmuesli/translation/translations.php';

    // Load .env file
    load_env_file($_SERVER['SERVER_ROOT'].'/credentials');

    // Get database handle
    $dbh = get_dbh($_ENV['PGSQL_DATABASE']);

    $dieLocation = '../../accounts/';

    // Get the URL parameters
    $task = $_GET['task'];
    $email = $_GET['email'];

    // Initialize the required table
    init_table($dbh, 'accounts');

    if ($task == 'resend') {
        $stmt = $dbh->prepare('SELECT code FROM accounts WHERE mail = :email');
        $stmt->bindParam(':email', $email);

        if (!$stmt->execute()) {
            throw new PDOException($stmt->errorInfo()[2]);
        }

        // Get database's code element
        $code = $stmt->fetch()[0];

        if ($code != -1) { // && ($code != -2) {
            $link = $_SERVER['SERVER_ROOT_URL'].'resources/dargmuesli/validation.php?task=validate&email='.$email.'&code='.$code;

            $file = file_get_contents($_SERVER['DOCUMENT_ROOT'].'/resources/dargmuesli/packages/composer/phpmailer/phpmailer/templates/confirm_'.get_language().'.html');
            $serverRootUrl = $_SERVER['SERVER_ROOT_URL'];

            $string_processed = preg_replace_callback('~\{\$(.*?)\}~si', function ($match) use ($email, $link, $serverRootUrl) {
                return eval('return $' . $match[1] . ';');
            }, $file);

            // Send an email for confirmation
            $mail = get_mailer(
                $email,
                'Confirm your email address!',
                $string_processed,
                'Hey ' . $email . ', to confirm your email and gain access to all features of RandomWinPicker, copy the link below and open it in any browser!' . $link
            );

            // Set the redirect
            if ($mail->send()) {
                $_SESSION['success'] = translate('scripts.validation.resend.success');
            } else {
                $_SESSION['error'] = translate('scripts.validation.resend.error');
            }
        }
    } elseif ($task == 'delete') {
        // Delete account
        $stmt = $dbh->prepare('DELETE FROM accounts WHERE mail = :email AND code<>-1');
        $stmt->bindParam(':email', $email);

        if (!$stmt->execute()) {
            throw new PDOException($stmt->errorInfo()[2]);
        }

        $_SESSION['success'] = translate('scripts.validation.delete.success');
    } elseif ($task == 'validate') {
        $code = $_GET['code'];

        // Get database's code element
        $stmt = $dbh->prepare('SELECT code FROM accounts WHERE mail = :email');
        $stmt->bindParam(':email', $email);

        if (!$stmt->execute()) {
            throw new PDOException($stmt->errorInfo()[2]);
        }

        $row = $stmt->fetch()[0];

        // Check if database's and parameter's code is equal
        if ($row == $code) {
            // Mark the user as validated
            $stmt = $dbh->prepare('UPDATE accounts SET code = -1 WHERE mail = :email');
            $stmt->bindParam(':email', $email);

            if (!$stmt->execute()) {
                throw new PDOException($stmt->errorInfo()[2]);
            }
            $_SESSION['success'] = translate('scripts.validation.validate.success');

            $code = 0;
        } elseif ($row == null) {
            $_SESSION['error'] = translate('scripts.validation.validate.error.inexistent');
        } else {
            $_SESSION['error'] = strtr(translate('scripts.validation.validate.error.general'), array('%email' => $email));

            $dieLocation = getenv('BASE_URL').'/accounts/?email=' . $email;

            $code = 0;
        }
    }

    // Redirect accordingly
    die(header('Location: ' . $dieLocation));
