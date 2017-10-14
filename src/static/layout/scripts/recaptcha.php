<?php
    require_once $_SERVER['SERVER_ROOT'] . '/resources/packages/composer/autoload.php';
    require_once $_SERVER['SERVER_ROOT'] . '/layout/scripts/dev.php';
    require_once $_SERVER['SERVER_ROOT'] . '/layout/scripts/dotenv.php';

    function get_recaptcha()
    {
        global $siteIsLive;

        if ($siteIsLive) {
            return new ReCaptcha\ReCaptcha($_ENV['RECAPTCHA_SECRET']);
        } else {
            return new ReCaptcha\ReCaptcha($_ENV['RECAPTCHA_SECRET_DEV']);
        }
    }

    function get_recaptcha_sitekey()
    {
        global $siteIsLive;

        if ($siteIsLive) {
            return $recaptchaSiteKey = $_ENV['RECAPTCHA_SITEKEY'];
        } else {
            return $recaptchaSiteKey = $_ENV['RECAPTCHA_SITEKEY_DEV'];
        }
    }
