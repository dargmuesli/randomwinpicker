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
