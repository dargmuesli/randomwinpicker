<?php
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }

    include_once $_SERVER['DOCUMENT_ROOT'].'/resources/dargmuesli/recaptcha.php';
    include_once $_SERVER['DOCUMENT_ROOT'].'/resources/dargmuesli/translation/translations.php';

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
            echo 'mailto:e-mail@jonas-thelemann.de?subject='.translate('scripts.suggest.bug');
        } elseif ($type == 'feature') {
            echo 'mailto:e-mail@jonas-thelemann.de?subject='.translate('scripts.suggest.feature');
        }
    }
