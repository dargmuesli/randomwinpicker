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
            loadPath: document.head.querySelector('[name~=HTTP_X_FORWARDED_PREFIX][content]').content + '/resources/dargmuesli/translation/i18next/{{lng}}/{{ns}}.json'
        }
    });

document.addEventListener('DOMContentLoaded', function () {
    document.getElementById('lang').addEventListener('click', function () {
        changeLanguage(this.className.split(' ')[1]);
    });
});

export function changeLanguage(lang) {
    let xhr = new XMLHttpRequest();

    xhr.open('POST', document.head.querySelector('[name~=HTTP_X_FORWARDED_PREFIX][content]').content + '/resources/dargmuesli/language.php', true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    xhr.onreadystatechange = function () {
        if (xhr.readyState == 4) {
            location.reload();
        }
    };
    xhr.send('language=' + lang);
}
