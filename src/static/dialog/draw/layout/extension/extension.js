<?php
    header('Content-Type: application/javascript');

    require_once $_SERVER['DOCUMENT_ROOT'] . '/layout/scripts/sessioncookie.php';
    require_once $_SERVER['DOCUMENT_ROOT'] . '/layout/scripts/dotenv.php';

    $dbh = new PDO('pgsql:host='.$_ENV['PGSQL_HOST'].';port='.$_ENV['PGSQL_PORT'].';dbname='.$_ENV['PGSQL_DATABASE'], $_ENV['PGSQL_USERNAME'], $_ENV['PGSQL_PASSWORD']);

    $participants = null;

    if (isset($email) && isset($_COOKIE['participants'])) {
        if (count($_COOKIE['participants']) > 0) {
            $participants = $_COOKIE['participants'];
        }
    } elseif (isset($_SESSION['participants'])) {
        if (count($_SESSION['participants']) > 0) {
            $participants = $_SESSION['participants'];
        }
    }

    $items = null;

    if (isset($email) && isset($_COOKIE['items'])) {
        if (count($_COOKIE['items']) > 0) {
            $items = $_COOKIE['items'];
        }
    } elseif (isset($_SESSION['items'])) {
        if (count($_SESSION['items']) > 0) {
            $items = $_SESSION['items'];
        }
    }

    if (sizeof($participants) < sizeof($items)) {
        switch ($lang) {
            case 'de':
                $_SESSION['error'] = 'Zu viele Gewinne für zu wenig Teilnehmer! Wer soll das alles gewinnen?!';
                break;
            default:
                $_SESSION['error'] = 'Too many items for too few participants! Who shall win all that?!';
                break;
        } ?>
        window.location = '<?php echo $_SERVER['SERVER_ROOT_URL']; ?>/dialog/items.php';
<?php
    }

    if (is_array($participants)) {
        $participants = htmlspecialchars_decode(json_encode($participants), ENT_NOQUOTES);
    }

    if (is_array($items)) {
        $items = htmlspecialchars_decode(json_encode($items), ENT_NOQUOTES);
    }

    $quantity = -1;

    if (isset($_SESSION['quantity'])) {
        $quantity = $_SESSION['quantity'];
    }

    $stmt = $dbh->prepare('SELECT prices FROM accounts WHERE mail = :email');
    $stmt->bindParam(':email', $email);

    if (!$stmt->execute()) {
        throw new PDOException($stmt->errorInfo()[2]);
    }

    $pricesQuery = $stmt->fetch()[0];
    $prices = $pricesQuery[0][0];
?>
//<script>
var round = <?php echo $quantity; ?>;
var index = 0;
var items = <?php echo $items ?>;
var participants = <?php echo $participants ?>;
var winners = {};

function draw() {
    if (round > 0) {
        var go = document.getElementById('go');

		document.getElementById('loading').style.display = '';
		document.getElementById('fader').style.display = 'none';

        if (go != null) {
            go.remove();
        }

        var content = document.getElementById('content');
        var again = document.getElementById('fader');
        var reveal = document.getElementById('reveal');
        var priceNames = '';

        index = 0;

        if (typeof items[(round - 1)] != 'undefined') {
            var item = items[(round - 1)]['column1'];
            var names = [];
            var qualities = [];
            var images = [];
            var win = '';

            var name = item.replace(/<\/?[^>]+(>|$)/g, ' ');

            name = name.replace(/\s\s\s+/g, '<br>');
            name = name.replace(/\s\s+/g, ' ');
            name = name.substring(4, name.length - 4);

            names = name.split('<br>');

            name = name.replace(/,/g, '').replace(/ /g, '-');
            name = name.replace(/-\[FN\]/g, '&condition=Factory New');
            name = name.replace(/-\[MW\]/g, '&condition=Minimal Wear');
            name = name.replace(/-\[MG\]/g, '&condition=Minimal Wear');
            name = name.replace(/-\[FT\]/g, '&condition=Field-Tested');
            name = name.replace(/-\[EE\]/g, '&condition=Field-Tested');
            name = name.replace(/-\[WW\]/g, '&condition=Well-Worn');
            name = name.replace(/-\[AG\]/g, '&condition=Well-Worn');
            name = name.replace(/-\[BS\]/g, '&condition=Battle-Scarred');
            name = name.replace(/-\[KS\]/g, '&condition=Battle-Scarred');
            name = name.replace(/-\[ST\]/g, '&tag=st');
            name = name.replace(/-\[SV\]/g, '&tag=sv');

            priceNames = name.split('<br>');

            var qualityStartIndices = getAllIndexes(item, 'item');

            for (var i = 0; i < qualityStartIndices.length; i++) {
                var qualityEndIndex = item.indexOf('"', qualityStartIndices[i]);
                if (qualityEndIndex - qualityStartIndices[i] != 4) {
                    qualities[i] = item.substring(qualityStartIndices[i] + 5, qualityEndIndex);
                } else {
                    qualities[i] = '';
                }
            }

            var imageStartIndices = getAllIndexes(item, 'src');
            var imageEndIndices = getAllIndexes(item, 'alt');

            for (var i = 0; i < imageStartIndices.length; i++) {
                images[i] = item.substring(imageStartIndices[i] + 5, imageEndIndices[i] - 2);
            }

            index++;

            if (<?php if ($prices) {
    echo 'true';
} else {
    echo 'false';
} ?>) {
                win = '<figure class="opensans win ' + qualities[0] + '" id="fig' + index + '"><div class="price"></div><img align="middle" alt="' + names[0] + '" src="' + images[0] + '" class="set"><br>' + names[0] + '</figure>';
            } else {
                win = '<figure class="opensans win ' + qualities[0] + '" id="fig' + index + '"><img align="middle" alt="' + names[0] + '" src="' + images[0] + '" class="set"><br>' + names[0] + '</figure>';
            }
        } else {
            var win = '---';
        }

<?php    switch ($lang) {
case 'de':    ?>
            if (round > 3) {
                $('#content').prepend('<div class="wrap"><div id="place' + round + '" class="turn places"><div class="ranking">' + round + '. Platz: </div><div class="place">' + win + '</div><p>Der Gewinner ist: <span id="round' + round + '" class="opensans"></span></p></div></div>');
            } else {
                $('#content').prepend('<div class="wrap"><div id="place' + round + '" class="turn"><div class="ranking">' + round + '. Platz: </div><div class="place">' + win + '</div><p>Der Gewinner ist: <span id="round' + round + '" class="opensans"></span></p></div></div>');
            }
<?php    break;
default:    ?>
            if (round > 3) {
                $('#content').prepend('<div class="wrap"><div id="place' + round + '" class="turn places"><div class="ranking">' +  ordinal_suffix_of(round) + ' place: </div><div class="place">' + win + '</div><p>The winner is: <span id="round' + round + '" class="opensans"></span></p></div></div>');
            } else {
                $('#content').prepend('<div class="wrap"><div id="place' + round + '" class="turn"><div class="ranking">' +  ordinal_suffix_of(round) + ' place: </div><div class="place">' + win + '</div><p>The winner is: <span id="round' + round + '" class="opensans"></span></p></div></div>');
            }
<?php    break;
    }    ?>

        (function () {
            var roundCopy = round;
            setTimeout(function(){
                document.getElementById('place' + roundCopy).style.transform = 'rotateY(0deg)';
            }, 100);
        }())

        if (<?php if ($prices) {
        echo 'true';
    } else {
        echo 'false';
    } ?>) {
            var xmlhttp = new XMLHttpRequest();

            xmlhttp.open('GET', '../layout/scripts/cost.php?item=' + priceNames[0] + '&origin=place' + round + '-fig1', true);
            xmlhttp.onreadystatechange = function() {
                if (xmlhttp.readyState == 4) {
                    var responseArray = xmlhttp.responseText.split('-');
                    var origin = $('#' + responseArray[0]).find('#' + responseArray[1]);

                    origin.find('>:first-child').css('background', 'rgba(0, 0, 0, 0.5) none repeat scroll 0% 0%');
                    setTimeout(function(){addPrices(origin, responseArray[2]);}, 1000);
                }
            }
            xmlhttp.send();
        }

        if (imageStartIndices.length > 1) {
            index = 1;
            setTimeout(function(){addRest(imageStartIndices.length, qualities, names, images, priceNames);}, 250);
        }

        document.getElementById('loading').style.display = 'none';
        $('#round' + round).airport([winners[round]]);
        content.insertBefore(document.getElementById('loading'), content.firstChild);
		again.style.display = 'inline-block';
		again.style.opacity = '0';

        round--;

        if (round == 0) {
            var button = document.createElement('button');
            button.setAttribute('class', 'link');
            button.setAttribute('title', 'Draw again');
            button.setAttribute('id', 'reload');
<?php    switch ($lang) {
case 'de':    ?>
                button.innerHTML = 'Nochmal ziehen!';
<?php    break;
default:    ?>
                button.innerHTML = 'Draw again!';
<?php    break;
    }    ?>
            reveal.parentNode.replaceChild(button, reveal); //Reveal durch Reload ersetzen

            document.getElementById('reload').addEventListener('click', function(){location.reload();});
        } else {
<?php    switch ($lang) {
case 'de':    ?>
                reveal.innerHTML = 'Zeige den ' + round + '. Gewinner';
<?php    break;
default:    ?>
                reveal.innerHTML = 'Reveal the ' + ordinal_suffix_of(round) + ' winner';
<?php    break;
    }    ?>
        }
    }
}

function addRest(length, qualities, names, images, priceNames) {
    var earlyPlace = $('.place:eq(0)');
    var origin = earlyPlace.parent().attr('id') + '-fig' + (index + 1);

    if (<?php if ($prices) {
        echo 'true';
    } else {
        echo 'false';
    } ?>) {
        earlyPlace.append('<figure class="opensans win ' + qualities[index] + '" id="fig' + (index + 1) + '"><div class="price"></div><img align="middle" alt="' + names[index] + '" src="' + images[index] + '" class="set"><br>' + names[index] + '</figure>');

        var xmlhttp = new XMLHttpRequest();

        xmlhttp.open('GET', '../layout/scripts/cost.php?item=' + priceNames[index] + '&origin=' + origin, true);
        xmlhttp.onreadystatechange = function() {
            if (xmlhttp.readyState == 4) {
                var responseArray = xmlhttp.responseText.split('-');
                var origin = $('#' + responseArray[0]).find('#' + responseArray[1]);

                origin.find('>:first-child').css('background', 'rgba(0, 0, 0, 0.5) none repeat scroll 0% 0%');
                setTimeout(function(){addPrices(origin, responseArray[2]);}, 1000);
            }
        }
        xmlhttp.send();
    } else {
        earlyPlace.append('<figure class="opensans win ' + qualities[index] + '" id="fig' + (index + 1) + '"><img align="middle" alt="' + names[index] + '" src="' + images[index] + '" class="set"><br>' + names[index] + '</figure>');
    }

    index++;

    if (index < length) {
        setTimeout(function(){addRest(length, qualities, names, images, priceNames);}, 250);
    }
}

function addPrices(element, price) {
    element.append('<div class="price-outer"><img class="price-img" src="../layout/icons/price.png"><div class="price-inner">' + price + '</div></div>');
}

function getAllIndexes(arr, val) {
    var indices = []
    var i = -1;

    while ((i = arr.indexOf(val, i + 1)) != -1) {
        indices.push(i);
    }
    return indices;
}

document.addEventListener('DOMContentLoaded', function () {
    document.getElementById('letsgo').addEventListener('click', function(){draw();});
    document.getElementById('reveal').addEventListener('click', function(){draw();});

    var http = new XMLHttpRequest();

    http.open('GET', '../layout/scripts/random.php?n=' + round, true);
    http.onreadystatechange = function() {
        if (http.readyState == 4) {
            var json = JSON.parse(http.responseText);
            var loading = document.getElementById('loading');
            var go = document.getElementById('go');

            for (var r = 0; r < round; r++) {
                var totalTickets = 0;

                for (var p = 0; p < participants.length; p++) {
                    totalTickets += parseInt(participants[p]['column1']);
                }

                if (json.hasOwnProperty('error') || json.hasOwnProperty('code')) {
                    var randomNumber = Math.random();
                } else {
                    var randomNumber = json.result.random.data[r];
                    var bitsLeftPercentage = json.result.bitsLeft * 100 / 250000;
                    var requestsLeftPercentage = json.result.requestsLeft * 100 / 1000;

<?php    switch ($lang) {
case 'de':    ?>
                        if (bitsLeftPercentage < requestsLeftPercentage) {
                            document.getElementById('percentageleft').innerHTML = (100 - bitsLeftPercentage).toFixed(1) + '% der täglich möglichen Anfragen an random.org wurden genutzt.';
                        } else {
                            document.getElementById('percentageleft').innerHTML = (100 - requestsLeftPercentage).toFixed(1) + '% der täglich möglichen Anfragen an random.org wurden genutzt.';
                        }

<?php    break;
default:    ?>
                        if (bitsLeftPercentage < requestsLeftPercentage) {
                            document.getElementById('percentageleft').innerHTML = (100 - bitsLeftPercentage).toFixed(1) + '% of the daily possible requests to random.org were used.';
                        } else {
                            document.getElementById('percentageleft').innerHTML = (100 - requestsLeftPercentage).toFixed(1) + '% of the daily possible requests to random.org were used.';
                        }
<?php    break;
    }    ?>
                }

                var q = 0;
                var i = 0;

                while (q < 1) {
                    var probability = parseInt(participants[i]['column1']) / totalTickets;

                    q += probability;

                    if (q >= randomNumber) {
                        winners[r + 1] = participants[i]['column0'];
                        participants.splice(participants.indexOf(participants[i]), 1);
                        break;
                    }

                    i++;
                }
            }

            loading.className = 'hide';
            go.className = '';
			go.style.display = 'inline-block';
        }
    }
    http.send();
});

function ordinal_suffix_of(i) {
    var j = i % 10,
        k = i % 100;
    if (j == 1 && k != 11) {
        return i + 'st';
    }
    if (j == 2 && k != 12) {
        return i + 'nd';
    }
    if (j == 3 && k != 13) {
        return i + 'rd';
    }
    return i + 'th';
}
//</script>
