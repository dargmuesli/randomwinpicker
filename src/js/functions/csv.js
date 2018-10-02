import { reset } from './table.js';

export function handleFileSelect(evt, enc) {
    var file = evt.target.files[0];

    Papa.parse(file, {
        header: true,
        dynamicTyping: true,
        encoding: enc,
        complete: function (results) {
            if (results.errors[0] != null) {
                alert(results.errors[0].message);
            }

            reset(2, 'participants');
            // editing = true;

            for (var i = 0; i < results.data.length; i++) {
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
    var csvfile = document.getElementById('csv-file');
    if (csvfile != null) {
        csvfile.onchange = function (event) { handleFileSelect(event, '<?php echo $encoding; ?>'); };
    }
});
