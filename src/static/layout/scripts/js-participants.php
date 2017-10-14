<?php
    session_start();

    header('Content-Type: application/javascript');
?>
//<script>
// Save the amount of tablerows
var count = <?php if (isset($email) && isset($_COOKIE['participants']) && ($_COOKIE['participants'] != '')){echo count(json_decode($_COOKIE['participants']), true);} else if (isset($_SESSION['participants']) && ($_SESSION['participants'] != '')){echo count($_SESSION['participants']);} else {echo 0;}; ?>;

// Make links clickable
document.addEventListener('DOMContentLoaded', function () {
    var spoiler = document.getElementById('spoiler');
    if (spoiler != null) {
        spoiler.addEventListener('click', function(){showSpoiler();});
    }
    var add = document.getElementById('add');
    if (add != null) {
        add.addEventListener('click', function(){sendRow(2, [0], 'participants');});
    }
    var resetElement = document.getElementById('reset');
    if (resetElement != null) {
        resetElement.addEventListener('click', function(){reset(2, 'participants');});
    }
    var csvClick = document.getElementById('csvClick');
    if (csvClick != null) {
        csvClick.addEventListener('click', function(){document.getElementById('csv-file').click();});
    }

    var i = 1;
    var tr = document.getElementById('tr' + i);

    while (tr != null) {
        for (var j = 0; j < tr.childNodes.length; j++) {
            var child = tr.childNodes[j];

            if (child != null && child.nodeType != 3) {
                (function () {
                    var iCopy = i;

                    if (child.className == 'remove') {
                        getChildNode(child, 0).addEventListener('click', function(){removeRow(iCopy, 2, 'participants')});;
                    } else if (child.className == 'up' && child.childNodes[1] != null) {
                        getChildNode(child, 0).addEventListener('click', function(){moveRowUp(iCopy, 2, 'participants')});;
                    } else if (child.className == 'down' && child.childNodes[1] != null) {
                        getChildNode(child, 0).addEventListener('click', function(){moveRowDown(iCopy, 2, 'participants')});;
                    }
                }())
            }
        }

        i++;
        tr = document.getElementById('tr' + i);
    }
});
//</script>
