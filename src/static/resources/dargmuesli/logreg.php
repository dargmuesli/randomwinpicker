<?php
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }

    // References
    include_once $_SERVER['DOCUMENT_ROOT'].'/resources/dargmuesli/database/pdo.php';
    include_once $_SERVER['DOCUMENT_ROOT'].'/resources/dargmuesli/filesystem/environment.php';
    include_once $_SERVER['DOCUMENT_ROOT'].'/resources/dargmuesli/mail.php';

    // Load .env file
    load_env_file($_SERVER['SERVER_ROOT'].'/credentials');

    // Get database handle
    $dbh = get_dbh($_ENV['PGSQL_DATABASE']);

    $securimage = new Securimage();

    if (isset($_SESSION['lang'])) {
        $lang = $_SESSION['lang'];
    } else {
        $lang = substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2);
    }
    $task = $_GET['task'];

    if (isset($_SERVER['HTTP_REFERER']) && $_SERVER['HTTP_REFERER'] != '' && $_SERVER['HTTP_REFERER'] != $_SERVER['SERVER_ROOT_URL'].'/accounts/profile.php') {
        $dieLocation = $_SERVER['HTTP_REFERER'];
    } else {
        $dieLocation = '../../accounts/';
    }

    if ($task == 'out') {
        $_SESSION['email'] = null;
        $_SESSION['hash'] = null;

        setcookie('email', '', time() - 3600, '/');
        setcookie('hash', '', time() - 3600, '/');

        switch ($lang) {
            case 'de':
                $_SESSION['success'] = 'Erfolgreich abgemeldet.';
                break;
            default:
                $_SESSION['success'] = 'Logout successful.';
                break;
        }
    } elseif ($task == 'in') {
        if (isset($_POST['captcha_code']) && $securimage->check($_POST['captcha_code']) == false) {
            // Print error message
            switch ($lang) {
                case 'de':
                    $_SESSION['error'] = 'Captcha falsch!';
                    break;
                default:
                    $_SESSION['error'] = 'Captcha incorrect!';
                    break;
            }
        } else {
            // Create variables for each form item
            $email = $_POST['email'];
            $password = $_POST['password'];

            if (isset($email) && isset($password)) {
                // Hash the password with salt
                $hash = password_hash(
                    $password,
                    PASSWORD_ARGON2I
                );

                // Initialize the required table
                init_table($dbh, 'accounts');

                // Check if entry already exists
                $stmt = $dbh->prepare('SELECT * FROM accounts WHERE mail = :email');
                $stmt->bindParam(':email', $email);

                if (!$stmt->execute()) {
                    throw new PDOException($stmt->errorInfo()[2]);
                }

                $row = $stmt->fetch()[0];

                if (!$row) {
                    // Entry doesn't exist
                    $code = rand();
                    $link = $_SERVER['SERVER_ROOT_URL'].'/resources/dargmuesli/validation.php?task=validate&email=' . $email . '&code=' . $code;

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

                    // Insert the form values into the database
                    $stmt = $dbh->prepare('INSERT INTO accounts(mail, hash, code) VALUES (:email, :hash, :code)');
                    $stmt->bindParam(':email', $email);
                    $stmt->bindParam(':hash', $hash);
                    $stmt->bindParam(':code', $code);

                    if (!$stmt->execute()) {
                        throw new PDOException($stmt->errorInfo()[2]);
                    }

                    // Send an email for confirmation
                    $mail = get_mailer(
                        $email,
                        'Confirm your email address!',
                        $string_processed,
                        'Hey ' . $email . ', to confirm your email and gain access to all features of RandomWinPicker, copy the link below and open it in any browser!' . $link
                    );

                    // Send the mail
                    if (!$mail->send()) {
                        switch ($lang) {
                            case 'de':
                                $_SESSION['error'] = 'E-Mail konnte nicht versendet werden!';
                                break;
                            default:
                                $_SESSION['error'] = 'Email could not be send!';
                                break;
                        }
                    } else {
                        switch ($lang) {
                            case 'de':
                                $_SESSION['success'] = 'Erfolgreich registriert.';
                                $_SESSION['error'] = 'Du musst noch deine E-Mail-Adresse bestätigen!';
                                break;
                            default:
                                $_SESSION['success'] = 'Registered successfully.';
                                $_SESSION['error'] = 'You still need to validate your email address!';
                                break;
                        }

                        // Send an email for confirmation
                        $mailDev = get_mailer(
                            'e-mail@randomwinpicker.de',
                            'New account registered!',
                            'E-mail address: ' . $email
                        );

                        $mailDev->send();
                    }
                } else {
                    // Entry already exists
                    $stmt = $dbh->prepare('SELECT hash FROM accounts WHERE mail = :email');
                    $stmt->bindParam(':email', $email);

                    if (!$stmt->execute()) {
                        throw new PDOException($stmt->errorInfo()[2]);
                    }

                    $hash = $stmt->fetch()[0];

                    // Check if password is correct
                    if (password_verify($password, $hash) == false) {
                        switch ($lang) {
                            case 'de':
                                $_SESSION['error'] = 'Falsches Passwort!';
                                break;
                            default:
                                $_SESSION['error'] = 'Wrong Password!';
                                break;
                        }
                    } else {
                        $stmt = $dbh->prepare('SELECT code FROM accounts WHERE mail = :email');
                        $stmt->bindParam(':email', $email);

                        if (!$stmt->execute()) {
                            throw new PDOException($stmt->errorInfo()[2]);
                        }

                        $row = $stmt->fetch()[0];

                        if ($row == -1) {
                            $stmt = $dbh->prepare('SELECT view FROM accounts WHERE mail = :email');
                            $stmt->bindParam(':email', $email);

                            if (!$stmt->execute()) {
                                throw new PDOException($stmt->errorInfo()[2]);
                            }

                            $view = $stmt->fetch()[0];

                            $_SESSION['email'] = $email;
                            $_SESSION['hash'] = $hash;
                            $_SESSION['view'] = $view;

                            if ((isset($_POST['save'])) && ($_POST['save'] == 'on')) {
                                setcookie('email', $email, time() + (60 * 60 * 24 * 365), '/');
                                setcookie('hash', $hash, time() + (60 * 60 * 24 * 365), '/');
                                setcookie('view', $view, time() + (60 * 60 * 24 * 365), '/');
                            }

                            switch ($lang) {
                                case 'de':
                                    $_SESSION['success'] = 'Erfolgreich angemeldet.';
                                    break;
                                default:
                                    $_SESSION['success'] = 'Login successful.';
                                    break;
                            }
                        } else {
                            switch ($lang) {
                                case 'de':
                            $_SESSION['error'] = 'Bestätigung unvollständig! <a href="/resources/dargmuesli/validation.php?task=resend&email=' . $email . '" title="Bestätigungsmail neu versenden">E-Mail neu versenden</a> oder <a href="/resources/dargmuesli/validation.php?task=delete&email=' . $email . '" title="Diese Anfrage löschen">diese Anfrage löschen</a>.';
                                    break;
                                default:
                            $_SESSION['error'] = 'Validation incomplete! <a href="/resources/dargmuesli/validation.php?task=resend&email=' . $email . '" title="Resend the validation email">Resend the email</a> or <a href="/resources/dargmuesli/validation.php?task=delete&email=' . $email . '" title="Delete this request">delete this request</a>.';
                                    break;
                            }
                        }
                    }
                }
            }
        }
    }

    // Redirect accordingly
    die(header('location:' . $dieLocation));
