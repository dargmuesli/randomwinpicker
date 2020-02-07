<?php
    header('Cache-Control: no-store, no-cache, must-revalidate, max-age=0');
    header('Cache-Control: post-check=0, pre-check=0', false);
    header('Pragma: no-cache');

    $condition = $_GET['condition'];

    if (isset($_GET['tag'])) {
        $tag = $_GET['tag'];
    }

    $item = $_GET['item'];
    $item = str_replace("|", "", $item);
    //$item = str_replace(" (", "-", $item);
    //$item = str_replace(")", "", $item);
    $item = str_replace(" ", "-", $item);
    $item = str_replace("--", "-", $item);
    $item = str_replace("™", "", $item);
    //$item = str_replace("★-", "", $item);
    //$item = str_replace("★", "", $item);

    echo $_GET['origin'] . '-';

    // Read from file
    $lines = file('csgostash.txt');

    foreach ($lines as $line) {
        // Check if the line contains the string we're looking for, and print if it does
        if (stristr($line, $item)) {  // case insensitive
            break;
        }
    }

    $result = file_get_contents(str_replace(')', '', str_replace('(', '', $line)));
    $str = '';

    if (isset($_GET['tag']) && $tag == 'st') {
        if (strpos($item, 'Vanilla') !== false) {
            $str = str_replace("\n", '', get_string_between(preg_replace('/\t+/', '', $result), 'StatTrak</span>' . "\n" . '<span class="pull-left">Vanilla</span>' . "\n" . '<span class="pull-right">', '</span>', $str));
        } else {
            $str = str_replace("\n", '', get_string_between(preg_replace('/\t+/', '', $result), 'StatTrak</span>' . "\n" . '<span class="pull-left">' . $condition . '</span>' . "\n" . '<span class="pull-right">', '</span>', $str));
        }
    } else if (isset($_GET['tag']) && $tag == 'sv') {
        $str = str_replace("\n", '', get_string_between(preg_replace('/\t+/', '', $result), 'Souvenir</span>' . "\n" . '<span class="pull-left">' . $condition . '</span>' . "\n" . '<span class="pull-right">', '</span>', $str));
    } else {
        if (strpos($item, 'Vanilla') !== false) {
            $str = str_replace("\n", '', get_string_between(preg_replace('/\t+/', '', $result), '">' . "\n" . '<span class="pull-left">Vanilla</span>' . "\n" . '<span class="pull-right">', '</span>', $str));
        } else {
            $str = str_replace("\n", '', get_string_between(preg_replace('/\t+/', '', $result), '">' . "\n" . '<span class="pull-left">' . $condition . '</span>' . "\n" . '<span class="pull-right">', '</span>', $str));
        }
    }

    if ($str) {
        echo $str;
    } else {
        echo '???';
    }

    function get_string_between($string, $start, $end, $cur) {
        $string = ' ' . $string;
        $ini = strpos($string, $start);
        if ($ini == 0) return $cur;
        $ini += strlen($start);
        $len = strpos($string, $end, $ini) - $ini;
        return substr($string, $ini, $len);
    }
