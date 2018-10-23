// Make links clickable
document.addEventListener('DOMContentLoaded', function () {
    document.getElementById('sS(priceForm, true)').addEventListener('click', function () { saveSettings('priceForm', 'true'); });
    document.getElementById('sS(priceForm, false)').addEventListener('click', function () { saveSettings('priceForm', 'false'); });
    document.getElementById('sS(privacyForm, E-mail address)').addEventListener('click', function () { saveSettings('privacyForm', 'E-mail address'); });
    document.getElementById('sS(privacyForm, Member)').addEventListener('click', function () { saveSettings('privacyForm', 'Member'); });
    document.getElementById('sS(privacyForm, Custom)').addEventListener('click', function () { saveSettings('privacyForm', document.getElementById('sS(privacyForm, this.value)').value); });
    document.getElementById('sS(privacyForm, this.value)').addEventListener('change', function () { saveSettings('privacyForm', this.value); });
    document.getElementById('sS(encodingForm, UTF-8)').addEventListener('click', function () { saveSettings('encodingForm', 'UTF-8'); });
    document.getElementById('sS(encodingForm, ISO-8859-1)').addEventListener('click', function () { saveSettings('encodingForm', 'ISO-8859-1'); });
    document.getElementById('sS(encodingForm, Custom)').addEventListener('click', function () { saveSettings('encodingForm', document.getElementById('sS(encodingForm, this.value)').value); });
    document.getElementById('sS(encodingForm, this.value)').addEventListener('change', function () { saveSettings('encodingForm', this.value); });
    document.getElementById('sS(viewForm, Instructions)').addEventListener('click', function () { saveSettings('viewForm', 'Instructions'); });
    document.getElementById('sS(viewForm, Controls)').addEventListener('click', function () { saveSettings('viewForm', 'Controls'); });
    document.getElementById('sS(viewForm, Data)').addEventListener('click', function () { saveSettings('viewForm', 'Data'); });
    document.getElementById('sS(storageForm, Session)').addEventListener('click', function () { saveSettings('storageForm', 'Session'); });
    document.getElementById('sS(storageForm, Cookies)').addEventListener('click', function () { saveSettings('storageForm', 'Cookies'); });
    document.getElementById('sS(youtubeForm, this.value)').addEventListener('change', function () { saveSettings('youtubeForm', this.value); });
});

let pendingRequests = 0;
let w;

export function stopEnterKey(evt) {
    evt = (evt) ? evt : ((event) ? event : null);
    // let node = (evt.target) ? evt.target : ((evt.srcElement) ? evt.srcElement : null);
    if (evt.keyCode == 13) { evt.preventDefault(); document.activeElement.blur(); }
}

document.onkeypress = stopEnterKey;

export function saveSettings(form, value) {
    pendingRequests++;

    if (pendingRequests == 1) {
        document.getElementById('saveStatus').style.display = 'initial';
    }

    startWorker(form, value);
}

export function startWorker(form, value) {
    if (typeof (w) == 'undefined') {
        w = new Worker('/resources/dargmuesli/savesettings.js');
    }

    w.postMessage({ 'args': [form, value] });
    w.onmessage = function (event) {
        if (event.data == 'done') {
            pendingRequests--;

            if (pendingRequests == 0) {
                document.getElementById('saveStatus').style.display = 'none';
            }
        }
    };
}

export function stopWorker() {
    w.terminate();
    w = undefined;
}
