<?php
    $siteIsLive = true;
    $httpHostArray = explode('.', $_SERVER['HTTP_HOST']);

    if (end($httpHostArray) == 'test') {
        $siteIsLive = false;
    }
