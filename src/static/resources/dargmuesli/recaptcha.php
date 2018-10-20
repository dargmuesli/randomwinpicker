<?php
    require_once $_SERVER['DOCUMENT_ROOT'].'/resources/packages/composer/autoload.php';
    include_once $_SERVER['DOCUMENT_ROOT'].'/resources/dargmuesli/dev.php';
    include_once $_SERVER['DOCUMENT_ROOT'].'/resources/dargmuesli/filesystem/environment.php';

    function get_recaptcha()
    {
        global $siteIsLive;

        // Load .env file
        load_env_file($_SERVER['SERVER_ROOT'].'/credentials');

        if ($siteIsLive) {
            return new ReCaptcha\ReCaptcha($_ENV['RECAPTCHA_SECRET']);
        } else {
            return new ReCaptcha\ReCaptcha($_ENV['RECAPTCHA_SECRET_DEV']);
        }
    }

    function get_recaptcha_sitekey()
    {
        global $siteIsLive;

        // Load .env file
        load_env_file($_SERVER['SERVER_ROOT'].'/credentials');

        if ($siteIsLive) {
            return $recaptchaSiteKey = $_ENV['RECAPTCHA_SITEKEY'];
        } else {
            return $recaptchaSiteKey = $_ENV['RECAPTCHA_SITEKEY_DEV'];
        }
    }
