import i18next from 'i18next';
import XHR from 'i18next-xhr-backend';

export let i18n = i18next
    .use(XHR)
    .init({
        fallbackLng: 'en',
        debug: true,
        ns: ['functions'],
        defaultNS: 'functions',
        backend: {
            loadPath: '/resources/dargmuesli/translation/i18next/{{lng}}/{{ns}}.json'
        }
    }, function () {
    });

document.addEventListener('DOMContentLoaded', function () {
    document.getElementById('lang').addEventListener('click', function () {
        prepareSite(this.className.split(' ')[1]);
    });
});

export function prepareSite(lang) {
    // languageChanging = true;

    changeLanguage(lang);
}

export function changeLanguage(lang) {
    var xmlhttp = new XMLHttpRequest();

    xmlhttp.open('POST', '/resources/dargmuesli/language.php', true);
    xmlhttp.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
    xmlhttp.onreadystatechange = function () {
        if (xmlhttp.readyState == 4) {
            location.reload();
        }
    };
    xmlhttp.send('language=' + lang);
}
