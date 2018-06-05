function saveSettingsWorker(form, value) {
    var xmlhttp = new XMLHttpRequest();

    xmlhttp.open('POST', 'savesettings.php?form=' + form, false);
    xmlhttp.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
    xmlhttp.onreadystatechange = function () {
        if ((xmlhttp.readyState == 4) && (xmlhttp.status == 200)) {
            postMessage('done');
        }
    };

    if (form == 'privacyForm') {
        xmlhttp.send('privacy=' + value);
    } else if (form == 'viewForm') {
        xmlhttp.send('view=' + value);
    } else if (form == 'storageForm') {
        xmlhttp.send('storage=' + value);
    } else if (form == 'youtubeForm') {
        xmlhttp.send('youtube=' + value);
    } else if (form == 'encodingForm') {
        xmlhttp.send('encoding=' + value);
    } else if (form == 'priceForm') {
        xmlhttp.send('prices=' + value);
    }
}

onmessage = function (event) {
    var args = event.data.args;
    saveSettingsWorker(args[0], args[1]);
};
