import i18next from 'i18next';
import XHR from 'i18next-xhr-backend';
import LngDetector from 'i18next-browser-languagedetector';

export let i18n = i18next
    .use(XHR)
    .use(LngDetector)
    .init({
        detection: {
            order: ['querystring', 'htmlTag']
        },
        fallbackLng: 'en',
        ns: ['functions'],
        defaultNS: 'functions',
        backend: {
            loadPath: '/resources/dargmuesli/translation/i18next/{{lng}}/{{ns}}.json'
        }
    }, function () {
    });

document.addEventListener('DOMContentLoaded', function () {
    document.getElementById('lang').addEventListener('click', function () {
        changeLanguage(this.className.split(' ')[1]);
    });
});

export function changeLanguage(lang) {
    var xmlhttp = new XMLHttpRequest();

    xmlhttp.open('POST', '/resources/dargmuesli/language.php', true);
    xmlhttp.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    xmlhttp.onreadystatechange = function () {
        if (xmlhttp.readyState == 4) {
            location.reload();
        }
    };
    xmlhttp.send('language=' + lang);
}
