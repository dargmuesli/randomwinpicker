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
            Passwort ändern - RandomWinPicker
<?php    break;
default:    ?>
            Change Password - RandomWinPicker
<?php    break;
    }    ?>
        </title>
        <link rel="canonical" href="https://randomwinpicker.de/accounts/reset.php" />
        <link rel="icon" href="../layout/icons/favicon.ico" type="image/x-icon" />
        <link rel="stylesheet" href="../layout/stylesheets/fonts.css">
        <link rel="stylesheet" href="../layout/stylesheets/style.css">
        <meta name="author" content="Jonas Thelemann" />
        <meta name="description" content="Enter your new password here to regain access to your account." />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <meta name="keywords" content="password, change, enter, new, regain, access, account">
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
    warning($success, $error, $lang, "\t\t\t");
?>
            <div>
                <a href="../accounts/" title="Back" id="back">
                    <img src="../layout/icons/arrow.png" alt="Sign in / up" class="rotate"/>
                </a>
            </div>
            <div id="account">
<?php
    require_once $_SERVER['SERVER_ROOT'] . '/layout/scripts/account.php';
    account('../', $email, $lang, "\t\t\t\t");
?>
            </div>
        </header>
        <main>
<?php    switch ($lang) {
case 'de':    ?>
            <h1>
                Passwort ändern
            </h1>
            <p>
                Gib ein neues Passwort ein, um Zugang zu deinem Konto zurückzuerlangen.
            </p>
<?php    break;
default:    ?>
            <h1>
                Change Password
            </h1>
            <p>
                Enter your new password to regain access to your account.
            </p>
<?php    break;
    }    ?>
            <form method="post" action="../layout/scripts/recover.php?task=reset&amp;email=<?php
                if (isset($_GET['email']) && isset($_GET['code'])) {
                    $email = $_GET['email'];
                    $code = $_GET['code'];

                    echo $email;
                    echo '&amp;code=';
                    echo $code;
                } else {
                    die(header('Location:../accounts/'));
                }
            ?>">
<?php    switch ($lang) {
case 'de':    ?>
                <p>
                    <input pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{6,}" required size="25" title="Mindestens 6 Zeichen: Zahlen sowie große und kleine Buchstaben." type="password" name="password" placeholder="Passwort" id="password">
                </p>
                <p>
                    <input type="submit" name="change" value="Ändern">
                </p>
<?php    break;
default:    ?>
                <p>
                    <input pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{6,}" required size="25" title="At least 6 characters: numbers and small & large letters." type="password" name="password" placeholder="password" id="password">
                </p>
                <p>
                    <input type="submit" name="change" value="Change">
                </p>
<?php    break;
    }    ?>
            </form>
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
