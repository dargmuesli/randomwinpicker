<?php
    session_start();

    if (!isset($_GET['type'])) {
        return http_response_code(400);
    }

    if ($_GET['type'] == 'participants') {
        if (isset($email) && isset($_COOKIE['participants']) && ($_COOKIE['participants'] != '')) {
            echo count(json_decode($_COOKIE['participants']), true);
        } elseif (isset($_SESSION['participants']) && ($_SESSION['participants'] != '')) {
            echo count($_SESSION['participants']);
        } else {
            echo 0;
        }
    } elseif ($_GET['type'] == 'items') {
        if (isset($email) && isset($_COOKIE['items'])) {
            echo count(json_decode($_COOKIE['items']), true);
        } elseif (isset($_SESSION['items'])) {
            echo count($_SESSION['items']);
        } else {
            echo 1;
        }
    }
