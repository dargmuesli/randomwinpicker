import { alert } from './alert';
import { recaptchaSitekey } from './globals';

document.addEventListener('DOMContentLoaded', function () {
    let bug = document.getElementById('bug');
    if (typeof (bug) != 'undefined' && bug != null) {
        bug.addEventListener('click', function () {
            document.body.scrollTop = 0;
            document.body.style.overflow = 'hidden';
            alert.render('', '<div id="captcha_container"></div>', '', '');
            grecaptcha.render('captcha_container', {
                'sitekey': recaptchaSitekey, 'theme': 'dark', 'callback': function (response) {
                    validateResponse(response, 'bug');
                }
            });
        });
    }
    let feature = document.getElementById('feature');
    if (typeof (feature) != 'undefined' && feature != null) {
        feature.addEventListener('click', function () {
            document.body.scrollTop = 0;
            document.body.style.overflow = 'hidden';
            alert.render('', '<div id="captcha_container"></div>', '', '');
            grecaptcha.render('captcha_container', {
                'sitekey': recaptchaSitekey, 'theme': 'dark', 'callback': function (response) {
                    validateResponse(response, 'feature');
                }
            });
        });
    }
});

export function validateResponse(response, type) {
    let xhr = new XMLHttpRequest();

    xhr.open('GET', '/resources/dargmuesli/suggest.php?type=' + type + '&g-recaptcha-response=' + response, true);
    xhr.onreadystatechange = function () {
        if (xhr.readyState == 4 && xhr.status == 200) {
            if (xhr.responseText != '') {
                window.location.href = xhr.responseText;
                document.getElementById('ok').click();
            }
        }
    };
    xhr.send();
}
