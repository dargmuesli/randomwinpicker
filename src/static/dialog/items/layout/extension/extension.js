var count = 0;

function importSession() {
    var http = new XMLHttpRequest();

    http.open('GET', '/resources/dargmuesli/sessioncookie.php?task=importSession', true);
    http.onreadystatechange = function () {
        if (http.readyState == 4 && http.status == 200) {
            location.reload();
        }
    }
    http.send();
}

function testGo() {
    var proceed = true;
    var items = document.getElementsByClassName('item');

    for (var i = 0; i < items.length; i++) {
        if (items[i].childNodes[1].childNodes[2] == null || items[i].childNodes[1].childNodes[2].innerHTML == '') {
            proceed = false;
        }
    }

    if (proceed) {
        window.location = 'layout/extension/extension.php?quantity=' + count;
    } else {
        alert(Dargmuesli.Language.i18n.t('functions:extension.items.warning'));
    }
}

document.addEventListener('DOMContentLoaded', function () {
    function refreshTable() {
        var rowCount = document.getElementById('categories').getElementsByTagName('tr').length - 1;

        for (var i = 1; i <= rowCount; i++) {
            var elements = document.getElementById('tr' + i).getElementsByClassName('set');

            for (var j = 0; j < elements.length; j++) {
                var link = elements[0].className.substring(4, elements[0].className.length);
                var condition = elements[0].parentNode.lastChild.getElementsByTagName('span')[0].innerHTML;
                var type = elements[0].parentNode.lastChild.getElementsByTagName('span')[1].innerHTML;

                elements[0].parentNode.parentNode.click();
                Dargmuesli.Alert.removeSelected();
                Dargmuesli.FileTree.openFile(link);

                var selected = document.getElementById('selected');
                selected.lastChild.getElementsByTagName('span')[0].innerHTML = condition;
                selected.lastChild.getElementsByTagName('span')[1].innerHTML = type;
            }
        }
    }

    refreshTable();

    load = true;

    document.getElementById('tableInput0').value = count + 1;
    document.getElementById('tableInput1').value = '<button class="link" title="Win" id="sI(' + document.getElementsByClassName('item').length + ')">';

    Dargmuesli.Table.selectItem(document.querySelectorAll('.item').length - 1);

    if (document.getElementsByClassName('item')[document.querySelectorAll('.item').length - 1].className == 'item meleeweapons') {
        document.getElementById('quality').className = 'meleeweapons';
        document.getElementById('quality').selectedIndex = 7;
        document.getElementById('quality').disabled = true;
    }

    var box = document.getElementById('box');
    if (typeof (box) != 'undefined' && box != null) {
        box.addEventListener('click', function () { customAlert.render('', '<div id="captcha_container"></div>', '', ''); grecaptcha.render('captcha_container', { 'sitekey': '<?php echo get_recaptcha_sitekey(); ?>', 'theme': 'dark', 'callback': function (response) { validateResponse(response, 'feature'); } }); });
    }
    var hideimages = document.getElementById('hideimages');
    if (typeof (hideimages) != 'undefined' && hideimages != null) {
        hideimages.addEventListener('click', function () { Dargmuesli.FileTree.hideImages(); });
    }
    var element = document.getElementById('importSession');
    if (typeof (element) != 'undefined' && element != null) {
        element.addEventListener('click', function () { importSession(); });
    }
    var testGoElement = document.getElementById('testGo');
    if (typeof (testGoElement) != 'undefined' && testGoElement != null) {
        testGoElement.addEventListener('click', function () { testGo(); });
    }
    var chkType = document.getElementById('chkType');
    if (typeof (chkType) != 'undefined' && chkType != null) {
        chkType.addEventListener('click', function () { Dargmuesli.FileTree.assignStatTrak(); });
    }
    var condition = document.getElementById('condition');
    if (typeof (condition) != 'undefined' && condition != null) {
        condition.addEventListener('change', function () { Dargmuesli.FileTree.assignCondition(); });
    }
    var add = document.getElementById('add');
    if (typeof (add) != 'undefined' && add != null) {
        add.addEventListener('click', function () { Dargmuesli.Table.sendRow(2, [0], 'items') });
    }
    var resetElement = document.getElementById('reset');
    if (typeof (resetElement) != 'undefined' && resetElement != null) {
        resetElement.addEventListener('click', function () { Dargmuesli.Table.reset(2, 'items') });
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
                        Dargmuesli.Table.getChildNode(child, 0).addEventListener('click', function () { Dargmuesli.Table.removeRow(iCopy, 2, 'items') });;
                    } else if (child.className == 'up' && child.childNodes[1] != null) {
                        Dargmuesli.Table.getChildNode(child, 0).addEventListener('click', function () { Dargmuesli.Table.moveRowUp(iCopy, 2, 'items') });;
                    } else if (child.className == 'down' && child.childNodes[1] != null) {
                        Dargmuesli.Table.getChildNode(child, 0).addEventListener('click', function () { Dargmuesli.Table.moveRowDown(iCopy, 2, 'items') });;
                    }
                }())
            }
        }

        i++;
        tr = document.getElementById('tr' + i);
    }

    i = 0;
    var sI = document.getElementById('sI(' + i + ')');

    while (sI != null) {
        (function () {
            var iCopy = i;

            sI.addEventListener('click', function () { Dargmuesli.Table.selectItem(iCopy) });;
        }())

        i++;
        sI = document.getElementById('sI(' + i + ')');
    }
});
