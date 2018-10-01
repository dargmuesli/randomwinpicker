<?php
    function warning($success, $error, $lang, $tab) {
        $underconstruction = false;

        echo $tab . '<noscript>' . PHP_EOL;
        echo $tab . "\t" . '<div class="alert">' . PHP_EOL;
        echo $tab . "\t\t" . '<p>' . PHP_EOL;
        switch ($lang) {
            case 'de':
                echo $tab . "\t\t\t" . 'Um alle Funktionen dieser Website benutzen zu können, muss JAVASCRIPT aktiviert sein.' . PHP_EOL;
                break;
            default:
                echo $tab . "\t\t\t" . 'To be able to use all features of this website JAVASCRIPT needs to be enabled.' . PHP_EOL;
                break;
        }
        echo $tab . "\t\t" . '</p>' . PHP_EOL;
        echo $tab . "\t" . '</div>' . PHP_EOL;
        echo $tab . '</noscript>' . PHP_EOL;

        if ($success != null) {
            echo $tab . '<div class="note">' . PHP_EOL;
            if ($success != null) {
                echo $tab . "\t" . '<p>' . PHP_EOL;
                echo $tab . "\t\t" . $success . PHP_EOL;
                echo $tab . "\t" . '</p>' . PHP_EOL;
            }
            echo $tab . '</div>' . PHP_EOL;
        }

        if ($underconstruction || $error != null) {
            echo $tab . '<div class="alert">' . PHP_EOL;
            if($underconstruction) {
                echo $tab . "\t" . '<p>' . PHP_EOL;
                switch ($lang) {
                    case 'de':
                        echo $tab . "\t\t" . 'Manche Funktionen dieser Website funktionieren momentan nicht, aber es arbeitet jemand daran!' . PHP_EOL;
                        break;
                    default:
                        echo $tab . "\t\t" . 'Some functions of this website currently do not work, but somebody is working on it!' . PHP_EOL;
                        break;
                }
                echo $tab . "\t" . '</p>' . PHP_EOL;
            }
            if ($error != null) {
                echo $tab . "\t" . '<p>' . PHP_EOL;
                echo $tab . "\t\t" . $error . PHP_EOL;
                echo $tab . "\t" . '</p>' . PHP_EOL;
            }
            echo $tab . '</div>' . PHP_EOL;
        }

        $_SESSION['error'] = null;
        $_SESSION['success'] = null;
    }
?>
