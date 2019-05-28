import Papa from 'papaparse';

import { reset, setEditing } from './table';

let csvEncodingPromise = new Promise((resolve, reject) => {
    let xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function () {
        if (xhr.readyState !== 4) return;
        if (xhr.status >= 200 && xhr.status < 300) {
            resolve(xhr.responseText);
        } else {
            reject({
                status: xhr.status,
                statusText: xhr.statusText
            });
        }
    };
    xhr.open('GET', document.head.querySelector('[name~=HTTP_X_FORWARDED_PREFIX][content]').content + '/resources/dargmuesli/csv-encoding.php', true);
    xhr.send();
});

document.addEventListener('DOMContentLoaded', function () {
    let csvClick = document.getElementById('csv-click');
    let csvFile = document.getElementById('csv-file');

    if (csvFile != null) {
        csvEncodingPromise.then((csvEncoding) => {
            csvClick.disabled = false;
            csvFile.onchange = (event) => handleFileSelect(event, csvEncoding);
        });
    }
});

export function handleFileSelect(evt, enc) {
    let file = evt.target.files[0];

    Papa.parse(file, {
        header: true,
        dynamicTyping: true,
        encoding: enc,
        complete: async (results) => {
            if (results.errors[0] != null) {
                alert(results.errors[0].message);
            }

            await reset(2, 'participants');
            setEditing(true);

            for (let i = 0; i < results.data.length; i++) {
                if (i == results.data.length - 1) {
                    setEditing(false);
                }

                document.getElementById('tableInput0').value = results.data[i].username;
                document.getElementById('tableInput1').value = results.data[i].quantity;
                document.getElementById('add').click();
            }
        }
    });
}
