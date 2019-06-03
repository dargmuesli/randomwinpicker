/*!
* @author Sean Coker <sean@seancoker.com>
* @author Jan Järfalk <jan.jarfalk@unwrongest.com>
* @author Jonas Thelemann <e-mail@jonas-thelemann.de>
* @Version 2.0.0
* @url http://sean.is/building/jquery-airport
* @description Airport is a rather simple text effect plugin for Jquery. It emulates the style of those flickering information boards you sometimes find on airports and train stations.
*/

'use strict';

export function airport(element, array) {

    let opts =
    {
        transition_speed: 1000,
        loop: true,
        fill_space: false,
        colors: null
    },
        chars = ['a', 'b', 'c', 'd', 'e', 'f', 'g', ' ', 'h', 'i', 'j', 'k', 'l', 'm', 'n', 'o', 'p', 'q', 'r', 's', 't', 'u', 'v', 'w', 'x', 'y', 'z', '-', '1', '2', '3', '4', '5', '6', '7', '8', '9', '0', '!', '¿', '?', '-', '+', '.', ',', '\'', '"', 'ç', 'ñ', 'à', 'á', 'è', 'é', 'ì', 'í', 'ò', 'ó', 'ù', 'ú', 'À', 'Á', 'È', 'É', 'Ì', 'Í', 'Ò', 'Ó', 'Ù', 'Ú'],
        spans,
        // colors,
        longest = 0,
        items = array.length,
        items2 = array.length;

    //adds extra spaces to strings in array that are shorter than longest
    function pad(a, b) {
        return a + new Array(b - a.length + 1).join(' ');
    }

    element.innerHTML = '';

    //finds the longest string in array
    while (items--) {
        if (array[items].length > longest) {
            longest = array[items].length;
        }
    }

    //makes all strings in array the same length
    while (items2--) {
        array[items2] = pad(array[items2], longest);
    }

    spans = 0;
    while (spans < longest) {
        let span = document.createElement('span');
        span.className = 'c' + spans;
        element.appendChild(span, parent.firstChild);
        spans++;
    }

    // if (opts.colors) {
    //     colors = opts.colors.replace(/\s+/g, '').split(',');
    // }
    //a - number of the span element
    //b - for checking char[b] against each letter in array[xx]
    //c - current word in array[c]
    //d - used to track position of each letter in array[xx]
    function init(a, b, c, d) {
        let el = element.querySelectorAll('.c' + a)[0],
            current_letter = array[c] ? array[c].substring(d, d + 1) : null,
            // timer,
            // color,
            word_len = array[c] ? array[c].trim().length : null,
            prev_word_len = array[c - 1] ? array[c - 1].trim().length : array[0].trim().length;

        // if (c >= array.length) { //reset
        //     if (!opts.loop) {
        //         clearTimeout(timer);
        //         return;
        //     }
        //     timer = setTimeout(() => {
        //         init(0, 0, 0, 0);
        //     }, 10);
        // } else if (d >= longest) { //go to next word
        //     timer = setTimeout(() => {
        //         if (opts.colors) {
        //             color = colors[~~(Math.random() * colors.length)];
        //             element.css('color', color.substring(0, 1) === '#' ? color : '#' + color);
        //         }
        //         init(0, 0, c + 1, 0);
        //     }, opts.transition_speed);
        // } else {
        el.innerHTML = (chars[b] === ' ') ? '&nbsp;' : chars[b];
        // timer = setTimeout(() => {
        setTimeout(() => {
            if (b > chars.length) {
                init(a + 1, 0, c, d + 1);
            } else if (chars[b] !== current_letter.toLowerCase()) {
                //go to next letter in chars[] if it doesn't match current letter in array[xx]
                init(a, b + 1, c, d);
            } else { //found the letter here
                el.innerHTML = (current_letter === ' ' && opts.fill_space) ? '&nbsp;' : current_letter;
                if (word_len < prev_word_len) {
                    if (a > word_len) {
                        for (a; a < prev_word_len; a++) {
                            element.querySelectorAll('.c' + a).innerHTML = '';
                        }
                        d = longest;
                    }
                }

                if (a + 1 < word_len) {
                    init(a + 1, 0, c, d + 1);
                }
            }
        }, 10);
        // }
    }

    setTimeout(() => init(0, 0, 0, 0), 1000);
}
