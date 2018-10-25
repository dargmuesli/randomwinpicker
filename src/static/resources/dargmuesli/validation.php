<?php
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }

    if (isset($_SESSION['lang'])) {
        $lang = $_SESSION['lang'];
    } else {
        $lang = substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2);
    }

    // References
    include_once $_SERVER['DOCUMENT_ROOT'].'/resources/dargmuesli/database/pdo.php';
    include_once $_SERVER['DOCUMENT_ROOT'].'/resources/dargmuesli/filesystem/environment.php';
    include_once $_SERVER['DOCUMENT_ROOT'].'/resources/dargmuesli/mail.php';

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
            $link = $_SERVER['SERVER_ROOT_URL'].'/resources/dargmuesli/validation.php?task=validate&email=$email&code=$code';

            switch ($lang) {
                case 'de':
                    $file = file_get_contents($_SERVER['DOCUMENT_ROOT'].'/resources/dargmuesli/packages/composer/phpmailer/phpmailer/templates/confirm_de.html');
                    break;
                default:
                    $file = file_get_contents($_SERVER['DOCUMENT_ROOT'].'/resources/dargmuesli/packages/composer/phpmailer/phpmailer/templates/confirm_en.html');
                    break;
            }

            $string_processed = preg_replace_callback('~\{\$(.*?)\}~si', function ($match) use ($email, $link) {
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
            switch ($lang) {
                case 'de':
                    if (!$mail->send()) {
                        $_SESSION['error'] = 'E-Mail konnte nicht versendet werden!';
                    } else {
                        $_SESSION['success'] = 'E-Mail wurde erfolgreich versendet.';
                    }

                    break;
                default:
                    if (!$mail->send()) {
                        $_SESSION['error'] = 'Email could not be sent!';
                    } else {
                        $_SESSION['success'] = 'Email sent successfully.';
                    }

                    break;
            }
        }
    } elseif ($task == 'delete') {
        // Delete account
        $stmt = $dbh->prepare('DELETE FROM accounts WHERE mail = :email AND code<>-1');
        $stmt->bindParam(':email', $email);

        if (!$stmt->execute()) {
            throw new PDOException($stmt->errorInfo()[2]);
        }

        switch ($lang) {
            case 'de':
                $_SESSION['success'] = 'Anfrage erfolgreich gelöscht.';
                break;
            default:
                $_SESSION['success'] = 'Request successfully deleted.';
                break;
        }
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

            switch ($lang) {
                case 'de':
                    $_SESSION['success'] = 'Bestätigung erfolgreich.';
                    break;
                default:
                    $_SESSION['success'] = 'Validation successful.';
                    break;
            }

            $code = 0;
        } elseif ($row == null) {
            switch ($lang) {
                case 'de':
                    $_SESSION['error'] = 'Bestätigung fehlgeschlagen! Benutzer existiert nicht.';
                    break;
                default:
                    $_SESSION['error'] = 'Validation went wrong! User does not exist.';
                    break;
            }
        } else {
            switch ($lang) {
                case 'de':
                    $_SESSION['error'] = 'Bestätigung fehlgeschlagen! <a href="/resources/dargmuesli/validation.php?task=resend&email=' . $email . '" title="Bestätigungsmail neu versenden">E-Mail neu versenden</a> oder <a href="/resources/dargmuesli/validation.php?task=delete&email=' . $email . '" title="Diese Anfrage löschen">diese Anfrage löschen</a>.';
                    break;
                default:
                    $_SESSION['error'] = 'Validation went wrong! <a href="/resources/dargmuesli/validation.php?task=resend&email=' . $email . '" title="Resend the validation email">Resend the email</a> or <a href="/resources/dargmuesli/validation.php?task=delete&email=' . $email . '" title="Delete this request">delete this request</a>.';
                    break;
            }

            $dieLocation = '../../accounts/?email=' . $email;

            $code = 0;
        }
    }

    // Redirect accordingly
    die(header('Location: ' . $dieLocation));
