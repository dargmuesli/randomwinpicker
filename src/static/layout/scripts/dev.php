<?php
    $siteIsLive = true;

    if (end(explode('.', $_SERVER['HTTP_HOST'])) == 'test') {
        $siteIsLive = false;
    }
