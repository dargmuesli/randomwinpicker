document.addEventListener('DOMContentLoaded', function () {
    document.getElementById('lang').addEventListener('click', function(){prepareSite(this.className.split(' ')[1]);});
});

export function prepareSite(lang) {
    // languageChanging = true;

    changeLanguage(lang);
}

export function changeLanguage(lang) {
    var xmlhttp = new XMLHttpRequest();

    xmlhttp.open('POST', '../layout/scripts/language.php', true);
    xmlhttp.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
    xmlhttp.onreadystatechange = function() {
        if (xmlhttp.readyState == 4) {
            location.reload();
        }
    };
    xmlhttp.send('language=' + lang);
}