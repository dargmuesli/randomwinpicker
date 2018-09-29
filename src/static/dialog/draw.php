<?php
    require_once $_SERVER['DOCUMENT_ROOT'] . '/layout/scripts/sessioncookie.php';

    if (isset($email) && isset($_COOKIE['participants'])) {
        if (count($_COOKIE['participants']) == 0) {
            participants_error();
        }
    } elseif (isset($_SESSION['participants'])) {
        if (count($_SESSION['participants']) == 0) {
            participants_error();
        }
    } else {
        participants_error();
    }

    if (isset($email) && isset($_COOKIE['items'])) {
        if (count($_COOKIE['items']) == 0) {
            items_error();
        }
    } elseif (isset($_SESSION['items'])) {
        if (count($_SESSION['items']) == 0) {
            items_error();
        }
    } else {
        items_error();
    }

    function participants_error()
    {
        $_SESSION['error'] = 'No participants defined!';
        die(header('Location: participants.php'));
    }

    function items_error()
    {
        $_SESSION['error'] = 'No items defined!';
        die(header('Location: items.php'));
    }
?>
<!DOCTYPE html>
<html lang="<?php echo $lang; ?>" dir="ltr" id="milkyway">
    <head>
        <meta charset="UTF-8">
        <title>
<?php    switch ($lang) {
case 'de':    ?>
            Ziehung - RandomWinPicker
<?php    break;
default:    ?>
            Draw - RandomWinPicker
<?php    break;
    }    ?>
        </title>
        <link rel="canonical" href="https://randomwinpicker.de/dialog/draw.php" />
        <link rel="icon" href="../layout/icons/favicon.ico" type="image/png" />
        <link rel="stylesheet" href="../layout/stylesheets/fonts.css">
        <link rel="stylesheet" href="../layout/stylesheets/reset.css">
        <link rel="stylesheet" href="../layout/stylesheets/style.css">
        <meta name="author" content="Jonas Thelemann" />
        <meta name="description" content="A random winner is chosen based on your inputs." />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <meta name="keywords" content="random, winner, choose, input, animation">
        <meta property="og:description" content="Choose a random winner for case openings or similar raffles." />
        <meta property="og:image" content="https://randomwinpicker.de/layout/icons/screenshots/welcome.jpg" />
        <meta property="og:title" content="Welcome - RandomWinPicker" />
        <meta property="og:type" content="website" />
        <meta property="og:url" content="https://randomwinpicker.de/" />
        <script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
        <script src="../layout/scripts/airport.js"></script>
        <script src="../layout/scripts/alert.php"></script>
        <script src="../layout/scripts/bugfeature.php"></script>
        <script src="../layout/scripts/js-draw.php"></script>
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
    <body id="background">
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
    require_once $_SERVER['DOCUMENT_ROOT'] . '/layout/scripts/warning.php';
    warning($success, $error, $lang, '\t\t\t');
?>
            <div>
                <a href="items.php" title="Back" id="back">
                    <img src="../layout/icons/arrow.png" alt="Items" class="rotate"/>
                </a>
            </div>
            <div id="account">
<?php
    require_once $_SERVER['DOCUMENT_ROOT'] . '/layout/scripts/account.php';
    account('../', $email, $lang, '\t\t\t\t');
?>
            </div>
        </header>
        <main>
            <h1>
<?php    switch ($lang) {
case 'de':    ?>
                Ziehung
<?php    break;
default:    ?>
                Draw
<?php    break;
    }    ?>
            </h1>
            <p id="go" class="hide">
                <button class="link" id="letsgo" title="Go!">
<?php    switch ($lang) {
case 'de':    ?>
                    Los!
<?php    break;
default:    ?>
                    Go!
<?php    break;
    }    ?>
                </button>
            </p>
            <div id="fader">
                <p id="again" class="colorful">
                    <button class="link" title="Reveal the next winner" id="reveal">
<?php    switch ($lang) {
case 'de':    ?>
                        Zeige den nächsten Gewinner!
<?php    break;
default:    ?>
                        Reveal the next winner!
<?php    break;
    }    ?>
                    </button>
                </p>
            </div>
            <div>
                <p id="loading">
                    <img src="../layout/icons/ajax-loader.gif" alt="Loading"/>
                </p>
            </div>
            <div id="content" class="data">
            </div>
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
            <p id="percentageleft" class="seethrough">
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
