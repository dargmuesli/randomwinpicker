<?php
    require_once $_SERVER['SERVER_ROOT'] . '/layout/scripts/dotenv.php';

    $dbh = new PDO("pgsql:host=".$_ENV['PGSQL_HOST'].";port=".$_ENV['PGSQL_PORT'].";dbname=".$_ENV['PGSQL_DATABASE'], $_ENV['PGSQL_USERNAME'], $_ENV['PGSQL_PASSWORD']);

    function account($level, $email, $lang, $tab)
    {
        global $dbh;

        if (isset($email)) {
            $stmt = $dbh->prepare("SELECT privacy FROM accounts WHERE mail='" . $email . "'");

            if (!$stmt->execute()) {
                throw new Exception($stmt->errorInfo()[2]);
            }

            $privacy = $stmt->fetch()[0];
        }

        switch ($lang) {
            case 'de':
                if (!isset($privacy)) {
                    echo $tab . 'Gast | <a href="' . $level . 'accounts/" title="Anmelden">Anmelden</a>' . "\n";
                } elseif (($privacy == 'E-mail address') && isset($email)) {
                    echo $tab . '<a href="' . $level . 'accounts/profile.php" title="Profile">' . $email . ' &#x2261;</a> | <a href="' . $level . 'layout/scripts/logreg.php?task=out" title="Abmelden">Abmelden</a>' . "\n";
                } elseif ($privacy == 'Member') {
                    echo $tab . '<a href="' . $level . 'accounts/profile.php" title="Profile">Mitglied &#x2261;</a> | <a href="' . $level . 'layout/scripts/logreg.php?task=out" title="Abmelden">Abmelden</a>' . "\n";
                } elseif (($privacy != 'E-mail address') && ($privacy != 'Member')) {
                    echo $tab . '<a href="' . $level . 'accounts/profile.php" title="Profile">' . $privacy . ' &#x2261;</a> | <a href="' . $level . 'layout/scripts/logreg.php?task=out" title="Abmelden">Abmelden</a>' . "\n";
                }

                break;
            default:
                if (!isset($privacy)) {
                    echo $tab . 'Guest | <a href="' . $level . 'accounts/" title="Sign In / Up">Sign In / Up</a>' . "\n";
                } elseif (($privacy == 'E-mail address') && isset($email)) {
                    echo $tab . '<a href="' . $level . 'accounts/profile.php" title="Profile">' . $email . ' &#x2261;</a> | <a href="' . $level . 'layout/scripts/logreg.php?task=out" title="Logout">Logout</a>' . "\n";
                } elseif ($privacy == 'Member') {
                    echo $tab . '<a href="' . $level . 'accounts/profile.php" title="Profile">Member &#x2261;</a> | <a href="' . $level . 'layout/scripts/logreg.php?task=out" title="Logout">Logout</a>' . "\n";
                } elseif (($privacy != 'E-mail address') && ($privacy != 'Member')) {
                    echo $tab . '<a href="' . $level . 'accounts/profile.php" title="Profile">' . $privacy . ' &#x2261;</a> | <a href="' . $level . 'layout/scripts/logreg.php?task=out" title="Logout">Logout</a>' . "\n";
                }

                break;
        }
    }
