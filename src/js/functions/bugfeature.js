import { customAlert } from './alert.js';

document.addEventListener('DOMContentLoaded', function () {
    var bug = document.getElementById('bug');
    if (typeof (bug) != 'undefined' && bug != null) {
        bug.addEventListener('click', function () {
            document.body.scrollTop = 0;
            document.body.style.overflow = 'hidden';
            new customAlert().render('', '<div id="captcha_container"></div>', '', '');
            // grecaptcha.render('captcha_container', { 'sitekey': '<?php echo get_recaptcha_sitekey(); ?>', 'theme': 'dark', 'callback': function (response) { validateResponse(response, 'bug'); } });
        });
    }
    var feature = document.getElementById('feature');
    if (typeof (feature) != 'undefined' && feature != null) {
        feature.addEventListener('click', function () {
            document.body.scrollTop = 0;
            document.body.style.overflow = 'hidden';
            new customAlert().render('', '<div id="captcha_container"></div>', '', '');
            // grecaptcha.render('captcha_container', { 'sitekey': '<?php echo get_recaptcha_sitekey(); ?>', 'theme': 'dark', 'callback': function (response) { validateResponse(response, 'feature'); } });
        });
    }
});

export function validateResponse(response, type) {
    var http = new XMLHttpRequest();

    http.open('GET', '../layout/scripts/suggest.php?type=' + type + '&g-recaptcha-response=' + response, true);
    http.onreadystatechange = function () {
        if (http.readyState == 4 && http.status == 200) {
            if (http.responseText != '') {
                window.location.href = http.responseText;
                document.getElementById('ok').click();
            }
        }
    };
    http.send();
}
