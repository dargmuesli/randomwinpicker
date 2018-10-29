document.addEventListener('DOMContentLoaded', function () {
    document.getElementById('btn_title').addEventListener('click', function () {
        index = start_title;
        retrieveTitleData();
        document.getElementById('title').innerHTML = 'Running<br>';
    });
    document.getElementById('btn_json').addEventListener('click', function () {
        index = start_json;
        retrieveJsonData();
        document.getElementById('json').innerHTML = 'Running<br>';
    });
    document.getElementById('start_json').addEventListener('change', function () {
        var newValue = parseInt(this.value);
        if (newValue > start_json) {
            testStartEnd('start', 'up', 'json', newValue);
        } else {
            testStartEnd('start', 'down', 'json', newValue);
        }
    });
    document.getElementById('start_title').addEventListener('change', function () {
        //start_title = this.value;
        var newValue = parseInt(this.value);
        if (newValue > start_title) {
            testStartEnd('start', 'up', 'title', newValue);
        } else {
            testStartEnd('start', 'down', 'title', newValue);
        }
    });
    document.getElementById('end_json').addEventListener('change', function () {
        var newValue = parseInt(this.value);
        if (newValue > end_json) {
            testStartEnd('end', 'up', 'json', newValue);
        } else {
            testStartEnd('end', 'down', 'json', newValue);
        }
    });
    document.getElementById('end_title').addEventListener('change', function () {
        //end_title = this.value;
        var newValue = parseInt(this.value);
        if (newValue > end_title) {
            testStartEnd('end', 'up', 'title', newValue);
        } else {
            testStartEnd('end', 'down', 'title', newValue);
        }
    });

    start_title = parseInt(document.getElementById('start_title').value);
    end_title = parseInt(document.getElementById('end_title').value);
    start_json = parseInt(document.getElementById('start_json').value);
    end_json = parseInt(document.getElementById('end_json').value);

    document.getElementById('fileselect').onchange = function () {
        var file = document.getElementById('fileselect').files[0];
        if (file) {
            var reader = new FileReader();
            reader.readAsText(file, 'ISO-8859-1');
            reader.onload = function (evt) {
                download('utf-8.csv', evt.target.result);
            }
        }
    };
});

function download(filename, text) {
    var pom = document.createElement('a');
    pom.setAttribute('href', 'data:text/plain;charset=utf-8,' + encodeURIComponent(text));
    pom.setAttribute('download', filename);

    if (document.createEvent) {
        var event = document.createEvent('MouseEvents');
        event.initEvent('click', true, true);
        pom.dispatchEvent(event);
    }
    else {
        pom.click();
    }
}

var start_title = 0;
var end_title = 0;
var index = 0;
var start_json = 0;
var end_json = 0;

function retrieveTitleData() {
    setTimeout(function () {
        var xhr = new XMLHttpRequest();
        xhr.open('GET', '?i=' + index, false);
        xhr.onreadystatechange = function () {
            if ((xhr.readyState == 4) && (xhr.status == 200)) {
                if (xhr.responseText != 'CS:GO Stash - Browse all skins, stickers, and music<br>') {
                    document.getElementById('title').innerHTML += 'https://csgostash.com/skin/' + index + '/' + xhr.responseText.replace(' - CS:GO Stash', '').replace(' | ', '-').replace(/\s/g, '-');
                }

                if (index < end_title) {
                    index++;
                    retrieveTitleData();
                } else {
                    index = 0;
                    document.getElementById('title').innerHTML = document.getElementById('title').innerHTML.replace('Running', '');
                }
            }
        }
        xhr.send();
    }, 1);
}

function retrieveJsonData() {
    setTimeout(function () {
        var xhr = new XMLHttpRequest();
        xhr.open('GET', '?j=' + index, false);
        xhr.onreadystatechange = function () {
            if ((xhr.readyState == 4) && (xhr.status == 200)) {
                var jsonNode = document.getElementById('json');

                jsonNode.innerHTML += xhr.responseText;

                if (index < end_json) {
                    index++;
                    retrieveJsonData();
                } else {
                    index = 0;
                    jsonNode.innerHTML = jsonNode.innerHTML.replace('Running', '');
                }
            }
        }
        xhr.send();
    }, 1);
}

function testStartEnd(position, direction, type, newValue) {
    var startNode;
    var endNode;
    var start;
    var end;

    if (type == 'json') {
        startNode = document.getElementById('start_json');
        endNode = document.getElementById('end_json');
        start = start_json;
        end = end_json;
    } else if (type == 'title') {
        startNode = document.getElementById('start_title');
        endNode = document.getElementById('end_title');
        start = start_title;
        end = end_title;
    }

    if (position == 'start') {
        start = newValue;

        if (direction == 'up' && start > end) {
            end = start;
            endNode.value = start;
        }
    } else if (position == 'end') {
        end = newValue;

        if (direction == 'down' && end < start) {
            start = end;
            startNode.value = end;
        }
    }

    if (type == 'json') {
        start_json = start;
        end_json = end;
    } else if (type == 'title') {
        start_title = start;
        end_title = end;
    }
}
