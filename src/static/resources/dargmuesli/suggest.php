<?php
    session_start();

    require_once $_SERVER['DOCUMENT_ROOT'] . '/layout/scripts/recaptcha.php';

    if (isset($_SESSION['lang'])) {
        $lang = $_SESSION['lang'];
    } else {
        $lang = substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2);
    }

    $response = null;
    $type = null;
    $reCaptcha = get_recaptcha();

    if (isset($_GET['type'])) {
        $type = $_GET['type'];
    }

    if (isset($_GET['g-recaptcha-response']) && $_GET['g-recaptcha-response']) {
        $response = $reCaptcha->verify(
            $_GET['g-recaptcha-response'],
            $_SERVER['HTTP_X_REAL_IP']
        );
    }

    if ($response != null && $response->isSuccess()) {
        if ($type == 'bug') {
            switch ($lang) {
                case 'de':
                    echo 'mailto:e-mail@jonas-thelemann.de?subject=Fehlermeldung';
                break;
                default:
                    echo 'mailto:e-mail@jonas-thelemann.de?subject=Bug%20Report';
                break;
            }
        } elseif ($type == 'feature') {
            switch ($lang) {
                case 'de':
                    echo 'mailto:e-mail@jonas-thelemann.de?subject=Neuer%20Vorschlag%20für%20Gewinne';
                break;
                default:
                    echo 'mailto:e-mail@jonas-thelemann.de?subject=New%20Item%20Suggestion';
                break;
            }
        }
    }
