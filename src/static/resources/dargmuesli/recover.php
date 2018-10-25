<?php
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }

    include_once $_SERVER['DOCUMENT_ROOT'].'/resources/dargmuesli/filesystem/environment.php';
    include_once $_SERVER['DOCUMENT_ROOT'].'/resources/dargmuesli/mail.php';

    if (isset($_SESSION['lang'])) {
        $lang = $_SESSION['lang'];
    } else {
        $lang = substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2);
    }

    // Load .env file
    load_env_file($_SERVER['SERVER_ROOT'].'/credentials');

    // Get database handle
    $dbh = get_dbh($_ENV['PGSQL_DATABASE']);
    $dieLocation = '../../accounts/recovery.php';

    // Get the URL parameters
    $task = $_GET['task'];

    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Initialize the required table
    init_table($dbh, 'accounts');

    if ($task == 'recover') {
        $code = rand();
        $email = $_POST['email'];
        $link = $_SERVER['SERVER_ROOT_URL'].'/accounts/reset.php?email=' . $email . '&code=' . $code;

        switch ($lang) {
            case 'de':
                $file = file_get_contents('..//resources/dargmuesli/packages/composer/phpmailer/phpmailer/templates/reset_de.html');
                break;
            default:
                $file = file_get_contents('..//resources/dargmuesli/packages/composer/phpmailer/phpmailer/templates/reset_en.html');
                break;
        }

        $string_processed = preg_replace_callback('~\{\$(.*?)\}~si', function ($match) use ($email, $link) {
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
            switch ($lang) {
                case 'de':
                    $_SESSION['error'] = 'Benutzer existiert nicht!';
                    break;
                default:
                    $_SESSION['error'] = 'User does not exist!';
                    break;
            }
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
                switch ($lang) {
                    case 'de':
                        $_SESSION['error'] = 'E-Mail konnte nicht versendet werden!';
                        break;
                    default:
                        $_SESSION['error'] = 'Email could not be sent!';
                        break;
                }
            } else {
                // Mark the user as invalid
                $stmt = $dbh->prepare('UPDATE accounts SET code = :code WHERE mail = :email');
                $stmt->bindParam(':code', $code);
                $stmt->bindParam(':email', $email);

                if (!$stmt->execute()) {
                    throw new PDOException($stmt->errorInfo()[2]);
                }

                switch ($lang) {
                    case 'de':
                        $_SESSION['success'] = 'E-Mail wurde erfolgreich versendet.';
                        break;
                    default:
                        $_SESSION['success'] = 'Email sent successfully.';
                        break;
                }
            }
        } else {
            switch ($lang) {
                case 'de':
                    $_SESSION['error'] = 'Account wurde noch nicht aktiviert! <a href="/resources/dargmuesli/validation.php?task=delete&email=' . $email . '" title="Diese Anfrage löschen">Diese Anfrage löschen</a>.';
                    break;
                default:
                    $_SESSION['error'] = 'Accuont was not activated yet! <a href="/resources/dargmuesli/validation.php?task=delete&email=' . $email . '" title="Delete this request">delete this request</a>.';
                    break;
            }
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

            switch ($lang) {
                case 'de':
                    $_SESSION['success'] = 'Passwort erfolgreich geändert.';
                    break;
                default:
                    $_SESSION['success'] = 'Password changed successfully.';
                    break;
            }

            $dieLocation = '../../accounts/';
        } else {
            switch ($lang) {
                case 'de':
                    $_SESSION['error'] = 'Passwort konnte nicht geändert werden!';
                    break;
                default:
                    $_SESSION['error'] = 'Password could not be changed!';
                    break;
            }
        }
    }

    // Redirect accordingly
    die(header('Location:' . $dieLocation));
