<?php
    session_start();

    if (isset($_POST['language'])) {
        setcookie('i18next', $_POST['language'], time()+60*60*24*365, '/', '', true, false);

        if (array_key_exists('items', $_SESSION)) {
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
        }
    }
