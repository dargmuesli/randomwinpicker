import { saveTableCreate, selectItem } from './table';
import { i18n } from './language';

export class customAlert {
    constructor() { }

    render(heading, dialog, task) {
        i18n.then(function (t) {
            let dialogoverlay = document.getElementById('dialogoverlay');
            let dialogbox = document.getElementById('dialogbox');
            dialogoverlay.style.display = 'block';
            dialogbox.style.display = 'inline';
            document.getElementById('dialogboxhead').innerHTML = '<h3>' + heading + '</h3>';
            document.getElementById('dialogboxbody').innerHTML = dialog;
            document.getElementById('dialogboxfoot').innerHTML = '<button id="ok">OK</button><button id="cancel">' + t('functions:alert.cancel') + '</button>';
            document.getElementById('ok').addEventListener('click', () => this.ok(task));
            document.getElementById('cancel').addEventListener('click', () => this.cancel());
        }.bind(this));
    }

    ok(task) {
        document.body.style.overflow = '';

        if (task == 'delete') {
            removeSelected();
        } else if (task == '') {
            this.cancel();
        }
    }

    cancel() {
        document.body.style.overflow = '';
        document.getElementById('dialogbox').style.display = 'none';
        document.getElementById('dialogoverlay').style.display = 'none';
    }
}

export let alert = new customAlert();

export function removeSelected() {
    let selected = document.getElementById('selected');
    let a = selected.parentNode;
    let td = a.parentNode;
    let localitems = td.getElementsByClassName('item');
    let condition = document.getElementById('condition');
    let index = parseInt(a.id.replace('sI(', '').replace(')', ''));

    if (localitems.length > 1) {
        // load = true;
        document.getElementById('selected').parentNode.parentNode.removeChild(document.getElementById('selected').parentNode);
        localitems[0].id = 'selected';

        for (let i = index; i < document.querySelectorAll('.item').length; i++) {
            (function () {
                let iCopy = i;
                let el = document.getElementsByClassName('item')[i].parentNode, elClone = el.cloneNode(true);

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

    alert.cancel();
}
