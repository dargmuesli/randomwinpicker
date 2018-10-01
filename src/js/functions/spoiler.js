var visible = false;
var spoiler;
var link;

document.addEventListener('DOMContentLoaded', function () {
    spoiler = document.getElementsByClassName('spoiler')[0];
    link = document.getElementById('link');

    if (spoiler) {
        spoiler.addEventListener('transitionend', function () {
            if (visible == false) {
                spoiler.style.overflowY = 'hidden';
                spoiler.style.maxHeight = '0px';
                link.innerHTML = '&#x25B8;';
            } else {
                spoiler.style.opacity = '1';
            }
        }, false);
    }
});

export function showSpoiler() {
    if ((spoiler.style.overflowY == 'hidden') || (spoiler.style.overflowY == '')) {
        visible = true;
        spoiler.style.overflowY = 'visible';
        spoiler.style.maxHeight = '50vh';
        link.innerHTML = '&#x25BE;';
    } else {
        visible = false;
        spoiler.style.opacity = '0';
    }
}
