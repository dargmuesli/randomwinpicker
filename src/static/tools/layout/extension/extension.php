<?php
    header('Content-Type: application/javascript');
    header('Expires: 0');
    header('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT');
    header('Cache-Control: no-store, no-cache, must-revalidate');
    header('Cache-Control: post-check=0, pre-check=0', false);
    header('Pragma: no-cache');

    function get_title($url)
    {
        $str = file_get_contents($url);

        if (strlen($str) > 0) {
            $str = trim(preg_replace('/\s+/', ' ', $str)); // supports line breaks inside <title>
            preg_match('/\<title\>(.*)\<\/title\>/i', $str, $title); // ignore case
            return $title[1];
        }
    }

    function write_json($url)
    {
        $str = file_get_contents($url);

        if (strlen($str) > 0) {
            $name = $img = $quality = $type = $category = '';

            $str = trim(preg_replace('/\s+/', ' ', $str)); // supports line breaks inside <title>
            preg_match('/\<title\>(.*)\<\/title\>/i', $str, $title); // ignore case
            if ($title[1] != 'CS:GO Stash - Browse all skins, stickers, and music') {
                preg_match('/\<h2\>(.*)\<\/h2\>/i', $str, $name); // ignore case
                preg_match('/\<img class="img-responsive center-block main-skin-img" src\="https\:\/\/csgostash\.com\/img\/skins\/(.*?)\.png/i', $str, $img); // ignore case
                preg_match('/quality (.*?)"\>/i', $str, $quality); // ignore case   class="quality .*?\s+\<p\>(.*?)\<\/p\>   class="nomargin"\>(.*?)\<\/p\>

                $name = str_replace(' |', ',', strip_tags($name[1]));

                $img = $img[1];

                $quality = explode('-', $quality[0]);
                $quality = substr($quality[1], 0, -2);

                if ($quality == 'consumer') {
                    $quality = 'Consumer Grade';
                } elseif ($quality == 'industrial') {
                    $quality = 'Industrial Grade';
                } elseif ($quality == 'milspec') {
                    $quality = 'Mil-Spec';
                } elseif ($quality == 'restricted') {
                    $quality = 'Restricted';
                } elseif ($quality == 'classified') {
                    $quality = 'Classified';
                } elseif ($quality == 'covert') {
                    $quality = 'Covert';
                }

                if (strpos($str, 'class="stattrak"') !== false) {
                    $type = 'StatTrak';
                } elseif (strpos($str, 'class="souvenir"')) {
                    $type = 'Souvenir';
                } else {
                    $type = 'Normal';
                }

                $root = array_diff(scandir('/var/www/randomwinpicker.de/resources/dargmuesli/filetree/categories/en/CS:GO/'), array('..', '.'));

                for ($i = 0; $i < sizeof($root); ++$i) {
                    $category = array_diff(scandir('/var/www/randomwinpicker.de/resources/dargmuesli/filetree/categories/en/CS:GO/'.$root[$i + 2]), array('..', '.'));

                    if (in_array(substr($name, 0, strpos($name, ',')), $category)) {
                        $category = $root[$i + 2];
                        break;
                    }
                }

                if (strpos($title[1], 'CS:GO Stash - Browse all skins, stickers and items') === false) {
                    $link = $url.'/'.preg_replace('/\s/', '-', str_replace(' | ', '-', str_replace(' - CS:GO Stash', '', $title[1])));
                    $csgostash = '/var/www/randomwinpicker.de/resources/dargmuesli/csgostash.txt';
                    $lines = file($csgostash);
                    array_push($lines, $link."\r\n");
                    $lines = array_unique($lines);
                    sort($lines, SORT_NATURAL);
                    file_put_contents($csgostash, implode($lines));

                    $categoryPath = '/var/www/randomwinpicker.de/resources/dargmuesli/filetree/categories/en/CS:GO/'.$category.'/'.substr($name, 0, strpos($name, ',')).'/'.substr($name, strpos($name, ',') + 2, strlen($name));
                    $categoryFile = fopen($categoryPath, 'w') or die('Unable to write category file!<br>');
                    fwrite($categoryFile, '{'."\n\t".'"name": "'.$name.'",'."\n\t".'"url": "https://csgostash.com/img/skins/'.$img.'.png",'."\n\t".'"quality": "'.$quality.'",'."\n\t".'"type": "'.$type.'"'."\n".'}');
                    fclose($categoryFile);

                    return $link.' -> Done!';
                } else {
                    return $url.' -> Done!';
                }
            }
        }
    }

    if (isset($_GET['i'])) {
        echo get_title('https://csgostash.com/skin/'.$_GET['i']).'<br>';
    } elseif (isset($_GET['j'])) {
        echo write_json('https://csgostash.com/skin/'.$_GET['j']).'<br>';
    }
