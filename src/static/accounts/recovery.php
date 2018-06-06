<?php
    require_once $_SERVER['SERVER_ROOT'] . '/layout/scripts/sessioncookie.php';
?>
<!DOCTYPE html>
<html lang="<?php echo $lang; ?>" dir="ltr" id="stars">
    <head>
        <meta charset="UTF-8">
        <title>
<?php    switch ($lang) {
case 'de':    ?>
            Passwort-Wiederherstellung - RandomWinPicker
<?php    break;
default:    ?>
            Password recovery - RandomWinPicker
<?php    break;
    }    ?>
        </title>
        <link rel="canonical" href="https://randomwinpicker.de/accounts/recovery.php" />
        <link rel="icon" href="../layout/icons/favicon.ico" type="image/x-icon" />
        <link rel="stylesheet" href="../layout/stylesheets/fonts.css">
        <link rel="stylesheet" href="../layout/stylesheets/style.css">
        <meta name="author" content="Jonas Thelemann" />
        <meta name="description" content="If you lost your password you can recover it right here!" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <meta name="keywords" content="password, recovery, lost, enter, address, reset, link, sent">
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
                <a href="../accounts/" title="Back" id="back">
                    <img src="../layout/icons/arrow.png" alt="Sign in / up" class="rotate"/>
                </a>
            </div>
            <div id="account">
<?php
    require_once $_SERVER['SERVER_ROOT'] . '/layout/scripts/account.php';
    account('../', $email, $lang, '\t\t\t\t');
?>
            </div>
        </header>
        <main>
<?php    switch ($lang) {
case 'de':    ?>
            <h1>
                Passwort-Wiederherstellung
            </h1>
            <p>
                Wenn du dein Passwort verloren haben solltest, kannst du unten einfach deine E-Mail-Adresse eingeben und dir wird ein Link zum Zurücksetzen zugeschickt.
            </p>
            <form method="post" action="../layout/scripts/recover.php?task=recover">
                <p>
                    <input pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,3}$" required size="25" title="A valid email format." type="email" name="email" placeholder="E-Mail-Adresse" id="email">
                </p>
                <p>
                    <input type="submit" name="submit" value="Senden">
                </p>
            </form>

<?php    break;
default:    ?>
            <h1>
                Password Recovery
            </h1>
            <p>
                If you lost your password, enter your e-mail address and a reset link will be sent to it.
            </p>
            <form method="post" action="../layout/scripts/recover.php?task=recover">
                <p>
                    <input pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,3}$" required size="25" title="A valid email format." type="email" name="email" placeholder="e-mail address" id="email">
                </p>
                <p>
                    <input type="submit" name="submit" value="Send">
                </p>
            </form>
<?php    break;
    }    ?>
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
