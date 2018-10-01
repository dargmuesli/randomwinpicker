<?php
    require_once $_SERVER['DOCUMENT_ROOT'] . '/layout/scripts/sessioncookie.php';

    if (isset($_COOKIE['view'])) {
        $view = $_COOKIE['view'];
    } elseif (isset($_SESSION['view'])) {
        $view = $_SESSION['view'];
    } else {
        $view = 'Instructions';
        $_SESSION['view'] = $view;
    }
?>
<!DOCTYPE html>
<html lang="<?php echo $lang; ?>" dir="ltr" id="sombrero">
    <head>
        <meta charset="UTF-8">
        <title>
<?php    switch ($lang) {
case 'de':    ?>
            Teilnehmer - RandomWinPicker
<?php    break;
default:    ?>
            Participants - RandomWinPicker
<?php    break;
    }    ?>
        </title>
        <link rel="canonical" href="https://randomwinpicker.de/dialog/participants.php" />
        <link rel="icon" href="../layout/icons/favicon.ico" type="image/png" />
        <link rel="stylesheet" href="../layout/stylesheets/fonts.php">
        <link rel="stylesheet" href="../layout/stylesheets/style.css">
        <meta name="author" content="Jonas Thelemann" />
        <meta name="description" content="Enter all participants' names and their chance of winning." />
        <meta name="keywords" content="participants, chance, random, win, picker">
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <meta property="og:description" content="Choose a random winner for case openings or similar raffles." />
        <meta property="og:image" content="https://randomwinpicker.de/layout/icons/screenshots/welcome.jpg" />
        <meta property="og:title" content="Welcome - RandomWinPicker" />
        <meta property="og:type" content="website" />
        <meta property="og:url" content="https://randomwinpicker.de/" />
        <script src="../layout/scripts/alert.php"></script>
        <script src="../layout/scripts/bugfeature.php"></script>
        <script src="../layout/scripts/csv.php"></script>
        <script src="../layout/scripts/js-participants.php"></script>
        <script src="../layout/scripts/keypress.js"></script>
        <script src="../layout/scripts/language.php"></script>
        <script src="../resources/packages/yarn/papaparse/papaparse.min.js"></script>
        <script src="../layout/scripts/phpin.js"></script>
        <script src="../layout/scripts/spoiler.js"></script>
        <script src="../layout/scripts/table.php"></script>
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
    require_once $_SERVER['DOCUMENT_ROOT'] . '/layout/scripts/warning.php';
    warning($success, $error, $lang, "\t\t\t");
?>
            <div>
                <a href="../" title="Back" id="back">
                    <img src="../layout/icons/arrow.png" alt="Welcome" class="rotate"/>
                </a>
            </div>
            <div id="account">
<?php
    require_once $_SERVER['DOCUMENT_ROOT'] . '/layout/scripts/account.php';
    account('../', $email, $lang, "\t\t\t\t");
?>
            </div>
        </header>
    <?php    switch ($lang) {
    case 'de':    ?>
        <main>
            <h1>
                Teil&shy;neh&shy;mer
            </h1>
<?php if ($view == 'Instructions') {
        ?>
                <section class="double">
                    <h2>
                        Namen und Quantität
                    </h2>
                    <p>
                        Gib die Namen aller Teilnehmer und ihre Gewinnchancen an.
                        <br>
                        Beispielweise abhängig von der Anzahl der gespendeten CS:GO Keys.
                    </p>
                </section>
<?php
    } ?>
<?php if ($view == 'Instructions') {
        ?>
                <section class="double">
                    <h2>
                        CSV Dateien
                    </h2>
                    <p>
                        Du kannst auch eine <a href="https://de.wikipedia.org/wiki/CSV_%28Dateiformat%29" title="CSV (Dateiformat)" target="_blank">.csv</a>-Datei hochladen, um die Tabelle zu füllen.
                        <br>
                        Warnung: Die Tabelle wird beim Hochladen einer Datei zurückgesetzt!
                    </p>
                    <p>
                        <button class="link" title="How to get this file" id="spoiler">
                            <span id="link">
                                &#x25B8;
                            </span>
                            Tutorial: Wie man diese Datei (richtig) erstellt
                        </button>
                    </p>
                    <p class="spoiler" title="username;quantity&#10;Dargmuesli;1&#10;Megaquest;3&#10;...">
                        Um diese Datei zu erhalten, klicke auf "Speichern unter" in <a href="https://www.openoffice.org/de/" title="Apache OpenOffice" target="_blank">OpenOffice Calc</a> oder "Exportieren" in <a href="https://products.office.com/de-DE/home" title="Microsoft Office" target="_blank">Microsoft Office Excel</a>.
                        Dann wähle eine semikolongetrennte .csv-Datei mit den Titeln "username" und "quantity". Gehe sicher, dass die Codierung auf UTF-8 gestellt ist!
                        <br>
                        Lasse deinen Mauszeiger über diesem Text schweben, um ein Formatbeispiel zu sehen.
                    </p>
                </section>
<?php
    } ?>
            <div class="alone">
                <table class="box">
                    <tbody id="tbody">
                        <tr>
                            <th>
                                Benutzername
                            </th>
                            <th>
                                Quantität
                            </th>
                            <th>
                                Entfernen
                            </th>
                            <th>
                                Hoch
                            </th>
                            <th>
                                Runter
                            </th>
                        </tr>
<?php
    require_once $_SERVER['DOCUMENT_ROOT'] . '/layout/scripts/tableload.php';

    if (isset($email) && isset($_COOKIE['participants']) && ($_COOKIE['participants'] != '')) {
        initialize_table(json_decode($_COOKIE['participants'], true), 'participants', "\t\t\t\t\t");
    } elseif (isset($_SESSION['participants']) && ($_SESSION['participants'] != '')) {
        initialize_table($_SESSION['participants'], 'participants', "\t\t\t\t\t");
    } else {
        initialize_table(null, 'participants', "\t\t\t\t\t");
    }
?>
                    </tbody>
                </table>
<?php if ($view != 'Data') {
    ?>
                    <p>
                        <input id="tableInput0" name="username" placeholder="Benutzername" required title="Ein Benutzername." type="text">
                        <input id="tableInput1" min="1" name="quantity" placeholder="Quantität" required title="Die Gewinnwahrscheinlichkeit." type="number" value="1">
                    </p>
                    <p>
                        <button type="button" id="add" name="add" value="add">
                            Hinzufügen
                        </button>
                        <button type="button" id="reset" name="reset" value="reset">
                            Zurücksetzen
                        </button>
                    </p>
                    <p>
                        <button id="csvClick">
                            Hochladen
                        </button>
                        <input type="file" accept=".csv" id="csv-file" name="files" class="hide" />
                    </p>
<?php
} ?>
                <p>
                    <a href="items.php" title="Items">
                        <img src="../layout/icons/arrow.png" alt="Items" class="next"/>
                    </a>
                </p>
            </div>
        </main>
<?php    break;
default:    ?>
        <main>
            <h1>
                Par&shy;ti&shy;ci&shy;pants
            </h1>
<?php if ($view == 'Instructions') {
    ?>
                <section class="double">
                    <h2>
                        Names and quantity
                    </h2>
                    <p>
                        Enter all participants' names and their chance of winning.
                        <br>
                        For instance, depending on the amount of CS:GO keys they've donated.
                    </p>
                </section>
<?php
} ?>
<?php if ($view == 'Instructions') {
        ?>
                <section class="double">
                    <h2>
                        CSV files
                    </h2>
                    <p>
                        You can also upload a <a href="https://en.wikipedia.org/wiki/Comma-separated_values" title="Comma-separated values" target="_blank">.csv</a> file to fill the table below.
                        <br>
                        Warning: The table resets when you load a file!
                    </p>
                    <p>
                        <button class="link" title="How to get this file" id="spoiler">
                            <span id="link">
                                &#x25B8;
                            </span>
                            Tutorial: How to build this file (correctly)
                        </button>
                    </p>
                    <p class="spoiler" title="username;quantity&#10;Dargmuesli;1&#10;Megaquest;3&#10;...">
                        To get this file use "save as" in <a href="https://www.openoffice.org/" title="Apache OpenOffice" target="_blank">OpenOffice Calc</a> or "export" in <a href="https://products.office.com/en/home" title="Microsoft Office" target="_blank">Microsoft Office Excel</a>.
                        Then choose a semicolon seperated .csv-file that has the headlines "username" and "quantity". Make sure that encoding is set to UTF-8!
                        <br>
                        Let your cursor hover over this text to see a format example.
                    </p>
                </section>
<?php
    } ?>
            <div class="alone">
                <table class="box">
                    <tbody id="tbody">
                        <tr>
                            <th>
                                Username
                            </th>
                            <th>
                                Quantity
                            </th>
                            <th>
                                Remove
                            </th>
                            <th>
                                Up
                            </th>
                            <th>
                                Down
                            </th>
                        </tr>
<?php
    require_once $_SERVER['DOCUMENT_ROOT'] . '/layout/scripts/tableload.php';

    if (isset($email) && isset($_COOKIE['participants']) && ($_COOKIE['participants'] != '')) {
        initialize_table(json_decode($_COOKIE['participants'], true), 'participants', "\t\t\t\t\t");
    } elseif (isset($_SESSION['participants']) && ($_SESSION['participants'] != '')) {
        initialize_table($_SESSION['participants'], 'participants', "\t\t\t\t\t");
    } else {
        initialize_table(null, 'participants', "\t\t\t\t\t");
    }
?>
                    </tbody>
                </table>
<?php if ($view != 'Data') {
    ?>
                <p>
                    <input id="tableInput0" name="username" placeholder="username" required title="A username." type="text">
                    <input id="tableInput1" min="1" name="quantity" placeholder="quantity" required title="The count of chances to win." type="number" value="1">
                </p>
                <p>
                    <button type="button" id="add" name="add" value="add">
                        Add
                    </button>
                    <button type="button" id="reset" name="reset" value="reset">
                        Reset
                    </button>
                </p>
                <p>
                    <button id="csvClick">
                        Upload
                    </button>
                    <input type="file" accept=".csv" id="csv-file" name="files" class="hide" />
                </p>
<?php
} ?>
                <p>
                    <a href="items.php" title="Items">
                        <img src="../layout/icons/arrow.png" alt="Items" class="next"/>
                    </a>
                </p>
            </div>
        </main>
<?php    break;
    }    ?>
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
