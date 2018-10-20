import { saveTableCreate, selectItem } from './table.js';
import { i18n } from './translations.js';

export function customAlert() {
    this.render = function (heading, dialog, file, task) {
        var dialogoverlay = document.getElementById('dialogoverlay');
        var dialogbox = document.getElementById('dialogbox');
        // var body = document.getElementsByTagName('body')[0];

        dialogoverlay.style.display = 'block';
        dialogbox.style.display = 'inline';
        document.getElementById('dialogboxhead').innerHTML = '<h3>' + heading + '</h3>';
        document.getElementById('dialogboxbody').innerHTML = dialog;
        document.getElementById('dialogboxfoot').innerHTML = '<button id="ok">OK</button><button id="cancel">' + i18n.t('functions:alert.cancel') + '</button>';
        document.getElementById('ok').addEventListener('click', () => this.ok(file, task));
        document.getElementById('ok').addEventListener('click', function () { this.ok(file, task); });
        document.getElementById('cancel').addEventListener('click', function () { this.cancel(); });
    };

    this.ok = function (file, task) {
        document.body.style.overflow = '';

        if (task == 'contribute') {
            window.location.href = 'contribute.php?file=' + file;
        } else if (task == 'delete') {
            removeSelected();
        } else if (task == '') {
            this.cancel();
        }
    };

    this.cancel = function () {
        document.body.style.overflow = '';

        document.getElementById('dialogbox').style.display = 'none';
        document.getElementById('dialogoverlay').style.display = 'none';
    };
}

export function removeSelected() {
    var selected = document.getElementById('selected');
    var a = selected.parentNode;
    var td = a.parentNode;
    var localitems = td.getElementsByClassName('item');
    var condition = document.getElementById('condition');
    var index = parseInt(a.id.replace('sI(', '').replace(')', ''));

    if (localitems.length > 1) {
        // load = true;
        document.getElementById('selected').parentNode.parentNode.removeChild(document.getElementById('selected').parentNode);
        localitems[0].id = 'selected';

        for (var i = index; i < document.querySelectorAll('.item').length; i++) {
            (function () {
                var iCopy = i;
                var el = document.getElementsByClassName('item')[i].parentNode, elClone = el.cloneNode(true);

                el.parentNode.replaceChild(elClone, el);
                elClone.id = 'sI(' + i + ')'; //ID aufrücken
                elClone.addEventListener('click', function () { selectItem(iCopy); }); //Eventlistener aufrücken
            }());
        }

    } else {
        document.getElementById('selected').innerHTML = '<img>---<br><figcaption><span></span><span></span></figcaption>';
        selected.className = 'item';

        condition.disabled = true;
    }

    saveTableCreate(2, 'items', document.getElementById('categories').parentNode);

    /*!*/    document.getElementById('tableInput1').value = '<button class="link" title="Win" id="sI(' + document.getElementsByClassName('item').length + ')">'; //Event aktualisieren  onclick="selectItem(' + document.getElementsByClassName('item').length + ')"

    customAlert.cancel();
}
