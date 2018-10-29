document.addEventListener('DOMContentLoaded', function () {
    let tableInput0 = document.getElementById('tableInput0');
    if (tableInput0 != null) {
        tableInput0.onkeypress = function (e) {
            if (e.keyCode == 13) {
                let add = document.getElementById('add');
                if (add != null) {
                    add.click();
                }
            }
        };
    }
    let tableInput1 = document.getElementById('tableInput1');
    if (tableInput1 != null) {
        tableInput1.onkeypress = function (e) {
            if (e.keyCode == 13) {
                let add = document.getElementById('add');
                if (add != null) {
                    add.click();
                }
            }
        };
    }
});
