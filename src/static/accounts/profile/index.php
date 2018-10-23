<?php
    include_once $_SERVER['DOCUMENT_ROOT'].'/layout/scripts/sessioncookie.php';
    include_once $_SERVER['DOCUMENT_ROOT'].'/layout/scripts/dotenv.php';

    $dbh = new PDO('pgsql:host='.$_ENV['PGSQL_HOST'].';port='.$_ENV['PGSQL_PORT'].';dbname='.$_ENV['PGSQL_DATABASE'], $_ENV['PGSQL_USERNAME'], $_ENV['PGSQL_PASSWORD']);

    if ($email == null || $hash == null) {
        switch ($lang) {
            case 'de':
                $_SESSION['error'] = 'Du bist nicht angemeldet!';
                break;
            default:
                $_SESSION['error'] = 'You are not logged in!';
                break;
        }

        die(header('Location:../accounts/'));
    }

    $stmt_privacy = $dbh->prepare('SELECT privacy FROM accounts WHERE mail = :email');
    $stmt_privacy->bindParam(':email', $email);
    $stmt_view = $dbh->prepare('SELECT view FROM accounts WHERE mail = :email');
    $stmt_view->bindParam(':email', $email);
    $stmt_storage = $dbh->prepare('SELECT storage FROM accounts WHERE mail = :email');
    $stmt_storage->bindParam(':email', $email);
    $stmt_youtube = $dbh->prepare('SELECT youtube FROM accounts WHERE mail = :email');
    $stmt_youtube->bindParam(':email', $email);
    $stmt_encoding = $dbh->prepare('SELECT encoding FROM accounts WHERE mail = :email');
    $stmt_encoding->bindParam(':email', $email);
    $stmt_prices = $dbh->prepare('SELECT prices FROM accounts WHERE mail = :email');
    $stmt_prices->bindParam(':email', $email);

    if (!$stmt_privacy->execute()) {
        throw new PDOException($stmt_privacy->errorInfo()[2]);
    }

    if (!$stmt_view->execute()) {
        throw new PDOException($stmt_view->errorInfo()[2]);
    }

    if (!$stmt_storage->execute()) {
        throw new PDOException($stmt_storage->errorInfo()[2]);
    }

    if (!$stmt_youtube->execute()) {
        throw new PDOException($stmt_youtube->errorInfo()[2]);
    }

    if (!$stmt_encoding->execute()) {
        throw new PDOException($stmt_encoding->errorInfo()[2]);
    }

    if (!$stmt_prices->execute()) {
        throw new PDOException($stmt_prices->errorInfo()[2]);
    }

    $privacy = $stmt_privacy->fetch()[0];
    $view = $stmt_view->fetch()[0];
    $storage = $stmt_storage->fetch()[0];
    $youtube = $stmt_youtube->fetch()[0];
    $encoding = $stmt_encoding->fetch()[0];
    $prices = $stmt_prices->fetch()[0];
?>
<!DOCTYPE html>
<html lang="<?php echo $lang; ?>" dir="ltr" id="space">
    <head>
        <meta charset="UTF-8">
        <title>
<?php    switch ($lang) {
case 'de':    ?>
            Profil - RandomWinPicker
<?php    break;
default:    ?>
            Profile - RandomWinPicker
<?php    break;
    }    ?>
        </title>
        <link rel="canonical" href="https://randomwinpicker.de/accounts/profile.php" />
        <link rel="icon" href="../layout/icons/favicon.ico" type="image/x-icon" />
        <link rel="stylesheet" href="../layout/stylesheets/fonts.php">
        <link rel="stylesheet" href="../layout/stylesheets/style.css">
        <meta name="author" content="Jonas Thelemann" />
        <meta name="description" content="View all settings of your personal account." />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <meta name="keywords" content="profile, settings, account, features, controls, instructions, set, display, file, encoding">
        <meta property="og:description" content="Choose a random winner for case openings or similar raffles." />
        <meta property="og:image" content="https://randomwinpicker.de/layout/icons/screenshots/welcome.jpg" />
        <meta property="og:title" content="Welcome - RandomWinPicker" />
        <meta property="og:type" content="website" />
        <meta property="og:url" content="https://randomwinpicker.de/" />
        <script src="../layout/scripts/alert.php"></script>
        <script src="../layout/scripts/bugfeature.php"></script>
        <script src="../layout/scripts/js-profile.php"></script>
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
            <div id="saveStatus">
                <img src="../layout/icons/ajax-loader-arrows.gif" alt="Save Status">
            </div>
<?php
    include_once $_SERVER['DOCUMENT_ROOT'].'/layout/scripts/warning.php';
    warning($success, $error, $lang, "\t\t\t");
?>
            <div>
                <a href="../" title="Back" id="back">
                    <img src="../layout/icons/arrow.png" alt="Welcome" class="rotate"/>
                </a>
            </div>
            <div id="account">
<?php
    include_once $_SERVER['DOCUMENT_ROOT'].'/layout/scripts/account.php';
    account('../', $email, $lang, "\t\t\t\t");
?>
            </div>
        </header>
        <main>
<?php    switch ($lang) {
case 'de':    ?>
            <h1>
                Profil
            </h1>
            <div>
                <section>
                    <h2>
                        Information
                    </h2>
                    <p>
                        Wie dein Passwort gespeichert wird: <span class="inconsolata"><?php echo $hash; ?></span>
                    </p>
                </section>
            </div>
            <div>
                <section>
                    <h2>
                        Einstellungen
                    </h2>
                    <section>
                        <h3>
                            Preise
                        </h3>
                        <p>
                            Möchtest du, dass ein Preisstempel auf allen gezogenen Gewinnen angezeigt wird?
                        </p>
                        <form id="priceForm">
                            <fieldset>
                                <input type="radio" id="sS(priceForm, true)" name="prices" value="Yes" <?php if ($prices) {
    echo 'checked';
} ?>><label for="sS(priceForm, true)"> Ja</label>
                                <br>
                                <input type="radio" id="sS(priceForm, false)" name="prices" value="No" <?php if (!$prices) {
    echo 'checked';
} ?>><label for="sS(priceForm, false)"> Nein</label>
                            </fieldset>
                        </form>
                    </section>
                    <section>
                        <h3>
                            Privatspähre
                        </h3>
                        <p>
                            Welcher Name soll in der oberen rechten Ecke der Website angezeigt werden?
                            <br>
                            Zum Beispiel möchten die meisten YouTuber nicht, dass ihre E-Mail-Adresse dort und dann in ihren Videos zu sehen ist.
                        </p>
                        <form id="privacyForm">
                            <fieldset>
                                <input type="radio" id="sS(privacyForm, E-mail address)" name="privacy" value="E-mail address" <?php if ($privacy == 'E-mail address') {
    echo 'checked';
} ?>><label for="sS(privacyForm, E-mail address)"> E-Mail-Adresse</label>
                                <br>
                                <input type="radio" id="sS(privacyForm, Member)" name="privacy" value="Member" <?php if ($privacy == 'Member') {
    echo 'checked';
} ?>><label for="sS(privacyForm, Member)"> Mitglied</label>
                                <br>
                                <input type="radio" id="sS(privacyForm, Custom)" name="privacy" value="Username" <?php if (($privacy != 'E-mail address') && ($privacy != 'Member')) {
    echo 'checked';
} ?>><label for="sS(privacyForm', Custom);"></label>
                                <input type="text" name="privacy" id="sS(privacyForm, this.value)" size="15" maxlength="15" value="<?php if (($privacy != 'E-mail address') && ($privacy != 'Member')) {
    echo $privacy;
} else {
    echo substr($email, 0, strrpos($email, '@'));
} ?>">
                            </fieldset>
                        </form>
                    </section>
                    <section>
                        <h3>
                            Codierung
                        </h3>
                        <p>
                            Falls komische Zeichen (&#xFFFD;) beim Hochladen einer .csv-Datei auftauchen, hilft meist eine andere Codierung.
                        </p>
                        <form id="encodingForm">
                            <fieldset>
                                <input type="radio" id="sS(encodingForm, UTF-8)" name="encoding" value="UTF-8" <?php if ($encoding == 'UTF-8') {
    echo 'checked';
} ?>><label for="sS(encodingForm, UTF-8)"> UTF-8</label>
                                <br>
                                <input type="radio" id="sS(encodingForm, ISO-8859-1)" name="encoding" value="ISO-8859-1" <?php if ($encoding == 'ISO-8859-1') {
    echo 'checked';
} ?>><label for="sS(encodingForm, ISO-8859-1)"> ISO-8859-1</label>
                                <br>
                                <input type="radio" id="sS(encodingForm, Custom)" name="encoding" value="etcetera" <?php if (($encoding != 'UTF-8') && ($encoding != 'ISO-8859-1')) {
    echo 'checked';
} ?>><label for="sS(encodingForm', Custom);"></label>
                                <input type="text" name="encoding" id="sS(encodingForm, this.value)" maxlength="15" size="15" value="<?php if (($encoding != 'UTF-8') && ($encoding != 'ISO-8859-1')) {
    echo $encoding;
} ?>">
                            </fieldset>
                        </form>
                    </section>
                    <section>
                        <h3>
                            Ansicht
                        </h3>
                        <p>
                            Möchtest du dir auf jeder Seite die Erklärungen, nur die Steuerelemente oder nur die Daten anzeigen lassen?
                            <br>
                            Erfahrene Benutzer können die Erklärungen ausstellen, aber die Steuerelemente sichtbar lassen, um trotzdem Gewinnspiele erstellen zu können.
                            <br>
                            YouTuber können nach dem Erstellen eines Gewinnspiels alles abstellen, um eine aufgeräumte Oberfläche für ihre Videos zu erhalten.
                        </p>
                        <form id="viewForm">
                            <fieldset>
                                <input type="radio" id="sS(viewForm, Instructions)" name="view" value="Instructions" <?php if ($view == 'Instructions') {
    echo 'checked';
} ?>><label for="sS(viewForm, Instructions)"> Erklärungen</label>
                                <br>
                                <input type="radio" id="sS(viewForm, Controls)" name="view" value="Controls" <?php if ($view == 'Controls') {
    echo 'checked';
} ?>><label for="sS(viewForm, Controls)"> Steuerelemente</label>
                                <br>
                                <input type="radio" id="sS(viewForm, Data)" name="view" value="Data" <?php if ($view == 'Data') {
    echo 'checked';
} ?>><label for="sS(viewForm, Data)"> Daten</label>
                            </fieldset>
                        </form>
                    </section>
                    <section>
                        <h3>
                            Speichern der Daten
                        </h3>
                        <p>
                            Du kannst auswählen, wie lange deine Daten gespeichert werden sollen.
                            <br>
                            Sie für eine kurze Zeit zu speichern bedeutet, dass die Daten beim Schließen des Browsers verloren gehen.
                            <br>
                            Um die Daten länger zu behalten, können <a href="../imprint.php#cookies" title="Imprint">Cookies</a> als Speichermethode benutzt werden. Solange du diese nicht gelöscht werden, kann das eine sehr lange Zeit sein.
                        </p>
                        <form id="storageForm">
                            <fieldset>
                                <input type="radio" id="sS(storageForm, Session)" name="storage" value="Session" <?php if ($storage == 'Session') {
    echo 'checked';
} ?>><label for="sS(storageForm, Session)"> Sitzung</label>
                                <br>
                                <input type="radio" id="sS(storageForm, Cookies)" name="storage" value="Cookies" <?php if ($storage == 'Cookies') {
    echo 'checked';
} ?>><label for="sS(storageForm, Cookies)"> Cookies [Beta]</label>
                            </fieldset>
                        </form>
                    </section>
                    <section>
                        <h3>
                            YouTube
                        </h3>
                        <p>
                            Hast du ein YouTube-Konto? Zeige mir das: Ich bin sehr daran interessiert, zu sehen, dass meine Website genutzt wird!
                        </p>
                        <form id="youtubeForm">
                            <input type="url" id="sS(youtubeForm, this.value)" name="youtube" pattern="https://www\.youtube\.com\/user\/(.+)" size="100" maxlength="250" placeholder="https://www.youtube.com/user/..." value="<?php echo $youtube; ?>">
                        </form>
                    </section>
                </section>
            </div>
<?php    break;
default:    ?>
            <h1>
                Profile
            </h1>
            <div>
                <section>
                    <h2>
                        Information
                    </h2>
                    <p>
                        How your password is saved: <span class="inconsolata"><?php echo $hash; ?></span>
                    </p>
                </section>
            </div>
            <div>
                <section>
                    <h2>
                        Settings
                    </h2>
                    <section>
                        <h3>
                            Prices
                        </h3>
                        <p>
                            Do you want a price stamp displayed on all items when they are drawn?
                        </p>
                        <form id="priceForm">
                            <fieldset>
                                <input type="radio" id="sS(priceForm, true)" name="prices" value="Yes" <?php if ($prices) {
    echo 'checked';
} ?>><label for="sS(priceForm, true)"> Yes</label>
                                <br>
                                <input type="radio" id="sS(priceForm, false)" name="prices" value="No" <?php if (!$prices) {
    echo 'checked';
} ?>><label for="sS(priceForm, false)"> No</label>
                            </fieldset>
                        </form>
                    </section>
                    <section>
                        <h3>
                            Privacy
                        </h3>
                        <p>
                            Which name do you want to display on the website's upper right corner?
                            <br>
                            For example, as a YouTuber you may want to show something else than your private e-mail address in your videos...
                        </p>
                        <form id="privacyForm">
                            <fieldset>
                                <input type="radio" id="sS(privacyForm, E-mail address)" name="privacy" value="E-mail address" <?php if ($privacy == 'E-mail address') {
    echo 'checked';
} ?>><label for="sS(privacyForm, E-mail address)"> E-mail address</label>
                                <br>
                                <input type="radio" id="sS(privacyForm, Member)" name="privacy" value="Member" <?php if ($privacy == 'Member') {
    echo 'checked';
} ?>><label for="sS(privacyForm, Member)"> Member</label>
                                <br>
                                <input type="radio" id="sS(privacyForm, Custom)" name="privacy" value="Username" <?php if (($privacy != 'E-mail address') && ($privacy != 'Member')) {
    echo 'checked';
} ?>><label for="sS(privacyForm', Custom);"></label>
                                <input type="text" name="privacy" id="sS(privacyForm, this.value)" size="15" maxlength="15" value="<?php if (($privacy != 'E-mail address') && ($privacy != 'Member')) {
    echo $privacy;
} else {
    echo substr($email, 0, strrpos($email, '@'));
} ?>">
                            </fieldset>
                        </form>
                    </section>
                    <section>
                        <h3>
                            Encoding
                        </h3>
                        <p>
                            If weird characters &#xFFFD; are showing up when you use the csv file upload, try a different encoding.
                        </p>
                        <form id="encodingForm">
                            <fieldset>
                                <input type="radio" id="sS(encodingForm, UTF-8)" name="encoding" value="UTF-8" <?php if ($encoding == 'UTF-8') {
    echo 'checked';
} ?>><label for="sS(encodingForm, UTF-8)"> UTF-8</label>
                                <br>
                                <input type="radio" id="sS(encodingForm, ISO-8859-1)" name="encoding" value="ISO-8859-1" <?php if ($encoding == 'ISO-8859-1') {
    echo 'checked';
} ?>><label for="sS(encodingForm, ISO-8859-1)"> ISO-8859-1</label>
                                <br>
                                <input type="radio" id="sS(encodingForm, Custom)" name="encoding" value="etcetera" <?php if (($encoding != 'UTF-8') && ($encoding != 'ISO-8859-1')) {
    echo 'checked';
} ?>><label for="sS(encodingForm', Custom);"></label>
                                <input type="text" name="encoding" id="sS(encodingForm, this.value)" maxlength="15" size="15" value="<?php if (($encoding != 'UTF-8') && ($encoding != 'ISO-8859-1')) {
    echo $encoding;
} ?>">
                            </fieldset>
                        </form>
                    </section>
                    <section>
                        <h3>
                            View
                        </h3>
                        <p>
                            Do you want to see the instructions, just the controls or only your data?
                            <br>
                            As a pro you might want to turn off the instructions, but keep the controls to be still able to set up your raffles.
                            <br>
                            YouTubers can turn off everything after the raffle is set up to get a clean look & feel for their videos.
                        </p>
                        <form id="viewForm">
                            <fieldset>
                                <input type="radio" id="sS(viewForm, Instructions)" name="view" value="Instructions" <?php if ($view == 'Instructions') {
    echo 'checked';
} ?>><label for="sS(viewForm, Instructions)"> Instructions</label>
                                <br>
                                <input type="radio" id="sS(viewForm, Controls)" name="view" value="Controls" <?php if ($view == 'Controls') {
    echo 'checked';
} ?>><label for="sS(viewForm, Controls)"> Controls</label>
                                <br>
                                <input type="radio" id="sS(viewForm, Data)" name="view" value="Data" <?php if ($view == 'Data') {
    echo 'checked';
} ?>><label for="sS(viewForm, Data)"> Data</label>
                            </fieldset>
                        </form>
                    </section>
                    <section>
                        <h3>
                            Storage of data
                        </h3>
                        <p>
                            You can choose how long you want your data to be saved.
                            <br>
                            Storing it for a short time means that as soon as you close your browser the data will be lost.
                            <br>
                            To keep the data longer, <a href="../imprint.php#cookies" title="Imprint">cookies</a> are used as saving method. If you do not delete them this will be a long time.
                        </p>
                        <form id="storageForm">
                            <fieldset>
                                <input type="radio" id="sS(storageForm, Session)" name="storage" value="Session" <?php if ($storage == 'Session') {
    echo 'checked';
} ?>><label for="sS(storageForm, Session)"> Session</label>
                                <br>
                                <input type="radio" id="sS(storageForm, Cookies)" name="storage" value="Cookies" <?php if ($storage == 'Cookies') {
    echo 'checked';
} ?>><label for="sS(storageForm, Cookies)"> Cookies [Beta]</label>
                            </fieldset>
                        </form>
                    </section>
                    <section>
                        <h3>
                            YouTube
                        </h3>
                        <p>
                            Do you have a YouTube account? Tell me about it: I'm very interested in seeing my website used!
                        </p>
                        <form id="youtubeForm">
                            <input type="url" id="sS(youtubeForm, this.value)" name="youtube" pattern="https://www\.youtube\.com\/user\/(.+)" size="100" maxlength="250" placeholder="https://www.youtube.com/user/..." value="<?php echo $youtube; ?>">
                        </form>
                    </section>
                </section>
            </div>
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
