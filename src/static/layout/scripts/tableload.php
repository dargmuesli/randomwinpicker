<?php
    function initializeTable($content, $type, $tab) {
        if (isset($content)) {
            for ($i = 0; $i < count($content); $i++) {
                echo $tab . "\t" . '<tr id="tr' . ($i + 1) . '">' . PHP_EOL;
                echo $tab . "\t\t" . '<td class="data">' . PHP_EOL;
                echo $tab . "\t\t\t" . $content[$i]['column0'] . PHP_EOL;
                echo $tab . "\t\t" . '</td>' . PHP_EOL;
                echo $tab . "\t\t" . '<td class="' . $content[$i]['column1classes'] . '">' . PHP_EOL;
                echo $tab . "\t\t\t" . $content[$i]['column1'] . PHP_EOL;
                echo $tab . "\t\t" . '</td>' . PHP_EOL;
                echo $tab . "\t\t" . '<td class="remove">' . PHP_EOL;
                echo $tab . "\t\t\t" . '<button class="link" title="Remove" id="rR(' . ($i + 1) . ', 2, \'' . $type . '\')">' . PHP_EOL;
                echo $tab . "\t\t\t\t" . 'X' . PHP_EOL;
                echo $tab . "\t\t\t" . '</button>' . PHP_EOL;
                echo $tab . "\t\t" . '</td>' . PHP_EOL;
                echo $tab . "\t\t" . '<td class="up">' . PHP_EOL;
                if ($i > 0) {
                    echo $tab . "\t\t\t" . '<button class="link" title="Up" id="mRU(' . ($i + 1) . ', 2, \'' . $type . '\')">' . PHP_EOL;
                    echo $tab . "\t\t\t\t" . '&#x25B2;' . PHP_EOL;
                    echo $tab . "\t\t\t" . '</button>' . PHP_EOL;
                }
                echo $tab . "\t\t" . '</td>' . PHP_EOL;
                echo $tab . "\t\t" . '<td class="down">' . PHP_EOL;
                if ($i != count($content) - 1) {
                    echo $tab . "\t\t\t" . '<button class="link" title="Down" id="mRD(' . ($i + 1) . ', 2, \'' . $type . '\')">' . PHP_EOL;
                    echo $tab . "\t\t\t\t" . '&#x25BC;' . PHP_EOL;
                    echo $tab . "\t\t\t" . '</button>' . PHP_EOL;
                }
                echo $tab . "\t\t" . '</td>' . PHP_EOL;
                echo $tab . "\t" . '</tr>' . PHP_EOL;
            }
        } else {
            echo $tab . "\t" . '<tr id="tr0">' . PHP_EOL;
            echo $tab . "\t\t" . '<td class="data">' . PHP_EOL;
            echo $tab . "\t\t\t" . '---' . PHP_EOL;
            echo $tab . "\t\t" . '</td>' . PHP_EOL;
            echo $tab . "\t\t" . '<td class="data">' . PHP_EOL;
            echo $tab . "\t\t\t" . '---' . PHP_EOL;
            echo $tab . "\t\t" . '</td>' . PHP_EOL;
            echo $tab . "\t\t" . '<td>' . PHP_EOL;
            echo $tab . "\t\t\t" . '---' . PHP_EOL;
            echo $tab . "\t\t" . '</td>' . PHP_EOL;
            echo $tab . "\t\t" . '<td>' . PHP_EOL;
            echo $tab . "\t\t\t" . '---' . PHP_EOL;
            echo $tab . "\t\t" . '</td>' . PHP_EOL;
            echo $tab . "\t\t" . '<td>' . PHP_EOL;
            echo $tab . "\t\t\t" . '---' . PHP_EOL;
            echo $tab . "\t\t" . '</td>' . PHP_EOL;
            echo $tab . "\t" . '</tr>' . PHP_EOL;
        }
    }
?>
