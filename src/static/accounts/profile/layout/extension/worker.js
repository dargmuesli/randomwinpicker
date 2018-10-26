function saveSettingsWorker(form, value) {
    let xhr = new XMLHttpRequest();

    xhr.open('POST', '/resources/dargmuesli/savesettings.php?form=' + form, false);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    xhr.onreadystatechange = function () {
        if ((xhr.readyState == 4) && (xhr.status == 200)) {
            postMessage('done');
        }
    };

    if (form == 'privacyForm') {
        xhr.send('privacy=' + value);
    } else if (form == 'viewForm') {
        xhr.send('view=' + value);
    } else if (form == 'storageForm') {
        xhr.send('storage=' + value);
    } else if (form == 'youtubeForm') {
        xhr.send('youtube=' + value);
    } else if (form == 'encodingForm') {
        xhr.send('encoding=' + value);
    } else if (form == 'priceForm') {
        xhr.send('prices=' + value);
    }
}

onmessage = function (event) {
    let args = event.data.args;

    if (args) {
        saveSettingsWorker(args[0], args[1]);
    }
};
