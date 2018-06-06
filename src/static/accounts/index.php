<?php
    require_once $_SERVER['SERVER_ROOT'] . '/layout/scripts/sessioncookie.php';
    require_once $_SERVER['SERVER_ROOT'] . '/layout/scripts/dotenv.php';

    $dbh = new PDO('pgsql:host='.$_ENV['PGSQL_HOST'].";port=".$_ENV['PGSQL_PORT'].";dbname=".$_ENV['PGSQL_DATABASE'], $_ENV['PGSQL_USERNAME'], $_ENV['PGSQL_PASSWORD']);

    if (isset($email)) {
        $stmt = $dbh->prepare("SELECT hash FROM accounts WHERE mail='" . $email . "'");

        if (!$stmt->execute()) {
            throw new Exception($stmt->errorInfo()[2]);
        }

        $row = $stmt->fetch()[0];

        if ($hash == $row) {
            $dieLocation = '../dialog/participants.php';
        }
    }

    // Redirect accordingly
    if (isset($dieLocation)) {
        die(header('Location: ' . $dieLocation));
    }
?>
<!DOCTYPE html>
<html lang="<?php echo $lang; ?>" dir="ltr" id="space">
    <head>
        <meta charset="UTF-8">
        <title>
<?php    switch ($lang) {
case 'de':    ?>
            Anmelden - RandomWinPicker
<?php    break;
default:    ?>
            Sign in / up - RandomWinPicker
<?php    break;
    }    ?>
        </title>
        <link rel="canonical" href="https://randomwinpicker.de/accounts" />
        <link rel="icon" href="../layout/icons/favicon.ico" type="image/x-icon" />
        <link rel="stylesheet" href="../layout/stylesheets/fonts.css">
        <link rel="stylesheet" href="../layout/stylesheets/style.css">
        <meta name="author" content="Jonas Thelemann" />
        <meta name="description" content="Login to or register for RandomWinPicker to gain access to all features." />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <meta name="keywords" content="login, register, signin, signup, login, account, password, features, password, access">
        <meta property="og:description" content="Choose a random winner for case openings or similar raffles." />
        <meta property="og:image" content="https://randomwinpicker.de/layout/icons/screenshots/welcome.jpg" />
        <meta property="og:title" content="Welcome - RandomWinPicker" />
        <meta property="og:type" content="website" />
        <meta property="og:url" content="https://randomwinpicker.de/" />
        <script src="../layout/scripts/alert.php"></script>
        <script src="../layout/scripts/bugfeature.php"></script>
        <script src="../layout/scripts/language.php"></script>
<?php    switch ($lang) {
case 'de':    ?>
        <script src='https://www.google.com/recaptcha/api.js?hl=de&amp;render=explicit' async defer></script>
<?php    break;
default:    ?>
        <script src='https://www.google.com/recaptcha/api.js?hl=en&amp;render=explicit' async defer></script>
<?php    break;
    }    ?>
    </head>
    <body>
        <noscript>
            <iframe src="https://www.googletagmanager.com/ns.html?id=GTM-T32JLW" height="0" width="0">
            </iframe>
        </noscript>
        <script src="../layout/scripts/tag.js"></script>
        <div id="dialogoverlay"></div>
        <div id="dialogbox">
            <div>
                <div id="dialogboxhead">
                </div>
                <div id="dialogboxbody">
                </div>
                <div id="dialogboxfoot">
                </div>
            </div>
        </div>
        <header>
<?php
    require_once $_SERVER['SERVER_ROOT'] . '/layout/scripts/warning.php';
    warning($success, $error, $lang, '\t\t\t');
?>
            <div>
                <a href="../" title="Back" id="back">
                    <img src="../layout/icons/arrow.png" alt="Welcome" class="rotate"/>
                </a>
            </div>
        </header>
        <main>
<?php    switch ($lang) {
case 'de':    ?>
            <h1>
                Anmelden
            </h1>
            <p>
                Um auf alle Funktionen dieser Website zugreifen zu können, musst du dich anmelden oder dich registrieren!
            </p>
            <p>
                Ich empfehle Passwort-Manager wie <a href="http://keepass.info/" title="KeePass Password-Manager" target="_blank">KeePass</a>!
                <br>
                Passwörter werden als <a href="https://de.wikipedia.org/wiki/Salt_%28Kryptologie%29" title="Salt (Kryptologie)" target="_blank">gesalzener</a> <a href="https://de.wikipedia.org/wiki/SHA-2" title="SHA-2" target="_blank">SHA256-Hash</a> gespeichert.
                <br>
                Wenn du "angemeldet bleiben" willst, werden deine Anmeldeinformationen in <a href="https://de.wikipedia.org/wiki/HTTP-Cookie" title="HTTP-Cookie">HTTP-Cookies</a> gespeichert. Schaue in das <a href="../imprint/#cookies" title="Impressum">Impressum</a> für weitere Erklärungen.
            </p>
<?php    break;
default:    ?>
            <h1>
                Sign in / up
            </h1>
            <p>
                To access all features on this website you need to login or create an account!
            </p>
            <p>
                I recommend password manager like <a href="http://keepass.info/" title="KeePass Password-Manager" target="_blank">KeePass</a>!
                <br>
                Passwords are stored as <a href="https://en.wikipedia.org/wiki/Salt_%28cryptography%29" title="Salt (cryptography)" target="_blank">salted</a> <a href="https://en.wikipedia.org/wiki/SHA-2" title="SHA-2" target="_blank">SHA256-Hash</a>.
                <br>
                If you want to "stay logged in", your login information will be stored in <a href="https://en.wikipedia.org/wiki/HTTP_cookie" title="HTTP cookie">HTTP cookies</a>. Check the <a href="../imprint/#cookies" title="Imprint">imprint</a> for further explanation.
            </p>
<?php    break;
    }    ?>
            <form method="post" action="../layout/scripts/logreg.php?task=in<?php if (isset($_GET['file'])) {
        echo '&amp;file=' . $_GET['file'];
    }?>">
                <p>
<?php    switch ($lang) {
case 'de':    ?>
                    <input pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,3}$" required title="Ein valides E-Mail-Format" type="email" name="email" placeholder="E-Mail-Adresse" id="email" size="30">
                    <input pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{6,}" required title="Mindestens 6 Zeichen: Zahlen sowie große und kleine Buchstaben." type="password" name="password" placeholder="Passwort" id="password" size="30">
<?php    break;
default:    ?>
                    <input pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,3}$" required title="A valid email format." type="email" name="email" placeholder="e-mail address" id="email" size="30">
                    <input pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{6,}" required title="At least 6 characters: numbers and small & large letters." type="password" name="password" placeholder="password" id="password" size="30">
<?php    break;
    }    ?>
                </p>
<?php
    $now = new DateTime('now', new DateTimeZone('UTC'));

    if (!isset($_SESSION['time'])) {
        $_SESSION['time'] = serialize($now);
    } else {
        $then = unserialize($_SESSION['time']);
        $interval = $then->diff($now);
        $timespan = $interval->format('%s');
        $_SESSION['time'] = serialize($now);
        if ($timespan < 5) {
            echo '<p>';
            echo '<img id="captcha" alt="CAPTCHA Image" src="../resources/packages/composer/dapphp/securimage/securimage_show.php"></img><br><input type="text" title="6 characters and numbers." pattern=".{6,}" required size="6" name="captcha_code" placeholder="captcha" size="10" maxlength="6" />';
            echo '</p>';
        }
    }
?>
                <p>
<?php    switch ($lang) {
case 'de':    ?>
                    <input type="checkbox" name="save" id="save" /> Angemeldet bleiben
<?php    break;
default:    ?>
                    <input type="checkbox" name="save" id="save" /> Stay logged in
<?php    break;
    }    ?>
                </p>
                <p>
                    <button type="submit" name="submit">
<?php    switch ($lang) {
case 'de':    ?>
                        Anmelden
<?php    break;
default:    ?>
                        Sign in / up
<?php    break;
    }    ?>
                    </button>
                </p>
            </form>
            <p>
                <a href="recovery.php" title="Reset password">
<?php    switch ($lang) {
case 'de':    ?>
                    Password verloren?
<?php    break;
default:    ?>
                    Password lost?
<?php    break;
    }    ?>
                </a>
            </p>
            <p>
                <a href="../dialog/participants.php" title="Skip">
<?php    switch ($lang) {
case 'de':    ?>
                    Überspringen
<?php    break;
default:    ?>
                    Skip
<?php    break;
    }    ?>
                </a>
            </p>
        </main>
        <footer>
            <p id="language">
<?php    switch ($lang) {
case 'de':    ?>
                <button class="link en" id="lang" title="Switch to English">
                    <img src="../layout/icons/eng.png" alt="English Flag" id="flag">
                </button>
<?php    break;
default:    ?>
                <button class="link de" id="lang" title="Auf Deutsch wechseln">
                    <img src="../layout/icons/ger.png" alt="German Flag" id="flag">
                </button>
<?php    break;
    }    ?>
            </p>
            <p class="seethrough">
                -
                <a href="../imprint" title="Imprint">
<?php    switch ($lang) {
case 'de':    ?>
                    Impressum
<?php    break;
default:    ?>
                    Imprint
<?php    break;
}    ?>
                </a>
                |
                <button id="bug" class="link" title="Report a bug">
<?php    switch ($lang) {
case 'de':    ?>
                    Fehlerbericht
<?php    break;
default:    ?>
                    Bug Report
<?php    break;
}    ?>
                </button>
                -
            </p>
        </footer>
    </body>
</html>
