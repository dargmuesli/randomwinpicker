export function sendFiles() {
    let filesArray = document.getElementById('fileElem').files;

    for (let i = 0; i < filesArray.length; i++) {
        upload(filesArray[i], '/randomwinpicker/dialog/items.php');
    }
}

export function upload(file, uri) {
    let xhr = new XMLHttpRequest();
    let fd = new FormData();

    xhr.open('POST', uri, true);
    xhr.onreadystatechange = function () {
        if (xhr.readyState == 4 && xhr.status == 200) {
            // let tmp = xhr.responseText;
        }
    };
    fd.append('myFile', file);
    xhr.send(fd);
}
