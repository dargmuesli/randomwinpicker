function importSession() {
    let xhr = new XMLHttpRequest();

    xhr.open('GET', document.head.querySelector('[name~=HTTP_X_FORWARDED_PREFIX][content]').content + '/resources/dargmuesli/sessioncookie.php?task=importSession', true);
    xhr.onreadystatechange = function () {
        if (xhr.readyState == 4 && xhr.status == 200) {
            location.reload();
        }
    };
    xhr.send();
}

async function testGo() {
    let t = await Dargmuesli.Language.i18n;
    let proceed = true;
    let items = document.getElementsByClassName('item');

    for (let i = 0; i < items.length; i++) {
        if (items[i].childNodes[1].childNodes[2] == null || items[i].childNodes[1].childNodes[2].innerHTML == '') {
            proceed = false;
        }
    }

    if (proceed) {
        await Dargmuesli.Table.xhrPromise;
        window.location = 'layout/extension/extension.php?quantity=' + Dargmuesli.Table.count;
    } else {
        alert(t('functions:extension.items.warning'));
    }
}

document.addEventListener('DOMContentLoaded', async () => {
    // async function refreshTable() {
    //     let rowCount = document.getElementById('categories').getElementsByTagName('tr').length - 1;

    //     for (let i = 1; i <= rowCount; i++) {
    //         let elements = document.getElementById('tr' + i).getElementsByClassName('set');

    //         for (let j = 0; j < elements.length; j++) {
    //             let link = elements[0].className.substring(4, elements[0].className.length);
    //             let condition = elements[0].parentNode.lastChild.getElementsByTagName('span')[0].innerHTML;
    //             let type = elements[0].parentNode.lastChild.getElementsByTagName('span')[1].innerHTML;

    //             await Dargmuesli.Table.selectItem(parseInt(/sI\((.+)\)/.exec(elements[0].parentNode.parentNode.id)[1]));
    //             Dargmuesli.Table.removeSelected();
    //             await Dargmuesli.FileTree.openFile(link);

    //             let selected = document.getElementById('selected');
    //             selected.lastChild.getElementsByTagName('span')[0].innerHTML = condition;
    //             selected.lastChild.getElementsByTagName('span')[1].innerHTML = type;
    //         }
    //     }
    // }

    // await refreshTable();

    (async () => {
        Dargmuesli.Table.tableLoading = true;
        await Dargmuesli.Table.xhrPromise;
        document.getElementById('tableInput0').value = Dargmuesli.Table.count + 1;
        document.getElementById('tableInput1').value = '<button class="link" title="Win" id="sI(' + document.getElementsByClassName('item').length + ')">';

        // Choose the last item in the last row
        if (document.getElementsByClassName('item')[document.querySelectorAll('.item').length - 1].id != 'selected') {
            await Dargmuesli.Table.selectItem(document.querySelectorAll('.item').length - 1);
        }

        if (document.getElementsByClassName('item')[document.querySelectorAll('.item').length - 1].className == 'item meleeweapons') {
            document.getElementById('quality').className = 'meleeweapons';
            document.getElementById('quality').selectedIndex = 7;
            document.getElementById('quality').disabled = true;
        }

        let box = document.getElementById('box');

        if (typeof (box) != 'undefined' && box != null) {
            box.addEventListener('click', async () => {
                await Dargmuesli.Alert.alert.render('', '<div id="captcha_container"></div>', '');
                grecaptcha.render('captcha_container', {
                    'sitekey': Dargmuesli.Globals.recaptchaSitekey, 'theme': 'dark', 'callback': function (response) {
                        Dargmuesli.BugFeature.validateResponse(response, 'feature');
                    }
                });
            });
        }

        let hideimages = document.getElementById('hideimages');

        if (typeof (hideimages) != 'undefined' && hideimages != null) {
            hideimages.addEventListener('click', async () => await Dargmuesli.FileTree.hideImages());
        }

        let element = document.getElementById('importSession');

        if (typeof (element) != 'undefined' && element != null) {
            element.addEventListener('click', () => { importSession(); });
        }

        let testGoElement = document.getElementById('testGo');

        if (typeof (testGoElement) != 'undefined' && testGoElement != null) {
            testGoElement.addEventListener('click', async () => await testGo());
        }

        let chkType = document.getElementById('chkType');

        if (typeof (chkType) != 'undefined' && chkType != null) {
            chkType.addEventListener('click', () => { Dargmuesli.FileTree.assignStatTrak(); });
        }

        let condition = document.getElementById('condition');

        if (typeof (condition) != 'undefined' && condition != null) {
            condition.addEventListener('change', async () => await Dargmuesli.FileTree.assignCondition());
        }

        let add = document.getElementById('add');

        if (typeof (add) != 'undefined' && add != null) {
            add.addEventListener('click', async () => await Dargmuesli.Table.sendRow(2, [0], 'items'));
        }

        let resetElement = document.getElementById('reset');

        if (typeof (resetElement) != 'undefined' && resetElement != null) {
            resetElement.addEventListener('click', async () => await Dargmuesli.Table.reset(2, 'items'));
        }

        let i = 1;
        let tr = document.getElementById('tr' + i);

        while (tr != null) {
            for (let j = 0; j < tr.childNodes.length; j++) {
                let child = tr.childNodes[j];

                if (child != null && child.nodeType != 3) {
                    (function () {
                        let iCopy = i;

                        if (child.className == 'remove') {
                            Dargmuesli.Table.getChildNode(child, 0).addEventListener('click', async () => await Dargmuesli.Table.removeRow(iCopy, 2, 'items'));
                        } else if (child.className == 'up' && child.childNodes[1] != null) {
                            Dargmuesli.Table.getChildNode(child, 0).addEventListener('click', () => { Dargmuesli.Table.moveRowUp(iCopy, 2, 'items'); });
                        } else if (child.className == 'down' && child.childNodes[1] != null) {
                            Dargmuesli.Table.getChildNode(child, 0).addEventListener('click', () => { Dargmuesli.Table.moveRowDown(iCopy, 2, 'items'); });
                        }
                    }());
                }
            }

            i++;
            tr = document.getElementById('tr' + i);
        }

        // Add selectItem event listeners to all items
        i = 0;
        let sI = document.getElementById('sI(' + i + ')');

        while (sI != null) {
            (function () {
                let iCopy = i;

                sI.addEventListener('click', async () => await Dargmuesli.Table.selectItem(iCopy));
            }());

            i++;
            sI = document.getElementById('sI(' + i + ')');
        }
    })();
});
