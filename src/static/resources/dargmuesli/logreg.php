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

    $securimage = new Securimage();

    $task = $_GET['task'];
    $dieLocation = '';

    if (isset($_SERVER['HTTP_REFERER']) && $_SERVER['HTTP_REFERER'] != '' && $_SERVER['HTTP_REFERER'] != $_SERVER['SERVER_ROOT_URL'].'/accounts/profile/') {
        $dieLocation = $_SERVER['HTTP_REFERER'];
    } else {
        $dieLocation = getenv('BASE_URL').'/accounts/';
    }

    function newEntry($email, $dbh, $hash) {
        // Entry doesn't exist
        $code = rand();
        $link = $_SERVER['SERVER_ROOT_URL'].'/resources/dargmuesli/validation.php?task=validate&email=' . $email . '&code=' . $code;

        $file = file_get_contents($_SERVER['DOCUMENT_ROOT'].'/resources/dargmuesli/packages/composer/phpmailer/phpmailer/templates/confirm_'.get_language().'.html');
        $serverRootUrl = $_SERVER['SERVER_ROOT_URL'];

        $string_processed = preg_replace_callback('~\{\$(.*?)\}~si', function ($match) use ($email, $link, $serverRootUrl) {
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
            $_SESSION['error'] = translate('scripts.logreg.in.email.error');
        } else {
            $_SESSION['success'] = translate('scripts.logreg.in.email.success');
            $_SESSION['error'] = translate('scripts.logreg.in.email.success-error');

            // Send an email for confirmation
            $mailDev = get_mailer(
                'e-mail@randomwinpicker.de',
                'New account registered!',
                'E-mail address: ' . $email
            );

            $mailDev->send();
        }
    }

    if ($task == 'out') {
        $_SESSION['email'] = null;
        $_SESSION['hash'] = null;

        setcookie('email', '', time() - 3600, '/');
        setcookie('hash', '', time() - 3600, '/');

        $_SESSION['success'] = translate('scripts.logreg.out.success');
    } elseif ($task == 'in') {
        if (isset($_POST['captcha_code']) && $securimage->check($_POST['captcha_code']) == false) {
            // Print error message
            $_SESSION['error'] = translate('scripts.logreg.in.captcha.error');
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

                $fetch = $stmt->fetch();

                if (!$fetch) {
                    newEntry($email, $dbh, $hash);
                } else {
                    $row = $fetch[0];

                    if (!$row) {
                        newEntry($email, $dbh, $hash);
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
                            $_SESSION['error'] = translate('scripts.logreg.in.password.error');
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

                                $_SESSION['success'] = translate('scripts.logreg.in.success');
                            } else {
                                $_SESSION['error'] = strtr(translate('scripts.logreg.in.incomplete.error'), array('%email' => $email));
                            }
                        }
                    }
                }
            }
        }
    }

    // Redirect accordingly
    die(header('location:' . $dieLocation));
