<?php
    require_once $_SERVER['SERVER_ROOT'] . '/layout/scripts/sessioncookie.php';
    require_once $_SERVER['SERVER_ROOT'] . '/layout/scripts/recaptcha.php';

    $response = null;

    function verifyReCaptcha($response)
    {
        $reCaptcha = get_recaptcha();
        $verification = $reCaptcha->verify($_POST['g-recaptcha-response'], $_SERVER['HTTP_X_REAL_IP']);

        if ($verification->isSuccess()) {
            return true;
        } else {
            return false;
        }
    }

    if (!empty($_POST)) {
        if (isset($_POST['g-recaptcha-response']) && !empty($_POST['g-recaptcha-response'])) {
            $response = verifyReCaptcha($_POST['g-recaptcha-response']);
        }
    }
?>
<!DOCTYPE html>
<html lang="en" dir="ltr" id="stars">
    <head>
        <meta charset="UTF-8">
        <title>
<?php    switch ($lang) {
case 'de':    ?>
            Impressum - RandomWinPicker
<?php    break;
default:    ?>
            Legal Disclosure - RandomWinPicker
<?php    break;
    }    ?>
        </title>
        <link rel="canonical" href="https://randomwinpicker.de/imprint" />
        <link rel="icon" href="../layout/icons/favicon.ico" type="image/x-icon" />
        <link rel="stylesheet" href="../layout/stylesheets/fonts.css">
        <link rel="stylesheet" href="../layout/stylesheets/style.css">
        <meta name="author" content="Jonas Thelemann" />
        <meta name="description" content="The legal disclosure of this website according to section 5 TMG with contact, image rights, disclaimer and privacy statement." />
        <meta name="keywords" content="images, contents, pages, information, act, tmg, accountability, links, parties, legal">
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <meta property="og:description" content="Choose a random winner for case openings or similar raffles." />
        <meta property="og:image" content="https://randomwinpicker.de/layout/icons/screenshots/welcome.jpg" />
        <meta property="og:title" content="Welcome - RandomWinPicker" />
        <meta property="og:type" content="website" />
        <meta property="og:url" content="https://randomwinpicker.de/" />
        <script src="../layout/scripts/alert.php"></script>
        <script src="../layout/scripts/bugfeature.php"></script>
        <script src="../layout/scripts/js-imprint.php"></script>
        <script src="../layout/scripts/language.php"></script>
<?php    switch ($lang) {
case 'de':    ?>
            <script src="https://www.google.com/recaptcha/api.js?hl=de"></script>
<?php    break;
default:    ?>
            <script src="https://www.google.com/recaptcha/api.js?hl=en"></script>
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
                <a href="../" title="Back" id="back">
                    <img src="../layout/icons/arrow.png" alt="Welcome" class="rotate"/>
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
                Impressum
            </h1>
            <div id="ld">
                Angaben gemäß § 5 TMG.
                <section id="contact">
                    <h2>
                        Kontakt
                    </h2>
<?php
    if ($response) {
        ?>
                    <address>
                        <p>
                            Jonas Thelemann
                            <br>
                            Kassel, Hessen, Deutschland
                        </p>
                        <p>
                            E-Mail: <a href="mailto:e-mail@jonas-thelemann.de" title="e-mail@jonas-thelemann.de">e-mail@jonas-thelemann.de</a>
                        </p>
                    </address>
<?php
    } else {
        ?>
                    <form action="../imprint/" method="post" id="adform">
                        <div data-theme="dark" data-callback="sub" class="g-recaptcha" data-sitekey="<?php echo get_recaptcha_sitekey(); ?>"></div>
                    </form>
<?php
    }
?>
                </section>
                <section>
                    <h2>
                        Quellenangaben für die verwendeten Bilder und Grafiken:
                    </h2>
                    <p>
                        Alle Autoren, Originalbilder und ihre (von Jonas Thelemann) bearbeitete Version.
                    </p>
                    <ul>
                        <li>
                            <a href="https://commons.wikimedia.org/wiki/Main_Page?uselang=de" target="_blank" title="Wikimedia">
                                https://commons.wikimedia.org/
                            </a>
                            <ul>
                                <li>
                                    <a href="https://commons.wikimedia.org/wiki/User:Tryphon?uselang=de" target="_blank" title="Benutzer: Tryphon">
                                        Tryphon
                                    </a>
                                    /
                                    <a href="https://www.spacetelescope.org/" target="_blank" title="spacetelescope.org">
                                        NASA/JPL-Caltech and The Hubble Heritage Team (STScI/AURA)
                                    </a>
                                    <ul>
                                        <li>
                                            <a href="https://commons.wikimedia.org/wiki/File:Sombrero_Galaxy_in_infrared_light_%28Hubble_Space_Telescope_and_Spitzer_Space_Telescope%29.jpg?uselang=de" target="_blank" title="Sombrero Galaxie (Original)">
                                                Sombrero_Galaxy_in_infrared_light_(Hubble_Space_Telescope_and_Spitzer_Space_Telescope).jpg
                                            </a>
                                            &#8594;
                                            <a href="../layout/icons/sombrero.jpg" target="_blank" title="Sombrero Galaxie (Lokal)">
                                                sombrero.jpg
                                            </a>
                                        </li>
                                    </ul>
                                </li>
                                <li>
                                    <a href="https://commons.wikimedia.org/wiki/User:Keraunoscopia?uselang=de" target="_blank" title="Benutzer: Keraunoscopia">
                                        Keraunoscopia
                                    </a>
                                    /
                                    <a href="https://www.spacetelescope.org/" target="_blank" title="spacetelescope.org">
                                        NASA/JPL-Caltech/ESA/CXC/STScI
                                    </a>
                                    <ul>
                                        <li>
                                            <a href="https://commons.wikimedia.org/wiki/File:Center_of_the_Milky_Way_Galaxy_IV_%E2%80%93_Composite.jpg?uselang=de" target="_blank" title="Milchstraße (Original)">
                                                Center_of_the_Milky_Way_Galaxy_IV_–_Composite.jpg
                                            </a>
                                            &#8594;
                                            <a href="../layout/icons/milkyway.jpg" target="_blank" title="Milchstraße (Lokal)">
                                                milkyway.jpg
                                            </a>
                                        </li>
                                    </ul>
                                </li>
                                <li>
                                    <a href="https://commons.wikimedia.org/wiki/User:Njardarlogar?uselang=de" target="_blank" title="Benutzer: Njardarlogar">
                                        Njardarlogar
                                    </a>
                                    /
                                    <a href="https://www.spacetelescope.org/" target="_blank" title="spacetelescope.org">
                                        NASA, ESA, and the Hubble Heritage Team (STScI/AURA)
                                    </a>
                                    <ul>
                                        <li>
                                            <a href="https://commons.wikimedia.org/wiki/File:NGC_2818_by_the_Hubble_Space_Telescope.jpg?uselang=de" target="_blank" title="NGC 2818 (Original)">
                                                NGC_2818_by_the_Hubble_Space_Telescope.jpg
                                            </a>
                                            &#8594;
                                            <a href="../layout/icons/hubble.jpg" target="_blank" title="NGC 2818 (Lokal)">
                                                hubble.jpg
                                            </a>
                                        </li>
                                    </ul>
                                </li>
                                <li>
                                    <a href="https://commons.wikimedia.org/wiki/User:Flickr_upload_bot?uselang=de" target="_blank" title="Benutzer: Flickr_upload_bot">
                                        Flickr_upload_bot
                                    </a>
                                    /
                                    <a href="https://www.nasa.gov/centers/goddard/home/index.html" target="_blank" title="flickr.com">
                                        NASA Goddard Space Flight Center
                                    </a>
                                    <ul>
                                        <li>
                                            <a href="https://commons.wikimedia.org/wiki/File:Magnificent_CME_Erupts_on_the_Sun_-_August_31.jpg?uselang=de" target="_blank" title="Sonneneruption (Original)">
                                                800px-Magnificent_CME_Erupts_on_the_Sun_-_August_31.jpg
                                            </a>
                                            &#8594;
                                            <a href="../layout/icons/eruption.jpg" target="_blank" title="Sonneneruption (Lokal)">
                                                eruption.jpg
                                            </a>
                                        </li>
                                    </ul>
                                </li>
                            </ul>
                        </li>
                        <li>
                            <a href="https://www.pexels.com/" target="_blank" title="Pexels">
                                https://www.pexels.com/
                            </a>
                            <ul>
                                <li>
                                    <a href="https://unsplash.com/ahmadreza_sajadi" target="_blank" title="Benutzer: Ahmadreza Sajadi">
                                        Ahmadreza Sajadi
                                    </a>
                                    <ul>
                                        <li>
                                            <a href="https://www.pexels.com/photo/sky-night-space-galaxy-6547/" target="_blank" title="Galaxie (Original)">
                                                sky-night-space-galaxy.jpeg
                                            </a>
                                            &#8594;
                                            <a href="../layout/icons/galaxy.jpg" target="_blank" title="Galaxie (Lokal)">
                                                galaxy.png
                                            </a>
                                        </li>
                                    </ul>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </section>
                <article>
                    <h2>
                        Haftungsausschluss
                    </h2>
                    <section>
                        <h3>
                            Haftung für Inhalte
                        </h3>
                        <p>
                            Als Diensteanbieter sind wir gemäß § 7 Abs.1 TMG für eigene Inhalte auf diesen Seiten nach den allgemeinen Gesetzen verantwortlich. Nach §§ 8 bis 10 TMG sind wir als Diensteanbieter jedoch nicht verpflichtet, übermittelte oder gespeicherte fremde Informationen zu überwachen oder nach Umständen zu forschen, die auf eine rechtswidrige Tätigkeit hinweisen. Verpflichtungen zur Entfernung oder Sperrung der Nutzung von Informationen nach den allgemeinen Gesetzen bleiben hiervon unberührt. Eine diesbezügliche Haftung ist jedoch erst ab dem Zeitpunkt der Kenntnis einer konkreten Rechtsverletzung möglich. Bei Bekanntwerden von entsprechenden Rechtsverletzungen werden wir diese Inhalte umgehend entfernen.
                        </p>
                    </section>
                    <section>
                        <h3>
                            Haftung für Links
                        </h3>
                        <p>
                            Unser Angebot enthält Links zu externen Webseiten Dritter, auf deren Inhalte wir keinen Einfluss haben. Deshalb können wir für diese fremden Inhalte auch keine Gewähr übernehmen. Für die Inhalte der verlinkten Seiten ist stets der jeweilige Anbieter oder Betreiber der Seiten verantwortlich. Die verlinkten Seiten wurden zum Zeitpunkt der Verlinkung auf mögliche Rechtsverstöße überprüft. Rechtswidrige Inhalte waren zum Zeitpunkt der Verlinkung nicht erkennbar. Eine permanente inhaltliche Kontrolle der verlinkten Seiten ist jedoch ohne konkrete Anhaltspunkte einer Rechtsverletzung nicht zumutbar. Bei Bekanntwerden von Rechtsverletzungen werden wir derartige Links umgehend entfernen.
                        </p>
                    </section>
                    <section>
                        <h3>
                            Urheberrecht
                        </h3>
                        <p>
                            Die durch die Seitenbetreiber erstellten Inhalte und Werke auf diesen Seiten unterliegen dem deutschen Urheberrecht. Die Vervielfältigung, Bearbeitung, Verbreitung und jede Art der Verwertung außerhalb der Grenzen des Urheberrechtes bedürfen der schriftlichen Zustimmung des jeweiligen Autors bzw. Erstellers. Downloads und Kopien dieser Seite sind nur für den privaten, nicht kommerziellen Gebrauch gestattet. Soweit die Inhalte auf dieser Seite nicht vom Betreiber erstellt wurden, werden die Urheberrechte Dritter beachtet. Insbesondere werden Inhalte Dritter als solche gekennzeichnet. Sollten Sie trotzdem auf eine Urheberrechtsverletzung aufmerksam werden, bitten wir um einen entsprechenden Hinweis. Bei Bekanntwerden von Rechtsverletzungen werden wir derartige Inhalte umgehend entfernen.
                        </p>
                    </section>
                    <section>
                        <h3>
                            Besondere Nutzungsbedingungen
                        </h3>
                        <p>
                            Soweit besondere Bedingungen für einzelne Nutzungen dieser Website von den anderen Punkten abweichen, wird an entsprechender Stelle ausdrücklich darauf hingewiesen. In diesem Falle gelten im jeweiligen Einzelfall die besonderen Nutzungsbedingungen.
                        </p>
                    </section>
                </article>
                <article>
                    <h2>
                        Datenschutzerklärung
                    </h2>
                    <!--<section>
                        <h3>
                            General
                        </h3>
                        <p>
                            Your personal data (e.g. title, name, house address, e-mail address, phone number, bank details, credit card number) are processed by us only in accordance with the provisions of German data privacy laws. The following provisions describe the type, scope and purpose of collecting, processing and utilizing personal data. This data privacy policy applies only to our web pages. If links on our pages route you to other pages, please inquire there about how your data are handled in such cases.
                        </p>
                    </section>
                    <section>
                        <h3>
                            Inventory data
                        </h3>
                        <p>
                            Your personal data, insofar as these are necessary for this contractual relationship (inventory data) in terms of its establishment, organization of content and modifications, are used exclusively for fulfilling the contract. For goods to be delivered, for instance, your name and address must be relayed to the supplier of the goods.
                            <br>
                            Without your explicit consent or a legal basis, your personal data are not passed on to third parties outside the scope of fulfilling this contract. After completion of the contract, your data are blocked against further use. After expiry of deadlines as per tax-related and commercial regulations, these data are deleted unless you have expressly consented to their further use.
                        </p>
                    </section>-->
                    <section>
                        <h3>
                            Datenschutzerklärung für die Nutzung von Google Analytics
                        </h3>
                        <p>
                            Diese Website nutzt Funktionen des  Webanalysedienstes Google Analytics. Anbieter ist die Google Inc. 1600 Amphitheatre Parkway Mountain View, CA 94043, USA. Google Analytics verwendet sog. "Cookies". Das sind Textdateien, die auf Ihrem Computer gespeichert werden und die eine Analyse der Benutzung der Website durch Sie ermöglichen. Die durch den Cookie erzeugten Informationen über Ihre Benutzung dieser Website werden in der Regel an einen Server von Google in den USA übertragen und dort gespeichert.
                            <br>
                            Im Falle der Aktivierung der IP-Anonymisierung auf dieser Webseite wird Ihre IP-Adresse von Google jedoch innerhalb von Mitgliedstaaten der Europäischen Union oder in anderen Vertragsstaaten des Abkommens über den Europäischen Wirtschaftsraum zuvor gekürzt. Nur in Ausnahmefällen wird die volle IP-Adresse an einen Server von Google in den USA übertragen und dort gekürzt. Im Auftrag des Betreibers dieser Website wird Google diese Informationen benutzen, um Ihre Nutzung der Website auszuwerten, um Reports über die Websiteaktivitäten zusammenzustellen und um weitere mit der Websitenutzung und der Internetnutzung verbundene Dienstleistungen gegenüber dem Websitebetreiber zu erbringen. Die im Rahmen von Google Analytics von Ihrem Browser übermittelte IP-Adresse wird nicht mit anderen Daten von Google zusammengeführt.
                            <br>
                            Sie können die Speicherung der Cookies durch eine entsprechende Einstellung Ihrer Browser-Software verhindern; wir weisen Sie jedoch darauf hin, dass Sie in diesem Fall gegebenenfalls nicht sämtliche Funktionen dieser Website vollumfänglich werden nutzen können. Sie können darüber hinaus die Erfassung der durch das Cookie erzeugten und auf Ihre Nutzung der Website bezogenen Daten (inkl. Ihrer IP-Adresse) an Google sowie die Verarbeitung dieser Daten durch Google verhindern, indem sie das unter dem folgenden Link verfügbare Browser-Plugin herunterladen und installieren: https://tools.google.com/dlpage/gaoptout?hl=de
                        </p>
                    </section>
                    <section id="cookies">
                        <h3>
                            Cookies
                        </h3>
                        <p>
                            Die Internetseiten verwenden teilweise so genannte Cookies. Cookies richten auf Ihrem Rechner keinen Schaden an und enthalten keine Viren. Cookies dienen dazu, unser Angebot nutzerfreundlicher, effektiver und sicherer zu machen. Cookies sind kleine Textdateien, die auf Ihrem Rechner abgelegt werden und die Ihr Browser speichert.
                            <br>
                            Die meisten der von uns verwendeten Cookies sind so genannte „Session-Cookies“. Sie werden nach Ende Ihres Besuchs automatisch gelöscht. Andere Cookies bleiben auf Ihrem Endgerät gespeichert, bis Sie diese löschen. Diese Cookies ermöglichen es uns, Ihren Browser beim nächsten Besuch wiederzuerkennen.
                            <br>
                            Sie können Ihren Browser so einstellen, dass Sie über das Setzen von Cookies informiert werden und Cookies nur im Einzelfall erlauben, die Annahme von Cookies für bestimmte Fälle oder generell ausschließen sowie das automatische Löschen der Cookies beim Schließen des Browser aktivieren. Bei der Deaktivierung von Cookies kann die Funktionalität dieser Website eingeschränkt sein.
                        </p>
                    </section>
                    <section>
                        <h3>
                            Server-Log Files
                        </h3>
                        <p>
                            Der Provider der Seiten erhebt und speichert automatisch Informationen in so genannten Server-Log Files, die Ihr Browser automatisch an uns übermittelt. Dies sind: Browsertyp/ Browserversion, verwendetes Betriebssystem, Referrer URL, Hostname des zugreifenden Rechners und Uhrzeit der Serveranfrage. Diese Daten sind nicht bestimmten Personen zuordenbar. Eine Zusammenführung dieser Daten mit anderen Datenquellen wird nicht vorgenommen. Wir behalten uns vor, diese Daten nachträglich zu prüfen, wenn uns konkrete Anhaltspunkte für eine rechtswidrige Nutzung bekannt werden.
                        </p>
                    </section>
                    <section>
                        <h3>
                            Auskunft, Löschung, Sperrung
                        </h3>
                        <p>
                            Sie haben jederzeit das Recht auf unentgeltliche Auskunft über Ihre gespeicherten personenbezogenen Daten, deren Herkunft und Empfänger und den Zweck der Datenverarbeitung sowie ein Recht auf Berichtigung, Sperrung oder Löschung dieser Daten. Hierzu sowie zu weiteren Fragen zum Thema personenbezogene Daten können Sie sich jederzeit unter der im Impressum angegebenen Adresse an uns wenden.
                        </p>
                    </section>
                </article>
            </div>
<?php    break;
default:    ?>
            <h1>
                Legal Disclosure
            </h1>
            <div id="ld">
                Information in accordance with section 5 TMG.
                <section id="contact">
                    <h2>
                        Contact
                    </h2>
<?php
    if ($response) {
        ?>
                    <address>
                        <p>
                            Jonas Thelemann
                            <br>
                            Kassel, Hesse, Germany
                        </p>
                        <p>
                            Email: <a href="mailto:e-mail@jonas-thelemann.de" title="e-mail@jonas-thelemann.de">e-mail@jonas-thelemann.de</a>
                        </p>
                    </address>
<?php
    } else {
        ?>
                    <form action="../imprint/" method="post" id="adform">
                        <div data-theme="dark" data-callback="sub" class="g-recaptcha" data-sitekey="<?php echo get_recaptcha_sitekey(); ?>"></div>
                    </form>
<?php
    }
?>
                </section>
                <section>
                    <h2>
                        Indication of source for images and graphics
                    </h2>
                    <p>
                        All authors, original images and their edited version (by Jonas Thelemann).
                    </p>
                    <ul>
                        <li>
                            <a href="https://commons.wikimedia.org/" target="_blank" title="Wikimedia">
                                https://commons.wikimedia.org/
                            </a>
                            <ul>
                                <li>
                                    <a href="https://commons.wikimedia.org/wiki/User:Tryphon" target="_blank" title="User: Tryphon">
                                        Tryphon
                                    </a>
                                    /
                                    <a href="https://www.spacetelescope.org/" target="_blank" title="spacetelescope.org">
                                        NASA/JPL-Caltech and The Hubble Heritage Team (STScI/AURA)
                                    </a>
                                    <ul>
                                        <li>
                                            <a href="https://commons.wikimedia.org/wiki/File:Sombrero_Galaxy_in_infrared_light_%28Hubble_Space_Telescope_and_Spitzer_Space_Telescope%29.jpg" target="_blank" title="Sombrero Galaxy (Original)">
                                                Sombrero_Galaxy_in_infrared_light_(Hubble_Space_Telescope_and_Spitzer_Space_Telescope).jpg
                                            </a>
                                            &#8594;
                                            <a href="../layout/icons/sombrero.jpg" target="_blank" title="Sombrero Galaxy (Local)">
                                                sombrero.jpg
                                            </a>
                                        </li>
                                    </ul>
                                </li>
                                <li>
                                    <a href="https://commons.wikimedia.org/wiki/User:Keraunoscopia" target="_blank" title="User: Keraunoscopia">
                                        Keraunoscopia
                                    </a>
                                    /
                                    <a href="https://www.spacetelescope.org/" target="_blank" title="spacetelescope.org">
                                        NASA/JPL-Caltech/ESA/CXC/STScI
                                    </a>
                                    <ul>
                                        <li>
                                            <a href="https://commons.wikimedia.org/wiki/File:Center_of_the_Milky_Way_Galaxy_IV_%E2%80%93_Composite.jpg" target="_blank" title="Milky Way (Original)">
                                                Center_of_the_Milky_Way_Galaxy_IV_–_Composite.jpg
                                            </a>
                                            &#8594;
                                            <a href="../layout/icons/milkyway.jpg" target="_blank" title="Milky Way (Local)">
                                                milkyway.jpg
                                            </a>
                                        </li>
                                    </ul>
                                </li>
                                <li>
                                    <a href="https://commons.wikimedia.org/wiki/User:Njardarlogar" target="_blank" title="User: Njardarlogar">
                                        Njardarlogar
                                    </a>
                                    /
                                    <a href="https://www.spacetelescope.org/" target="_blank" title="spacetelescope.org">
                                        NASA, ESA, and the Hubble Heritage Team (STScI/AURA)
                                    </a>
                                    <ul>
                                        <li>
                                            <a href="https://commons.wikimedia.org/wiki/File:NGC_2818_by_the_Hubble_Space_Telescope.jpg" target="_blank" title="NGC 2818 (Original)">
                                                NGC_2818_by_the_Hubble_Space_Telescope.jpg
                                            </a>
                                            &#8594;
                                            <a href="../layout/icons/hubble.jpg" target="_blank" title="NGC 2818 (Local)">
                                                hubble.jpg
                                            </a>
                                        </li>
                                    </ul>
                                </li>
                                <li>
                                    <a href="https://commons.wikimedia.org/wiki/User:Flickr_upload_bot" target="_blank" title="User: Flickr_upload_bot">
                                        Flickr_upload_bot
                                    </a>
                                    /
                                    <a href="https://www.nasa.gov/centers/goddard/home/index.html" target="_blank" title="flickr.com">
                                        NASA Goddard Space Flight Center
                                    </a>
                                    <ul>
                                        <li>
                                            <a href="https://commons.wikimedia.org/wiki/File:Magnificent_CME_Erupts_on_the_Sun_-_August_31.jpg" target="_blank" title="Sun Eruption (Original)">
                                                800px-Magnificent_CME_Erupts_on_the_Sun_-_August_31.jpg
                                            </a>
                                            &#8594;
                                            <a href="../layout/icons/eruption.jpg" target="_blank" title="Sun Eruption (Local)">
                                                eruption.jpg
                                            </a>
                                        </li>
                                    </ul>
                                </li>
                            </ul>
                        </li>
                        <li>
                            <a href="https://www.pexels.com/" target="_blank" title="Pexels">
                                https://www.pexels.com/
                            </a>
                            <ul>
                                <li>
                                    <a href="https://unsplash.com/ahmadreza_sajadi" target="_blank" title="User: Ahmadreza Sajadi">
                                        Ahmadreza Sajadi
                                    </a>
                                    <ul>
                                        <li>
                                            <a href="https://www.pexels.com/photo/sky-night-space-galaxy-6547/" target="_blank" title="Galaxy (Original)">
                                                sky-night-space-galaxy.jpeg
                                            </a>
                                            &#8594;
                                            <a href="../layout/icons/galaxy.jpg" target="_blank" title="Galaxy (Local)">
                                                galaxy.png
                                            </a>
                                        </li>
                                    </ul>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </section>
                <article>
                    <h2>
                        Disclaimer
                    </h2>
                    <section>
                        <h3>
                            Accountability for content
                        </h3>
                        <p>
                            The contents of our pages have been created with the utmost care. However, we cannot guarantee the contents' accuracy, completeness or topicality. According to statutory provisions, we are furthermore responsible for our own content on these web pages. In this context, please note that we are accordingly not obliged to monitor merely the transmitted or saved information of third parties, or investigate circumstances pointing to illegal activity. Our obligations to remove or block the use of information under generally applicable laws remain unaffected by this as per §§ 8 to 10 of the Telemedia Act (TMG).
                        </p>
                    </section>
                    <section>
                        <h3>
                            Accountability for links
                        </h3>
                        <p>
                            Responsibility for the content of external links (to web pages of third parties) lies solely with the operators of the linked pages. No violations were evident to us at the time of linking. Should any legal infringement become known to us, we will remove the respective link immediately.
                        </p>
                    </section>
                    <section>
                        <h3>
                            Copyright
                        </h3>
                        <p>
                            Our web pages and their contents are subject to German copyright law. Unless expressly permitted by law (§ 44a et seq. of the copyright law), every form of utilizing, reproducing or processing works subject to copyright protection on our web pages requires the prior consent of the respective owner of the rights. Individual reproductions of a work are allowed only for private use, so must not serve either directly or indirectly for earnings. Unauthorized utilization of copyrighted works is punishable (§ 106 of the copyright law).
                        </p>
                    </section>
                    <section>
                        <h3>
                            Special terms of use
                        </h3>
                        <p>
                            This disclaimer is to be regarded as part of the internet publication which you were referred from. If sections or individual formulations of this text are not legal or correct, the content or validity of the other parts remain uninfluenced by this fact.
                        </p>
                    </section>
                </article>
                <article>
                    <h2>
                        Privacy Statement
                    </h2>
                    <!--<section>
                        <h3>
                            General
                        </h3>
                        <p>
                            Your personal data (e.g. title, name, house address, e-mail address, phone number, bank details, credit card number) are processed by us only in accordance with the provisions of German data privacy laws. The following provisions describe the type, scope and purpose of collecting, processing and utilizing personal data. This data privacy policy applies only to our web pages. If links on our pages route you to other pages, please inquire there about how your data are handled in such cases.
                        </p>
                    </section>
                    <section>
                        <h3>
                            Inventory data
                        </h3>
                        <p>
                            Your personal data, insofar as these are necessary for this contractual relationship (inventory data) in terms of its establishment, organization of content and modifications, are used exclusively for fulfilling the contract. For goods to be delivered, for instance, your name and address must be relayed to the supplier of the goods.
                            <br>
                            Without your explicit consent or a legal basis, your personal data are not passed on to third parties outside the scope of fulfilling this contract. After completion of the contract, your data are blocked against further use. After expiry of deadlines as per tax-related and commercial regulations, these data are deleted unless you have expressly consented to their further use.
                        </p>
                    </section>-->
                    <section>
                        <h3>
                            Web analysis with Google Analytics
                        </h3>
                        <p>
                            This website uses Google Analytics, a web analytics service provided by Google, Inc. (Google). Google Analytics uses cookies, which are text files placed on your computer, to help the website analyze how users use the site. The information generated by the cookie about your use of the website (including your IP address) will be transmitted to and stored by Google on servers in the United States . Google will use this information for the purpose of evaluating your use of the website, compiling reports on website activity for website operators and providing other services relating to website activity and internet usage. Google may also transfer this information to third parties where required to do so by law, or where such third parties process the information on Google's behalf. Google will not associate your IP address with any other data held by Google. You may refuse the use of cookies by selecting the appropriate settings on your browser, however please note that if you do this you may not be able to use the full functionality of this website. By using this website, you consent to the processing of data about you by Google in the manner and for the purposes set out above.
                        </p>
                    </section>
                    <section id="cookies">
                        <h3>
                            Information about cookies
                        </h3>
                        <p>
                            To optimize our web presence, we use cookies. These are small text files stored in your computer's main memory. These cookies are deleted after you close the browser. Other cookies remain on your computer (long-term cookies) and permit its recognition on your next visit. This allows us to improve your access to our site.
                            <br>
                            You can prevent storage of cookies by choosing a "disable cookies" option in your browser settings. But this can limit the functionality of our Internet offers as a result.
                        </p>
                    </section>
                    <!--<section>
                        <h3>
                            Server-Log Files
                        </h3>
                        <p>
                            Der Provider der Seiten erhebt und speichert automatisch Informationen in so genannten Server-Log Files, die Ihr Browser automatisch an uns übermittelt. Dies sind: Browsertyp/ Browserversion, verwendetes Betriebssystem, Referrer URL, Hostname des zugreifenden Rechners und Uhrzeit der Serveranfrage. Diese Daten sind nicht bestimmten Personen zuordenbar. Eine Zusammenführung dieser Daten mit anderen Datenquellen wird nicht vorgenommen. Wir behalten uns vor, diese Daten nachträglich zu prüfen, wenn uns konkrete Anhaltspunkte für eine rechtswidrige Nutzung bekannt werden.
                        </p>
                    </section>-->
                    <section>
                        <h3>
                            Disclosure
                        </h3>
                        <p>
                            According to the Federal Data Protection Act, you have a right to free-of-charge information about your stored data, and possibly entitlement to correction, blocking or deletion of such data. Inquiries can be directed to the e-mail address mentioned above.
                        </p>
                    </section>
                </article>
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
