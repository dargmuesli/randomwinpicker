<?php
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }

    include_once $_SERVER['DOCUMENT_ROOT'].'/resources/dargmuesli/database/pdo.php';
    include_once $_SERVER['DOCUMENT_ROOT'].'/resources/dargmuesli/filesystem/environment.php';
    include_once $_SERVER['DOCUMENT_ROOT'].'/resources/dargmuesli/mail.php';

    // Load .env file
    load_env_file($_SERVER['SERVER_ROOT'].'/credentials');

    // Get database handle
    $dbh = get_dbh($_ENV['PGSQL_DATABASE']);

    $user = $_GET['email'];

    // Initialize the required table
    init_table($dbh, 'accounts');

    $stmt = $dbh->prepare('SELECT privacy FROM accounts WHERE mail = :mail');
    $stmt->bindParam(':mail', $user);

    if (!$stmt->execute()) {
        throw new PDOException($stmt->errorInfo()[2]);
    }

    // Entry already exists
    $privacy = $stmt->fetch()[0];

    if ($privacy != 'E-mail address') {
        $user = '<a href="mailto:' . $user . '" title="' . $privacy . '">' . $privacy . '</a>';
    }

    $fileOrig = $_GET['file'];

    $file = htmlspecialchars_decode(utf8_decode(htmlentities($fileOrig, ENT_COMPAT, 'UTF-8', false)));
    $nameOrig = $_POST['name'];
    $name = htmlspecialchars_decode(utf8_decode(htmlentities($nameOrig, ENT_COMPAT, 'UTF-8', false)));

    $link = $_GET['link'];

    $image = $_POST['image'];
    $quality = $_POST['quality'];
    $type = $_POST['type'];

    $newFile = '{' . PHP_EOL;
    $newFile .= "\t" . '"name": "' . $nameOrig . '",' . PHP_EOL;
    $newFile .= "\t" . '"url": "' . $image . '",' . PHP_EOL;
    $newFile .= "\t" . '"quality": "' . $quality . '",' . PHP_EOL;
    $newFile .= "\t" . '"type": "' . $type . '"' . PHP_EOL;
    $newFile .= '}';

    file_put_contents('../filetree/categories' . $fileOrig, $newFile);

    $htmlFile = file_get_contents('..//resources/dargmuesli/packages/composer/phpmailer/phpmailer/templates/contribute.html');
    $string_processed = preg_replace_callback('~\{\$(.*?)\}~si', function ($match) use ($user, $file, $name, $link, $image, $quality, $type) {
        return eval('return $' . $match[1] . ';');
    }, $htmlFile);

    $mail = get_mailer(
        'e-mail@randomwinpicker.de',
        'New item contribution!',
        $string_processed,
        'A new item edit was submitted. Please check ASAP. File: ' . $file
    );

    if (!$mail->send()) {
        $_SESSION['error'] = 'Item edited incorrectly!';
    } else {
        $_SESSION['success'] = 'Item successfully edited. List will update.';
    }

    $_SESSION['reload'] = true;
    die(header('location:items.php'));
