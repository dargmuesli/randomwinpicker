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
<html lang="<?php echo $lang; ?>" dir="ltr" id="galaxy">
    <head>
        <meta charset="UTF-8">
        <title>
<?php    switch ($lang) {
case 'de':    ?>
            Gewinne - RandomWinPicker
<?php    break;
default:    ?>
            Items - RandomWinPicker
<?php    break;
    }    ?>
        </title>
        <link rel="canonical" href="https://randomwinpicker.de/dialog/items.php" />
        <link rel="icon" href="../layout/icons/favicon.ico" type="image/png" />
        <link rel="stylesheet" href="../resources/packages/yarn/jqueryfiletree/jqueryfiletree.min.css">
        <link rel="stylesheet" href="../layout/stylesheets/fonts.php">
        <link rel="stylesheet" href="../layout/stylesheets/style.css">
        <meta name="author" content="Jonas Thelemann" />
        <meta name="description" content="Specify all items that can be won by all participants." />
        <meta name="keywords" content="participants, chance, random, win, picker">
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <meta property="og:description" content="Choose a random winner for case openings or similar raffles." />
        <meta property="og:image" content="https://randomwinpicker.de/layout/icons/screenshots/welcome.jpg" />
        <meta property="og:title" content="Welcome - RandomWinPicker" />
        <meta property="og:type" content="website" />
        <meta property="og:url" content="https://randomwinpicker.de/" />
        <script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
        <script src="../resources/packages/yarn/jqueryfiletree/jqueryFileTree.min.js"></script>
        <script src="../layout/scripts/alert.php"></script>
        <script src="../layout/scripts/bugfeature.php"></script>
        <script src="../layout/scripts/filetree.php"></script>
        <script src="../layout/scripts/js-items.php"></script>
        <script src="../layout/scripts/language.php"></script>
        <script src="../layout/scripts/phpin.js"></script>
        <script src="../layout/scripts/sidebar.js"></script>
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
                <a href="participants.php" title="Back" id="back">
                    <img src="../layout/icons/arrow.png" alt="Participants" class="rotate"/>
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
                Gewinne
            </h1>
            <section class="double<?php if ($view == 'Data') {
    echo ' dataview';
} ?>">
<?php if ($view == 'Instructions') {
    ?>
                    <h2>
                        Kategorien erstellen
                    </h2>
                    <p>
                        Konfiguriere unten die Gewinnklassen.
                    </p>
                    <p>
                        Du kannst so viele Gewinne hinzufügen, wie du willst.
                        <br>
                        Um einen Gegenstand zu entfernen, klicke doppelt auf ihn.
                    </p>
<?php
} ?>
                <div class="center">
                    <table class="box">
                        <tbody id="categories">
                            <tr>
                                <th>
                                    Klasse
                                </th>
                                <th>
                                    Gewinn
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

    if (isset($email) && isset($_COOKIE['items']) && ($_COOKIE['items'] != '')) {
        $content = json_decode($_COOKIE['items'], true);
    } elseif (isset($_SESSION['items']) && ($_SESSION['items'] != '')) {
        $content = $_SESSION['items'];
    } else {
        $content = [0 => ['column0' => '1', 'column1' => '<button class="link" title="Win" id="sI(0)"><figure class="item" id="selected"><img>---<br><figcaption><span></span><span></span></figcaption></figure></button>', 'column1classes' => 'data']]; //id="iniTable"
    }

    initialize_table($content, 'items', "\t\t\t\t\t\t");
?>
                        </tbody>
                    </table>
                    <p class="invisible">
                        <input disabled id="tableInput0" name="tableInput0" title="tableInput0" type="number" value="2" class="absolute" min="1">
                        <input disabled id="tableInput1" name="tableInput1" title="tableInput1" type="text" value="">
                    </p>
<?php if ($view != 'Data') {
    ?>
                        <p>
                            <button type="button" id="add" name="add" value="add">
                                Hinzufügen
                            </button>
                            <button type="button" id="reset" name="reset" value="reset">
                                Zurücksetzen
                            </button>
                        </p>
<?php
} ?>
                </div>
            </section>
<?php if ($view != 'Data') {
        ?>
                <section class="double" id="items-right">
<?php if ($view == 'Instructions') {
            ?>
                            <h2 id="assignItems">
                                Gewinne hinzufügen
                            </h2>
                            <p>
                                Gib die Gewinne für die jeweilige Gewinnklasse an.
                            </p>
                            <p>
                                Klicke auf die entsprechende Tabellenzelle auf der linken Seite, um sie auszuwählen.
                                <br>
                                Dann wähle auf der rechten Seite die Gewinne und Eigenschaften aus.
                            </p>
<?php
        } ?>
                    <section class="double sidebar" id="items-right-left">
                        <h3>
                            Zustand
                        </h3>
                        <p>
                            <select id="condition" disabled>
                                <option>
                                    ---
                                </option>
                                <option>
                                    Fabrikneu
                                </option>
                                <option>
                                    Minimale Gebrauchsspuren
                                </option>
                                <option>
                                    Einsatzerprobt
                                </option>
                                <option>
                                    Abgenutzt
                                </option>
                                <option>
                                    Kampfspuren
                                </option>
                            </select>
                        </p>
                        <h3 id="hType">
                            Typ
                        </h3>
                        <p>
                            <label for="chkType">
                                <input type="checkbox" name="type" value="StatTrack&trade;" id="chkType"> StatTrack&trade;
                            </label>
                        </p>
                        <h3>
                            Verbesserungen
                        </h3>
                        <p>
                            <button class="link" title="Suggest new items" id="box">
                                Schlage neue Gewinne &amp; Kategorien vor
                            </button>
                        </p>
                        <h3>
                            Werkzeuge
                        </h3>
                        <p>
                            <button class="link shown" title="Hide all images" id="hideimages">
                                Verstecke alle Bilder
                            </button>
                        </p>
<?php if (isset($email)) {
            ?>
                        <p>
                            <button class="link" title="Import Session" id="importSession">
                                Importiere Sitzungsdaten
                            </button>
                        </p>
<?php
        } ?>
                    </section>
                    <section class="double sidebar" id="items-left-left">
                        <h3>
                            Gewinne
                        </h3>
                        <p class="filetree box">
                        </p>
                    </section>
                </section>
<?php
    } ?>
            <div class="alone">
                <button class="link" title="Draw" id="testGo">
                    <img src="../layout/icons/arrow.png" alt="Draw" class="next"/>
                </button>
            </div>
        </main>
<?php    break;
default:    ?>
        <main>
            <h1>
                Items
            </h1>
            <section class="double<?php if ($view == 'Data') {
    echo ' dataview';
} ?>">
<?php if ($view == 'Instructions') {
    ?>
                    <h2>
                        Create categories
                    </h2>
                    <p>
                        Configure the prize classes below.
                    </p>
                    <p>
                        You can add as many items as you want.
                        <br>
                        To remove an item, double click it.
                    </p>
<?php
} ?>
                <div class="center">
                    <table class="box">
                        <tbody id="categories">
                            <tr>
                                <th>
                                    Class
                                </th>
                                <th>
                                    Win
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

    if (isset($email) && isset($_COOKIE['items']) && ($_COOKIE['items'] != '')) {
        $content = json_decode($_COOKIE['items'], true);
    } elseif (isset($_SESSION['items']) && ($_SESSION['items'] != '')) {
        $content = $_SESSION['items'];
    } else {
        $content = [0 => ['column0' => '1', 'column1' => '<button class="link" title="Win" id="sI(0)"><figure class="item" id="selected"><img>---<br><figcaption><span></span><span></span></figcaption></figure></button>', 'column1classes' => 'data']]; //id="iniTable"
    }

    initialize_table($content, 'items', "\t\t\t\t\t\t");
?>
                        </tbody>
                    </table>
                    <p class="invisible">
                        <input disabled id="tableInput0" name="tableInput0" title="tableInput0" type="number" value="2" class="absolute" min="1">
                        <input disabled id="tableInput1" name="tableInput1" title="tableInput1" type="text" value="">
                    </p>
<?php if ($view != 'Data') {
    ?>
                    <p>
                        <button type="button" id="add" name="add" value="add">
                            Add
                        </button>
                        <button type="button" id="reset" name="reset" value="reset">
                            Reset
                        </button>
                    </p>
<?php
} ?>
                </div>
            </section>
<?php if ($view != 'Data') {
        ?>
                <section class="double" id="items-right">
<?php if ($view == 'Instructions') {
            ?>
                    <h2 id="assignItems">
                        Assign items
                    </h2>
                    <p>
                        Specify the items that can be won by each win class.
                        <br>
                        Click on the corresponding table cell on the left side to select it.
                        <br>
                        Then choose the item(s) and attributes that can be won on the right side.
                    </p>
<?php
        } ?>
                    <section class="double sidebar"  id="items-right-left">
                        <h3>
                            Condition
                        </h3>
                        <p>
                            <select id="condition" disabled>
                                <option>
                                    ---
                                </option>
                                <option>
                                    Factory New
                                </option>
                                <option>
                                    Minimal Wear
                                </option>
                                <option>
                                    Field-Tested
                                </option>
                                <option>
                                    Well-Worn
                                </option>
                                <option>
                                    Battle-Scarred
                                </option>
                            </select>
                        </p>
                        <h3 id="hType">
                            Type
                        </h3>
                        <p>
                            <label for="chkType">
                                <input type="checkbox" name="type" value="StatTrack&trade;" id="chkType"> StatTrack&trade;
                            </label>
                        </p>
                        <h3>
                            Improvements
                        </h3>
                        <p>
                            <button class="link" title="Suggest new items" id="box">
                                Suggest new items & categories
                            </button>
                        </p>
                        <h3>
                            Tools
                        </h3>
                        <p>
                            <button class="link shown" title="Hide all images" id="hideimages">
                                Hide all images
                            </button>
                        </p>
<?php if (isset($email)) {
            ?>
                        <p>
                            <button class="link" title="Import Session" id="importSession">
                                Import session data
                            </button>
                        </p>
<?php
        } ?>
                    </section>
                    <section class="double sidebar" id="items-left-left">
                        <h3>
                            Winnings
                        </h3>
                        <p class="filetree box">
                        </p>
                    </section>
                </section>
<?php
    } ?>
            <div class="alone">
                <button class="link" title="Draw" id="testGo">
                    <img src="../layout/icons/arrow.png" alt="Draw" class="next"/>
                </button>
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
