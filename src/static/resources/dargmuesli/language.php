<?php
    session_start();

    header('Content-Type: application/javascript');

    if (isset($_POST['language'])) {
        $_SESSION['lang'] = $_POST['language'];

        var_dump($_SESSION['items']);

        if ($_POST['language'] == 'en') {
            $_SESSION['items'] = json_decode(str_replace('[MG]', '[MW]', json_encode($_SESSION['items'])), true);
            $_SESSION['items'] = json_decode(str_replace('[EE]', '[FT]', json_encode($_SESSION['items'])), true);
            $_SESSION['items'] = json_decode(str_replace('[AG]', '[WW]', json_encode($_SESSION['items'])), true);
            $_SESSION['items'] = json_decode(str_replace('[KS]', '[BS]', json_encode($_SESSION['items'])), true);
        } else {
            $_SESSION['items'] = json_decode(str_replace('[MW]', '[MG]', json_encode($_SESSION['items'])), true);
            $_SESSION['items'] = json_decode(str_replace('[FT]', '[EE]', json_encode($_SESSION['items'])), true);
            $_SESSION['items'] = json_decode(str_replace('[WW]', '[AG]', json_encode($_SESSION['items'])), true);
            $_SESSION['items'] = json_decode(str_replace('[BS]', '[KS]', json_encode($_SESSION['items'])), true);
        }
        var_dump($_SESSION['items']);
    }
