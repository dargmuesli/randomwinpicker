<?php
    require_once $_SERVER['SERVER_ROOT'] . '/layout/scripts/sessioncookie.php';
?>
<!DOCTYPE html>
<html lang="<?php echo $lang; ?>" dir="ltr" id="par">
    <head>
        <meta charset="utf-8">
        <title>
<?php    switch ($lang) {
case 'de':    ?>
            Willkommen - RandomWinPicker
<?php        break;
default:    ?>
            Welcome - RandomWinPicker
<?php         break;
}    ?>
        </title>
        <link rel="canonical" href="https://randomwinpicker.de/" />
        <link rel="icon" href="layout/icons/favicon.ico" type="image/x-icon" />
        <link rel="stylesheet" href="layout/stylesheets/fonts.css">
        <link rel="stylesheet" href="layout/stylesheets/style.css">
        <meta name="author" content="Jonas Thelemann" />
        <meta name="description" content="Choose a random winner for case openings or similar raffles." />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <meta name="keywords" content="website, true, random, winner, choose, best, randomwinpicker, raffle, winning, user">
        <meta property="og:description" content="Choose a random winner for case openings or similar raffles." />
        <meta property="og:image" content="https://randomwinpicker.de/layout/icons/screenshots/welcome.jpg" />
        <meta property="og:title" content="Welcome - RandomWinPicker" />
        <meta property="og:type" content="website" />
        <meta property="og:url" content="https://randomwinpicker.de/" />
        <script src="layout/scripts/alert.php"></script>
        <script src="layout/scripts/bugfeature.php"></script>
        <script src="layout/scripts/language.php"></script>
<?php    switch ($lang) {
case 'de':    ?>
        <script src='https://www.google.com/recaptcha/api.js?hl=de&amp;render=explicit' async defer></script>
<?php    break;
default:    ?>
        <script src='https://www.google.com/recaptcha/api.js?hl=en&amp;render=explicit' async defer></script>
<?php    break;
    }    ?>
    </head>
    <body class="parallax">
        <noscript>
            <iframe sandbox="" src="https://www.googletagmanager.com/ns.html?id=GTM-T32JLW" height="0" width="0">
            </iframe>
        </noscript>
        <script src="layout/scripts/tag.js"></script>
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
        <div id="group1" class="parallax__group">
            <div class="parallax__layer parallax__layer--base" id="hubble">
            </div>
            <div class="parallax__layer parallax__layer--fore">
                <header>
<?php
    require_once $_SERVER['SERVER_ROOT'] . '/layout/scripts/warning.php';
    warning($success, $error, $lang, '\t\t\t\t\t');
?>
                    <div id="account">
<?php
    require_once $_SERVER['SERVER_ROOT'] . '/layout/scripts/account.php';
    account('', $email, $lang, '\t\t\t\t\t\t');
?>
                    </div>
                </header>
                <div class="greez">
                    <h1>
<?php    switch ($lang) {
case 'de':    ?>
                        Will&shy;kom&shy;men bei
                        <br>
                        Ran&shy;dom&shy;Win&shy;Pick&shy;er
<?php    break;
default:    ?>
                        Wel&shy;come to
                        <br>
                        Ran&shy;dom&shy;Win&shy;Pick&shy;er
<?php    break;
    }    ?>
                    </h1>
                </div>
                <div id="top">
                    <a href="dialog/participants.php" title="Start">
                        <img src="layout/icons/arrow.png" alt="Participants" class="next"/>
                    </a>
                    <p class="hint">
<?php    switch ($lang) {
case 'de':    ?>
                        Scrolle herunter, um eine kurze Beschreibung zu sehen...
<?php    break;
default:    ?>
                        Scroll down to see a short description...
<?php    break;
    }    ?>
                    </p>
                </div>
            </div>
        </div>
        <div id="group2" class="parallax__group">
            <div class="parallax__layer parallax__layer--back" id="stars">
            </div>
            <div class="parallax__layer parallax__layer--base">
                <div class="content">
                    <main>
                        <section>
                            <h2>
<?php    switch ($lang) {
case 'de':    ?>
                                Wofür ist diese Website?
<?php    break;
default:    ?>
                                What is this website for?
<?php    break;
    }    ?>
                            </h2>
                            <p>
<?php    switch ($lang) {
case 'de':    ?>
                                Diese Website bestimmt einen "wahren" zufälligen Gewinner für alle möglichen Verlosungsarten.
                                <br>
                                Sie ist im Speziellen für CS:GO Case Openings konzipiert.
<?php    break;
default:    ?>
                                This website chooses a "true" random winner for any type of raffle.
                                <br>
                                It's made especially for CS:GO Case openings.
<?php    break;
    }    ?>
                            </p>
                        </section>
                        <section>
                            <h2>
<?php    switch ($lang) {
case 'de':    ?>
                                Ein "wahrer" Gewinner?
<?php    break;
default:    ?>
                                A "true" random winner?
<?php    break;
    }    ?>
                            </h2>
                            <p>
<?php    switch ($lang) {
case 'de':    ?>
                                RandomWinPicker benutzt die <a href="https://www.random.org/" title="RANDOM.ORG" target="_blank">Random.org</a> <a href="https://api.random.org/json-rpc/1/" title="JSON-RPC API – Release 1" target="_blank">API</a>, um einen Gewinner mit der Zufälligkeit von atmospherischem Rauschen zu bestimmen.
                                <br>
                                Das ist einer der besten Wege, wenn nicht der beste Weg, zufällige Daten zu erzeugen. <cite title="https://www.random.org/">Besser als die pseudo-zufälligen Zahlenalgorithmen, die typischerweise in Computerprogrammen benutzt werden</cite>.
                                <br>
                                Aber es gibt eine Begrenzung: Jeden Tag können nur 1.000 Anfragen zu random.org gesendet werden und 250.000 Bits können in den angefragten Antworten von random.org sein. Danach wird die Javascriptfunktion <a href="https://developer.mozilla.org/de/docs/Web/JavaScript/Reference/Global_Objects/Math/math.random" title="Math.random()" target="_blank">Math.random()</a> des Browsers benutzt.
<?php    break;
default:    ?>
                                RandomWinPicker uses the <a href="https://www.random.org/" title="RANDOM.ORG" target="_blank">Random.org</a> <a href="https://api.random.org/json-rpc/1/" title="JSON-RPC API – Release 1" target="_blank">API</a> to choose a winner based on the randomness of atmospheric noise.
                                <br>
                                This is one of the best - if not the best - way to generate random data. It is <cite title="https://www.random.org/">better than the pseudo-random number algorithms typically used in computer programs</cite>.
                                <br>
                                But there is one limit: Every day only 1,000 requests can be sent to random.org and 250,000 bits can be in the requested answers from random.org. After that the Javascript function <a href="https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Global_Objects/Math/random" title="Math.random()" target="_blank">Math.random()</a> of your Browser is used.
<?php    break;
    }    ?>
                            </p>
                        </section>
                        <section>
                            <h2>
<?php    switch ($lang) {
case 'de':    ?>
                                Wie beginne ich?
<?php    break;
default:    ?>
                                How do I start?
<?php    break;
    }    ?>
                            </h2>
                            <p>
<?php    switch ($lang) {
case 'de':    ?>
                                Alle Informationen, die RandomWinPicker braucht, können in 2 einfachen Schritten angegeben werden:
<?php    break;
default:    ?>
                                All the information RandomWinPicker needs is given in 2 simple steps:
<?php    break;
    }    ?>
                                <br>
                            </p>
                            <ol>
                                <li>
<?php    switch ($lang) {
case 'de':    ?>
                                    Gib an, wer bei deinem Gewinnspiel teilnimmt und wie groß die Gewinnchance für jeden Teilnehmer ist.
                                    <br>
                                    Zum Beispiel können die Gewinnchancen von der Anzahl der vom Teilnehmer gespendeten CS:GO Keys abhängen.
<?php    break;
default:    ?>
                                    Tell RandomWinPicker who participates in your raffle and how great the chance of winning for each user is.
                                    <br>
                                    For example, the chances of winning may depend on the amount of CS:GO keys a user has donated.
<?php    break;
    }    ?>
                                </li>
                                <li>
<?php    switch ($lang) {
case 'de':    ?>
                                    Wähle alle Gegenstände aus, die von jedem Teilnehmer in einer bestimmten Gewinnkategorie gewonnen werden können.
                                    <br>
                                    Beispielsweise könnte es einen Messerskin auf Platz 1 zu gewinnen geben.
<?php    break;
default:    ?>
                                    Choose all items that can be won by any user in a certain winning category.
                                    <br>
                                    Maybe a knife skin can be won on the first place.
<?php    break;
    }    ?>
                                </li>
                            </ol>
                            <p>
<?php    switch ($lang) {
case 'de':    ?>
                                    Das ist alles!
<?php    break;
default:    ?>
                                    That's it!
<?php    break;
    }    ?>
                            </p>
                        </section>
                        <a href="dialog/participants.php" title="Start">
                            <img src="layout/icons/arrow.png" alt="Participants" class="next"/>
                        </a>
                    </main>
                    <footer>
                        <p id="language">
<?php    switch ($lang) {
case 'de':    ?>
                            <button class="link en" id="lang" title="Switch to English">
                                <img src="layout/icons/eng.png" alt="English Flag" id="flag">
                            </button>
<?php    break;
default:    ?>
                            <button class="link de" id="lang" title="Auf Deutsch wechseln">
                                <img src="layout/icons/ger.png" alt="German Flag" id="flag">
                            </button>
<?php    break;
    }    ?>
                        </p>
                        <p class="seethrough">
                            -
                            <a href="imprint" title="Imprint">
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
                </div>
            </div>
        </div>
    </body>
</html>
