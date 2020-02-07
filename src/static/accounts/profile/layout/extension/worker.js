function saveSettingsWorker(form, value, http_x_forwarded_prefix) {
    let xhr = new XMLHttpRequest();

    xhr.open('POST', http_x_forwarded_prefix + '/resources/dargmuesli/savesettings.php?form=' + form, false);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    xhr.onreadystatechange = function () {
        if ((xhr.readyState == 4) && (xhr.status == 204)) {
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
    let http_x_forwarded_prefix = event.data.http_x_forwarded_prefix;

    if (typeof args === undefined) {
        console.error('Event does not contain data "args"!');
    }

    if (typeof http_x_forwarded_prefix === undefined) {
        console.error('Event does not contain data "http_x_forwarded_prefix"!');
    }

    saveSettingsWorker(args[0], args[1], http_x_forwarded_prefix);
};
