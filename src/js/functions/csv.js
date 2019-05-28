import Papa from 'papaparse';

import { reset } from './table';

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
            // editing = true;

            for (let i = 0; i < results.data.length; i++) {
                if (i == results.data.length - 1) {
                    // editing = false;
                }

                document.getElementById('tableInput0').value = results.data[i].username;
                document.getElementById('tableInput1').value = results.data[i].quantity;
                document.getElementById('add').click();
            }
        }
    });
}

document.addEventListener('DOMContentLoaded', function () {
    let csvfile = document.getElementById('csv-file');
    if (csvfile != null) {
        csvfile.onchange = function (event) { handleFileSelect(event, '<?php echo $encoding; ?>'); };
    }
});
