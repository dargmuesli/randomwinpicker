function sendFiles() {
    var filesArray = document.getElementById('fileElem').files;

    for (var i = 0; i < filesArray.length; i++) {
        upload(filesArray[i], '/randomwinpicker/dialog/items.php');
    }
}

function upload(file, uri) {
    var xhr = new XMLHttpRequest();
    var fd = new FormData();

    xhr.open('POST', uri, true);
    xhr.onreadystatechange = function () {
        if (xhr.readyState == 4 && xhr.status == 200) {
            // var tmp = xhr.responseText;
        }
    };
    fd.append('myFile', file);
    xhr.send(fd);
}
