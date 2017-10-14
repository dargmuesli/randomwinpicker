<?php
    $liveDomains = ['randomwinpicker.de'];
    $devDomains = ['localhost', '127.0.0.1', 'randomwinpicker.dev'];
    $siteIsLive = null;

    if (in_array($_SERVER['HTTP_HOST'], $liveDomains)) {
        $siteIsLive = true;
    } elseif (in_array($_SERVER['HTTP_HOST'], $devDomains)) {
        $siteIsLive = false;
    } else {
        throw new Exception('Unknown domain!');
    }
