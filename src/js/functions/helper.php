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

                $root = array_diff(scandir('/var/www/randomwinpicker.de/layout/scripts/filetree/categories/en/CS:GO/'), array('..', '.'));

                for ($i = 0; $i < sizeof($root); ++$i) {
                    $category = array_diff(scandir('/var/www/randomwinpicker.de/layout/scripts/filetree/categories/en/CS:GO/'.$root[$i + 2]), array('..', '.'));

                    if (in_array(substr($name, 0, strpos($name, ',')), $category)) {
                        $category = $root[$i + 2];
                        break;
                    }
                }

                if (strpos($title[1], 'CS:GO Stash - Browse all skins, stickers and items') === false) {
                    $link = $url.'/'.preg_replace('/\s/', '-', str_replace(' | ', '-', str_replace(' - CS:GO Stash', '', $title[1])));
                    $csgostash = '/var/www/randomwinpicker.de/layout/scripts/csgostash.txt';
                    $lines = file($csgostash);
                    array_push($lines, $link."\r\n");
                    $lines = array_unique($lines);
                    sort($lines, SORT_NATURAL);
                    file_put_contents($csgostash, implode($lines));

                    $categoryPath = '/var/www/randomwinpicker.de/layout/scripts/filetree/categories/en/CS:GO/'.$category.'/'.substr($name, 0, strpos($name, ',')).'/'.substr($name, strpos($name, ',') + 2, strlen($name));
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
    } else {
        ?>
//<script>
    document.addEventListener('DOMContentLoaded', function () {
        document.getElementById('btn_title').addEventListener('click', function(){
            index = start_title;
            retrieveTitleData();
            document.getElementById('title').innerHTML = 'Running<br>';
        });
        document.getElementById('btn_json').addEventListener('click', function(){
            index = start_json;
            retrieveJsonData();
            document.getElementById('json').innerHTML = 'Running<br>';
        });
        document.getElementById('start_json').addEventListener('change', function(){
            var newValue = parseInt(this.value);
            if (newValue > start_json) {
                testStartEnd('start', 'up', 'json', newValue);
            } else {
                testStartEnd('start', 'down', 'json', newValue);
            }
        });
        document.getElementById('start_title').addEventListener('change', function(){
            //start_title = this.value;
            var newValue = parseInt(this.value);
            if (newValue > start_title) {
                testStartEnd('start', 'up', 'title', newValue);
            } else {
                testStartEnd('start', 'down', 'title', newValue);
            }
        });
        document.getElementById('end_json').addEventListener('change', function(){
            var newValue = parseInt(this.value);
            if (newValue > end_json) {
                testStartEnd('end', 'up', 'json', newValue);
            } else {
                testStartEnd('end', 'down', 'json', newValue);
            }
        });
        document.getElementById('end_title').addEventListener('change', function(){
            //end_title = this.value;
            var newValue = parseInt(this.value);
            if (newValue > end_title) {
                testStartEnd('end', 'up', 'title', newValue);
            } else {
                testStartEnd('end', 'down', 'title', newValue);
            }
        });

        start_title = parseInt(document.getElementById('start_title').value);
        end_title = parseInt(document.getElementById('end_title').value);
        start_json = parseInt(document.getElementById('start_json').value);
        end_json = parseInt(document.getElementById('end_json').value);

        document.getElementById('fileselect').onchange = function() {
            var file = document.getElementById('fileselect').files[0];
            if (file) {
                var reader = new FileReader();
                reader.readAsText(file, 'ISO-8859-1');
                reader.onload = function (evt) {
                    download('utf-8.csv', evt.target.result);
                }
            }
        };
    });

    function download(filename, text) {
        var pom = document.createElement('a');
        pom.setAttribute('href', 'data:text/plain;charset=utf-8,' + encodeURIComponent(text));
        pom.setAttribute('download', filename);

        if (document.createEvent) {
            var event = document.createEvent('MouseEvents');
            event.initEvent('click', true, true);
            pom.dispatchEvent(event);
        }
        else {
            pom.click();
        }
    }

    var start_title = 0;
    var end_title = 0;
    var index = 0;
    var start_json = 0;
    var end_json = 0;

    function retrieveTitleData() {
        setTimeout(function () {
            var client = new XMLHttpRequest();
            client.open('GET', '<?php echo $_SERVER['REQUEST_URI']; ?>?i=' + index, false);
            client.onreadystatechange = function() {
                if ((client.readyState == 4) && (client.status == 200)) {
                    if (client.responseText != 'CS:GO Stash - Browse all skins, stickers, and music<br>') {
                        document.getElementById('title').innerHTML += 'https://csgostash.com/skin/' + index + '/' + client.responseText.replace(' - CS:GO Stash', '').replace(' | ', '-').replace(/\s/g, '-');
                    }

                    if (index < end_title) {
                        index++;
                        retrieveTitleData();
                    } else {
                        index = 0;
                        document.getElementById('title').innerHTML = document.getElementById('title').innerHTML.replace('Running', '');
                    }
                }
            }
            client.send();
        }, 1);
    }

    function retrieveJsonData() {
        setTimeout(function () {
            var client = new XMLHttpRequest();
            client.open('GET', '<?php echo $_SERVER['REQUEST_URI']; ?>?j=' + index, false);
            client.onreadystatechange = function() {
                if ((client.readyState == 4) && (client.status == 200)) {
                    var jsonNode = document.getElementById('json');

                    jsonNode.innerHTML += client.responseText;

                    if (index < end_json) {
                        index++;
                        retrieveJsonData();
                    } else {
                        index = 0;
                        jsonNode.innerHTML = jsonNode.innerHTML.replace('Running', '');
                    }
                }
            }
            client.send();
        }, 1);
    }

    function testStartEnd(position, direction, type, newValue) {
        var startNode;
        var endNode;
        var start;
        var end;

        if (type == 'json') {
            startNode = document.getElementById('start_json');
            endNode = document.getElementById('end_json');
            start = start_json;
            end = end_json;
        } else if (type == 'title') {
            startNode = document.getElementById('start_title');
            endNode = document.getElementById('end_title');
            start = start_title;
            end = end_title;
        }

        if (position == 'start') {
            start = newValue;

            if (direction == 'up' && start > end) {
                end = start;
                endNode.value = start;
            }
        } else if (position == 'end') {
            end = newValue;

            if (direction == 'down' && end < start) {
                start = end;
                startNode.value = end;
            }
        }

        if (type == 'json') {
            start_json = start;
            end_json = end;
        } else if (type == 'title') {
            start_title = start;
            end_title = end;
        }
    }
//</script>
<?php
    } ?>
