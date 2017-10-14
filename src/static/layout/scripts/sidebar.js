document.addEventListener('DOMContentLoaded', function () {
    var sidebars = document.getElementsByClassName('sidebar');

    if (sidebars[0] != null) {
        var rectBound = sidebars[0].getBoundingClientRect();

        var state1 = rectBound.top / 3;
        var state2 = 2 * rectBound.top / 3;
        var state3 = rectBound.top;

        window.onscroll = scrollFun;

        sidebars[0].classList.add('notransition');
        sidebars[1].classList.add('notransition');
        scrollFun();
        sidebars[0].offsetHeight;
        sidebars[1].offsetHeight;
        sidebars[0].classList.remove('notransition');
        sidebars[1].classList.remove('notransition');
    }

    function scrollFun() {
        if (window.scrollY > state3) {
            sidebars[0].style.marginTop = '-' + state3 + 'px';
            sidebars[1].style.marginTop = '-' + state3 + 'px';
        } else if (window.scrollY > state2) {
            sidebars[0].style.marginTop = '-' + state2 + 'px';
            sidebars[1].style.marginTop = '-' + state2 + 'px';
        } else if (window.scrollY > state1) {
            sidebars[0].style.marginTop = '-' + state1 + 'px';
            sidebars[1].style.marginTop = '-' + state1 + 'px';
        } else {
            sidebars[0].style.marginTop = '0px';
            sidebars[1].style.marginTop = '0px';
        }
    };
});
