<?php
    session_start();

    require_once $_SERVER['SERVER_ROOT'] . '/layout/scripts/dotenv.php';
    require_once $_SERVER['SERVER_ROOT'] . '/layout/scripts/mail.php';

    $dbh = new PDO("pgsql:host=".$_ENV['PGSQL_HOST'].";port=".$_ENV['PGSQL_PORT'].";dbname=randomwinpicker.de", $_ENV['PGSQL_USERNAME'], $_ENV['PGSQL_PASSWORD']);

    $user = $_GET['email'];

    $stmt = $dbh->prepare("SELECT privacy FROM accounts WHERE mail='" . $user . "'");
    
    if (!$stmt->execute()) {
        throw new Exception($stmt->errorInfo()[2]);
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

    $htmlFile = file_get_contents('../../resources/dargmuesli/packages/composer/phpmailer/phpmailer/templates/contribute.html');
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
