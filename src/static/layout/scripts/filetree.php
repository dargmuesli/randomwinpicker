<?php
    session_start();

    header('Content-Type: application/javascript');

    if (isset($_SESSION['lang'])) {
        $lang = $_SESSION['lang'];
    } else {
        $lang = substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2);
    }
?>
//<script>
$(document).ready (function() {
    $('.filetree').fileTree({root: '/', script: '../resources/dargmuesli/packages/yarn/jqueryfiletree/connectors/jqueryFileTree.php', multiFolder: false, expanded: '/CS:GO/' }, function(file) {
        openFile(file);
    });
});

function openFile(file) {
    var nameparts = file;
    nameparts = nameparts.split('/');
    nameparts = nameparts.splice(3, 2);
    var name = nameparts[0] + ', ' + nameparts[1];

    var client = new XMLHttpRequest();
    client.open('GET', '<?php echo $_SERVER['SERVER_ROOT_URL']; ?>/layout/data/filetree/categories/<?php echo $lang; ?>' + file + '?' + new Date().getTime(), true);
    client.onreadystatechange = function() {
        if ((client.readyState == 4) && (client.status == 200)) {
            var json = isJsonString(client.responseText);

            if ((json != false) && ((json.name != '') || (json.url != ''))) {
                var selected = document.getElementById('selected');
                var btn = selected.parentNode;
                var td = btn.parentNode;
                var type = document.getElementById('chkType');

                if (getFirstChild(getLastChild(td)).id != 'selected') {
                    td.lastChild.click();
                    selected = document.getElementById('selected');
                    btn = selected.parentNode;
                    td = btn.parentNode;
                }

                var index = parseInt(btn.id.replace('sI(', '').replace(')', '')) + 1;

                if (selected.innerHTML.indexOf('---') != -1) {
                    td.removeChild(selected.parentNode);
                    index--;
                } else {
                    selected.removeAttribute('id');
                }

                var quality = '';

                if (json.quality == 'Consumer Grade') {
                    quality = ' consumergrade';
                } else if (json.quality == 'Industrial Grade') {
                    quality = ' industrialgrade';
                } else if (json.quality == 'Mil-Spec') {
                    quality = ' mil-spec';
                } else if (json.quality == 'Restricted') {
                    quality = ' restricted';
                } else if (json.quality == 'Classified') {
                    quality = ' classified';
                } else if (json.quality == 'Covert') {
                    quality = ' covert';
                }

                var newElement = '<figure class="item' + quality;

                if (document.getElementById('hideimages').classList.contains('hidden')) {
                    newElement += ' hide';
                }

                newElement += '" id="selected"><img src="' + json.url + '" alt="' + name + '" class="set ' + file + '"><figcaption>' + name + '<br><span></span><span class="' + json.type + '"></span></figcaption></figure>';

                var button = document.createElement('button');
                button.setAttribute('class', 'link');
                button.setAttribute('title', 'Win');
                button.setAttribute('id', 'sI(' + index + ')');
                button.innerHTML = newElement;
                td.appendChild(button);

                (function () {
                    var iCopy = index;
                    document.getElementById('sI(' + iCopy + ')').addEventListener('click', function(){selectItem(iCopy);});
                }())

                condition.disabled = false;
                condition.selectedIndex = 0;

                if (json.type == 'StatTrak') {
                    document.getElementById('hType').style.display = 'block';
                    type.parentNode.style.display = 'initial';
                    type.parentNode.innerHTML = '<input type="checkbox" name="type" value="StatTrak&trade;" id="chkType"> StatTrak&trade;';
                    document.getElementById('chkType').addEventListener('click', function(){assignStatTrak();});
                    type = document.getElementById('chkType');
                } else if (json.type == 'Souvenir') {
					document.getElementById('hType').style.display = 'block';
					type.parentNode.style.display = 'initial';
                    type.parentNode.innerHTML = '<input type="checkbox" name="type" value="Souvenir" id="chkType"> Souvenir';
                    document.getElementById('chkType').addEventListener('click', function(){assignSouvenir();});
                    type = document.getElementById('chkType');
                } else {
					type.parentNode.style.display = 'none';
					document.getElementById('hType').style.display = 'none';
                }

                for (var i = (index + 1); i < document.querySelectorAll('.item').length; i++) {
                    (function () {
                        var el = document.getElementsByClassName('item')[i].parentNode, elClone = el.cloneNode(true);
                        var iCopy = i;

                        el.parentNode.replaceChild(elClone, el);
                        elClone.id = 'sI(' + iCopy + ')';
                        elClone.addEventListener('click', function(){selectItem(iCopy)});
                    }())
                }

                document.getElementById('tableInput1').value = '<button class="link" title="Win" id="sI(' + i + ')">';

                saveTableCreate(2, 'items', document.getElementById('categories').parentNode);
            } else {
<?php    switch ($lang) {
case 'de':    ?>
            dialogBox.render('Keine validen Daten!', 'Möchtest du diesen Gewinn editieren?', file, 'contribute');
<?php    break;
default:    ?>
            dialogBox.render('No valid data!', 'Do you want to edit this item?', file, 'contribute');
<?php    break;
    }    ?>
            }
        }
    }
    client.send();
}

function isJsonString(str) {
    try    {
        var json = JSON.parse(str);

        if (json && typeof json === 'object' && json !== null) {
            return json;
        }
    }
    catch (e) {}

    return false;
}

function assignCondition() {
    var condition = document.getElementById('condition');
    var selected = document.getElementById('selected');
    var span = selected.getElementsByTagName('span')[0];

<?php    switch ($lang) {
case 'de':    ?>
    if (condition.options[0].selected) {
        span.innerHTML = '';
    } else if (condition.options[1].selected) {
        span.innerHTML = '[FN]';
    } else if (condition.options[2].selected) {
        span.innerHTML = '[MG]';
    } else if (condition.options[3].selected) {
        span.innerHTML = '[EE]';
    } else if (condition.options[4].selected) {
        span.innerHTML = '[AG]';
    } else if (condition.options[5].selected) {
        span.innerHTML = '[KS]';
    }
<?php    break;
default:    ?>
    if (condition.options[0].selected) {
        span.innerHTML = '';
    } else if (condition.options[1].selected) {
        span.innerHTML = '[FN]';
    } else if (condition.options[2].selected) {
        span.innerHTML = '[MW]';
    } else if (condition.options[3].selected) {
        span.innerHTML = '[FT]';
    } else if (condition.options[4].selected) {
        span.innerHTML = '[WW]';
    } else if (condition.options[5].selected) {
        span.innerHTML = '[BS]';
    }
<?php    break;
    }    ?>

    saveTableCreate(2, 'items', document.getElementById('categories').parentNode);
}

function assignStatTrak() {
    var type = document.getElementById('chkType');
    var selected = document.getElementById('selected');
    var span = selected.getElementsByTagName('span')[1];

    if (type.checked) {
        span.innerHTML = '[ST]';
    } else {
        span.innerHTML = '';
    }

    saveTableCreate(2, 'items', document.getElementById('categories').parentNode);
}

function assignSouvenir() {
    var type = document.getElementById('chkType');
    var selected = document.getElementById('selected');
    var span = selected.getElementsByTagName('span')[1];

    if (type.checked) {
        span.innerHTML = '[SV]';
    } else {
        span.innerHTML = '';
    }

    saveTableCreate(2, 'items', document.getElementById('categories').parentNode);
}

function hideImages() {
    var data = document.getElementsByClassName('data');
    var link = document.getElementById('hideimages');

    if (link.classList.contains('shown')) {
        for (var i = 0; i < document.querySelectorAll('.data').length; i++) {
            for (var j = 0; j < data[i].querySelectorAll('.set').length; j++) {
                data[i].getElementsByTagName('img')[j].style.display = 'none';
            }
        }

<?php    switch ($lang) {
case 'de':    ?>
        link.innerHTML = 'Zeige alle Bilder';
<?php    break;
default:    ?>
        link.innerHTML = 'Show all images';
<?php    break;
    }    ?>
        link.classList.add('hidden');
        link.classList.remove('shown');
    } else {
        for (var i = 0; i < document.querySelectorAll('.data').length; i++) {
            for (var j = 0; j < data[i].querySelectorAll('.set').length; j++) {
                data[i].getElementsByTagName('img')[j].style.display = 'inline';
            }
        }

<?php    switch ($lang) {
case 'de':    ?>
        link.innerHTML = 'Verstecke alle Bilder';
<?php    break;
default:    ?>
        link.innerHTML = 'Hide all images';
<?php    break;
    }    ?>
        link.classList.add('shown');
        link.classList.remove('hidden');
    }

    saveTableCreate(2, 'items', document.getElementById('categories').parentNode);
}
//</script>
