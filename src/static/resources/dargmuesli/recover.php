<?php
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }

    include_once $_SERVER['DOCUMENT_ROOT'].'/resources/dargmuesli/database/pdo.php';
    include_once $_SERVER['DOCUMENT_ROOT'].'/resources/dargmuesli/filesystem/environment.php';
    include_once $_SERVER['DOCUMENT_ROOT'].'/resources/dargmuesli/mail.php';
    include_once $_SERVER['DOCUMENT_ROOT'].'/resources/dargmuesli/translation/translations.php';

    // Load .env file
    load_env_file($_SERVER['SERVER_ROOT'].'/credentials');

    // Get database handle
    $dbh = get_dbh($_ENV['PGSQL_DATABASE']);
    $dieLocation = getenv('BASE_URL').'/accounts/recovery/';

    // Get the URL parameters
    $task = $_GET['task'];

    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Initialize the required table
    init_table($dbh, 'accounts');

    if ($task == 'recover') {
        $code = rand();
        $email = $_POST['email'];
        $link = $_SERVER['SERVER_ROOT_URL'].'accounts/reset/?email=' . $email . '&amp;code=' . $code;

        $file = file_get_contents($_SERVER['DOCUMENT_ROOT'].'/resources/dargmuesli/packages/composer/phpmailer/phpmailer/templates/reset_'.get_language().'.html');
        $serverRootUrl = $_SERVER['SERVER_ROOT_URL'];

        $string_processed = preg_replace_callback('~\{\$(.*?)\}~si', function ($match) use ($email, $link, $serverRootUrl) {
            return eval('return $' . $match[1] . ';');
        }, $file);

        // Check if entry already exists
        $stmt = $dbh->prepare('SELECT code FROM accounts WHERE mail = :email');
        $stmt->bindParam(':email', $email);

        if (!$stmt->execute()) {
            throw new PDOException($stmt->errorInfo()[2]);
        }

        $row = $stmt->fetch()[0];

        if (!$row) {
            // User doesn't exist
            $_SESSION['error'] = translate('scripts.recover.existence.error');
        } elseif ($row == -1) {
            // Send an email for confirmation
            $mail = get_mailer(
                $email,
                'Reset your password!',
                $string_processed,
                'Hey ' . $email . ', to reset your password and regain access to all features of RandomWinPicker, copy the link below and open it in any browser!' . $link
            );

            // Set the redirect
            if (!$mail->send()) {
                $_SESSION['error'] = translate('scripts.recover.email.error');
            } else {
                // Mark the user as invalid
                $stmt = $dbh->prepare('UPDATE accounts SET code = :code WHERE mail = :email');
                $stmt->bindParam(':code', $code);
                $stmt->bindParam(':email', $email);

                if (!$stmt->execute()) {
                    throw new PDOException($stmt->errorInfo()[2]);
                }

                $_SESSION['success'] = translate('scripts.recover.email.success');
            }
        } else {
            $_SESSION['error'] = strtr(translate('scripts.recover.activation.error'), array('%email' => $email));
        }
    } elseif ($task == 'reset') {
        // Get the URL parameters
        $email = $_GET['email'];
        $password = $_POST['password'];
        $code = $_GET['code'];

        // Hash the password with salt
        $hash = sodium_crypto_pwhash_str(
            $password,
            SODIUM_CRYPTO_PWHASH_OPSLIMIT_INTERACTIVE,
            SODIUM_CRYPTO_PWHASH_MEMLIMIT_INTERACTIVE
        );

        $stmt = $dbh->prepare('SELECT code FROM accounts WHERE mail = :email');
        $stmt->bindParam(':email', $email);

        if (!$stmt->execute()) {
            throw new PDOException($stmt->errorInfo()[2]);
        }

        // Get database's code element
        $row = $stmt->fetch()[0];

        // Check if database's and parameter's code is equal
        if ($row == $code) {
            // Mark the user as validated
            $stmt = $dbh->prepare('UPDATE accounts SET code = -1 WHERE mail = :email');
            $stmt->bindParam(':email', $email);

            if (!$stmt->execute()) {
                throw new PDOException($stmt->errorInfo()[2]);
            }

            // Update the users password hash
            $stmt = $dbh->prepare('UPDATE accounts SET hash = :hash WHERE mail = :email');
            $stmt->bindParam(':hash', $hash);
            $stmt->bindParam(':email', $email);

            if (!$stmt->execute()) {
                throw new PDOException($stmt->errorInfo()[2]);
            }

            $_SESSION['success'] = translate('scripts.recover.reset.success');

            $dieLocation = '../../accounts/';
        } else {
            $_SESSION['error'] = translate('scripts.recover.reset.error');
        }
    }

    // Redirect accordingly
    die(header('Location:' . $dieLocation));
