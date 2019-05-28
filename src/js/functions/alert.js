import { removeSelected } from './table';
import { i18n } from './language';

export class customAlert {
    constructor() { }

    async render(heading, dialog, task) {
        let t = await i18n;

        let dialogoverlay = document.getElementById('dialogoverlay');
        let dialogbox = document.getElementById('dialogbox');
        dialogoverlay.style.display = 'block';
        dialogbox.style.display = 'inline';
        document.getElementById('dialogboxhead').innerHTML = '<h3>' + heading + '</h3>';
        document.getElementById('dialogboxbody').innerHTML = dialog;
        document.getElementById('dialogboxfoot').innerHTML = '<button id="ok">OK</button><button id="cancel">' + t('functions:alert.cancel') + '</button>';
        document.getElementById('ok').addEventListener('click', () => this.ok(task));
        document.getElementById('cancel').addEventListener('click', () => this.cancel());
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
