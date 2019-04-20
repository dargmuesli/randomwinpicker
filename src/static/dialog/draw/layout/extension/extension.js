// window.location = '/dialog/items/';

let index = 0;
let items, participants, prices, round;
let winners = {};

let documentLoaded = false;
let extensionXhrReturned = false;

let xhr = new XMLHttpRequest();

xhr.open('GET', 'layout/extension/extension.php', true);
xhr.onreadystatechange = function () {
    if (xhr.readyState == 4 && xhr.status == 200) {
        let json = JSON.parse(xhr.responseText);

        items = json.items;
        participants = json.participants;
        prices = json.prices;
        round = parseInt(json.quantity);

        extensionXhrReturned = true;

        getRandom();
    }
};
xhr.send();

function draw() {
    Dargmuesli.Language.i18n.then(function (t) {
        if (round <= 0) {
            return;
        }

        let go = document.getElementById('go');

        document.getElementById('loading').style.display = '';
        document.getElementById('fader').style.display = 'none';

        if (go != null) {
            go.remove();
        }

        let content = document.getElementById('content');
        let again = document.getElementById('fader');
        let reveal = document.getElementById('reveal');
        let priceNames = '';

        index = 0;

        let imageStartIndices;
        let names = [];
        let qualities = [];
        let images = [];
        let win = '';

        if (typeof items[(round - 1)] != 'undefined') {
            let item = items[(round - 1)]['column1'];
            let name = item.replace(/<\/?[^>]+(>|$)/g, ' ');

            name = name.replace(/\s\s\s+/g, '<br>');
            name = name.replace(/\s\s+/g, ' ');
            name = name.substring(4, name.length - 4);

            names = name.split('<br>');

            name = name.replace(/,/g, '').replace(/ /g, '-');
            name = name.replace(/-\[FN\]/g, '&condition=Factory New');
            name = name.replace(/-\[MW\]/g, '&condition=Minimal Wear');
            name = name.replace(/-\[MG\]/g, '&condition=Minimal Wear');
            name = name.replace(/-\[FT\]/g, '&condition=Field-Tested');
            name = name.replace(/-\[EE\]/g, '&condition=Field-Tested');
            name = name.replace(/-\[WW\]/g, '&condition=Well-Worn');
            name = name.replace(/-\[AG\]/g, '&condition=Well-Worn');
            name = name.replace(/-\[BS\]/g, '&condition=Battle-Scarred');
            name = name.replace(/-\[KS\]/g, '&condition=Battle-Scarred');
            name = name.replace(/-\[ST\]/g, '&tag=st');
            name = name.replace(/-\[SV\]/g, '&tag=sv');

            priceNames = name.split('<br>');

            let qualityStartIndices = getAllIndexes(item, 'item');

            for (let i = 0; i < qualityStartIndices.length; i++) {
                let qualityEndIndex = item.indexOf('"', qualityStartIndices[i]);
                if (qualityEndIndex - qualityStartIndices[i] != 4) {
                    qualities[i] = item.substring(qualityStartIndices[i] + 5, qualityEndIndex);
                } else {
                    qualities[i] = '';
                }
            }

            imageStartIndices = getAllIndexes(item, 'src');
            let imageEndIndices = getAllIndexes(item, 'alt');

            for (let i = 0; i < imageStartIndices.length; i++) {
                images[i] = item.substring(imageStartIndices[i] + 5, imageEndIndices[i] - 2);
            }

            index++;

            if (prices) {
                win = '<figure class="opensans win ' + qualities[0] + '" id="fig' + index + '"><div class="price"></div><img align="middle" alt="' + names[0] + '" src="' + images[0] + '" class="set"><br>' + names[0] + '</figure>';
            } else {
                win = '<figure class="opensans win ' + qualities[0] + '" id="fig' + index + '"><img align="middle" alt="' + names[0] + '" src="' + images[0] + '" class="set"><br>' + names[0] + '</figure>';
            }
        } else {
            win = '---';
        }

        $('#content').prepend('<div class="wrap"><div id="place' + round + '" class="turn' + ((round > 3) ? ' places' : '') + '"><div class="ranking">' + ((Dargmuesli.Language.i18next.language == 'en') ? ordinal_suffix_of(round) : round + '.') + ' ' + t('functions:extension.draw.place.ranking') + ': </div><div class="place">' + win + '</div><p>' + t('functions:extension.draw.place.span') + ': <span id="round' + round + '" class="opensans"></span></p></div></div>');

        (function () {
            let roundCopy = round;
            setTimeout(function () {
                document.getElementById('place' + roundCopy).style.transform = 'rotateY(0deg)';
            }, 100);
        }());

        if (prices) {
            let xhr = new XMLHttpRequest();

            xhr.open('GET', document.head.querySelector('[name~=HTTP_X_FORWARDED_PREFIX][content]').content + '/resources/dargmuesli/cost.php?item=' + priceNames[0] + '&origin=place' + round + '-fig1', true);
            xhr.onreadystatechange = function () {
                if (xhr.readyState == 4) {
                    let responseArray = xhr.responseText.split('-');
                    let origin = $('#' + responseArray[0]).find('#' + responseArray[1]);

                    origin.find('>:first-child').css('background', 'rgba(0, 0, 0, 0.5) none repeat scroll 0% 0%');
                    setTimeout(function () { addPrices(origin, responseArray[2]); }, 1000);
                }
            };
            xhr.send();
        }

        if (imageStartIndices.length > 1) {
            index = 1;
            setTimeout(function () { addRest(imageStartIndices.length, qualities, names, images, priceNames); }, 250);
        }

        document.getElementById('loading').style.display = 'none';
        $('#round' + round).airport([winners[round]]);
        content.insertBefore(document.getElementById('loading'), content.firstChild);
        again.style.display = 'inline-block';
        again.style.opacity = '0';

        round--;

        if (round == 0) {
            let button = document.createElement('button');
            button.setAttribute('class', 'link');
            button.setAttribute('title', 'Draw again');
            button.setAttribute('id', 'reload');
            button.innerHTML = t('functions:extension.draw.button');
            reveal.parentNode.replaceChild(button, reveal); //Reveal durch Reload ersetzen

            document.getElementById('reload').addEventListener('click', function () { location.reload(); });
        } else {
            reveal.innerHTML = t('functions:extension.draw.reveal', round);
        }
    });
}

function addRest(length, qualities, names, images, priceNames) {
    let earlyPlace = $('.place:eq(0)');
    let origin = earlyPlace.parent().attr('id') + '-fig' + (index + 1);

    if (prices) {
        earlyPlace.append('<figure class="opensans win ' + qualities[index] + '" id="fig' + (index + 1) + '"><div class="price"></div><img align="middle" alt="' + names[index] + '" src="' + images[index] + '" class="set"><br>' + names[index] + '</figure>');

        let xhr = new XMLHttpRequest();

        xhr.open('GET', document.head.querySelector('[name~=HTTP_X_FORWARDED_PREFIX][content]').content + '/resources/dargmuesli/cost.php?item=' + priceNames[index] + '&origin=' + origin, true);
        xhr.onreadystatechange = function () {
            if (xhr.readyState == 4) {
                let responseArray = xhr.responseText.split('-');
                let origin = $('#' + responseArray[0]).find('#' + responseArray[1]);

                origin.find('>:first-child').css('background', 'rgba(0, 0, 0, 0.5) none repeat scroll 0% 0%');
                setTimeout(function () { addPrices(origin, responseArray[2]); }, 1000);
            }
        };
        xhr.send();
    } else {
        earlyPlace.append('<figure class="opensans win ' + qualities[index] + '" id="fig' + (index + 1) + '"><img align="middle" alt="' + names[index] + '" src="' + images[index] + '" class="set"><br>' + names[index] + '</figure>');
    }

    index++;

    if (index < length) {
        setTimeout(function () { addRest(length, qualities, names, images, priceNames); }, 250);
    }
}

function addPrices(element, price) {
    element.append('<div class="price-outer"><img class="price-img" src="/resources/dargmuesli/icons/price.png"><div class="price-inner">' + price + '</div></div>');
}

function getAllIndexes(arr, val) {
    let indices = [];
    let i = -1;

    while ((i = arr.indexOf(val, i + 1)) != -1) {
        indices.push(i);
    }
    return indices;
}

document.addEventListener('DOMContentLoaded', function () {
    documentLoaded = true;

    getRandom();

    document.getElementById('letsgo').addEventListener('click', function () { draw(); });
    document.getElementById('reveal').addEventListener('click', function () { draw(); });
});

function getRandom() {
    if (!documentLoaded || !extensionXhrReturned) {
        return;
    }

    let xhr = new XMLHttpRequest();

    xhr.open('GET', document.head.querySelector('[name~=HTTP_X_FORWARDED_PREFIX][content]').content + '/resources/dargmuesli/random.php?n=' + round, true);
    xhr.onreadystatechange = function () {
        if (xhr.readyState == 4) {
            Dargmuesli.Language.i18n.then(function (t) {
                let json = JSON.parse(xhr.responseText);
                let loading = document.getElementById('loading');
                let go = document.getElementById('go');

                for (let r = 0; r < round; r++) {
                    let totalTickets = 0;

                    for (let p = 0; p < participants.length; p++) {
                        totalTickets += parseInt(participants[p]['column1']);
                    }

                    let randomNumber;

                    if (json.hasOwnProperty('error') || json.hasOwnProperty('code')) {
                        randomNumber = Math.random();
                    } else {
                        randomNumber = json.result.random.data[r];
                        let bitsLeftPercentage = json.result.bitsLeft * 100 / 250000;
                        let requestsLeftPercentage = json.result.requestsLeft * 100 / 1000;

                        document.getElementById('percentageleft').innerHTML = (100 - ((bitsLeftPercentage < requestsLeftPercentage) ? bitsLeftPercentage : requestsLeftPercentage)).toFixed(1) + t('functions:extension.draw.limit');
                    }

                    let q = 0;
                    let i = 0;

                    while (q < 1) {
                        let probability = parseInt(participants[i]['column1']) / totalTickets;

                        q += probability;

                        if (q >= randomNumber) {
                            winners[r + 1] = participants[i]['column0'];
                            participants.splice(participants.indexOf(participants[i]), 1);
                            break;
                        }

                        i++;
                    }
                }

                loading.className = 'hide';
                go.className = '';
                go.style.display = 'inline-block';
            });
        }
    };
    xhr.send();
}

function ordinal_suffix_of(i) {
    let j = i % 10,
        k = i % 100;
    if (j == 1 && k != 11) {
        return i + 'st';
    }
    if (j == 2 && k != 12) {
        return i + 'nd';
    }
    if (j == 3 && k != 13) {
        return i + 'rd';
    }
    return i + 'th';
}
