<?php
    session_start();

    $lang = 'de';

    if (isset($_SESSION['lang'])) {
        $lang = $_SESSION['lang'];
    } else {
        if (isset($_SERVER['HTTP_ACCEPT_LANGUAGE'])) {
            $lang = substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2);
        }
    }

    if (isset($_SESSION['email'])) {
        $email = $_SESSION['email'];
    } elseif (isset($_COOKIE['email'])) {
        $email = $_COOKIE['email'];
    } else {
        $email = null;
    }

    if (isset($_SESSION['hash'])) {
        $hash = $_SESSION['hash'];
    } elseif (isset($_COOKIE['hash'])) {
        $hash = $_COOKIE['hash'];
    } else {
        $hash = null;
    }

    if (isset($_SESSION['error'])) {
        $error = $_SESSION['error'];
    } else {
        $error = null;
    }

    if (isset($_SESSION['success'])) {
        $success = $_SESSION['success'];
    } else {
        $success = null;
    }

    if (isset($_GET['task']) && ($_GET['task'] == 'importSession')) {
        import_session();
    }

    function import_session()
    {
        setcookie('items', json_encode($_SESSION['items']), time() + (60 * 60 * 24 * 365), '/');
    }
