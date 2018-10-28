import { alert } from './alert';
import { getFirstChild, getLastChild, saveTableCreate, selectItem } from './table';
import { i18n } from './language';

$(document).ready(function () {
    $('.filetree').fileTree({ root: '/', script: document.head.querySelector('[name~=HTTP_X_FORWARDED_PREFIX][content]').content + '/resources/dargmuesli/packages/yarn/jqueryfiletree/connectors/jqueryFileTree.php', multiFolder: false, expanded: '/CS:GO/' }, function (file) {
        openFile(file);
    });
});

export function openFile(file) {
    let nameparts = file;
    nameparts = nameparts.split('/');
    nameparts = nameparts.splice(3, 2);
    let name = nameparts[0] + ', ' + nameparts[1];

    let xhr = new XMLHttpRequest();

    xhr.open('GET', document.head.querySelector('[name~=HTTP_X_FORWARDED_PREFIX][content]').content + '/dialog/items/layout/data/filetree/categories/' + i18n.language + file + '?' + new Date().getTime(), true);
    xhr.onreadystatechange = function () {
        if ((xhr.readyState == 4) && (xhr.status == 200)) {
            let json = JSON.parse(xhr.responseText);

            if ((json != false) && ((json.name != '') || (json.url != ''))) {
                let selected = document.getElementById('selected');
                let btn = selected.parentNode;
                let td = btn.parentNode;
                let type = document.getElementById('chkType');

                if (getFirstChild(getLastChild(td)).id != 'selected') {
                    td.lastChild.click();
                    selected = document.getElementById('selected');
                    btn = selected.parentNode;
                    td = btn.parentNode;
                }

                let index = parseInt(btn.id.replace('sI(', '').replace(')', '')) + 1;

                if (selected.innerHTML.indexOf('---') != -1) {
                    td.removeChild(selected.parentNode);
                    index--;
                } else {
                    selected.removeAttribute('id');
                }

                let quality = '';

                if (json.quality == 'Consumer Grade') {
                    quality = ' consumergrade';
                } else if (json.quality == 'Industrial Grade') {
                    quality = ' industrialgrade';
                } else if (json.quality == 'Mil-Spec') {
                    quality = ' mil-spec';
                } else if (json.quality == 'Restricted') {
                    quality = ' restricted';
                } else if (json.quality == 'Classified') {
                    quality = ' classified';
                } else if (json.quality == 'Covert') {
                    quality = ' covert';
                }

                let newElement = '<figure class="item' + quality;

                if (document.getElementById('hideimages').classList.contains('hidden')) {
                    newElement += ' hide';
                }

                newElement += '" id="selected"><img src="' + json.url + '" alt="' + name + '" class="set ' + file + '"><figcaption>' + name + '<br><span></span><span class="' + json.type + '"></span></figcaption></figure>';

                let button = document.createElement('button');
                button.setAttribute('class', 'link');
                button.setAttribute('title', 'Win');
                button.setAttribute('id', 'sI(' + index + ')');
                button.innerHTML = newElement;
                td.appendChild(button);

                (function () {
                    let iCopy = index;
                    document.getElementById('sI(' + iCopy + ')').addEventListener('click', function () { selectItem(iCopy); });
                }());

                let condition = document.getElementById('condition');

                condition.disabled = false;
                condition.selectedIndex = 0;

                if (json.type == 'StatTrak') {
                    document.getElementById('hType').style.display = 'block';
                    type.parentNode.style.display = 'initial';
                    type.parentNode.innerHTML = '<input type="checkbox" name="type" value="StatTrak&trade;" id="chkType"> StatTrak&trade;';
                    document.getElementById('chkType').addEventListener('click', function () { assignStatTrak(); });
                    type = document.getElementById('chkType');
                } else if (json.type == 'Souvenir') {
                    document.getElementById('hType').style.display = 'block';
                    type.parentNode.style.display = 'initial';
                    type.parentNode.innerHTML = '<input type="checkbox" name="type" value="Souvenir" id="chkType"> Souvenir';
                    document.getElementById('chkType').addEventListener('click', function () { assignSouvenir(); });
                    type = document.getElementById('chkType');
                } else {
                    type.parentNode.style.display = 'none';
                    document.getElementById('hType').style.display = 'none';
                }

                let i;

                for (i = (index + 1); i < document.querySelectorAll('.item').length; i++) {
                    (function () {
                        let el = document.getElementsByClassName('item')[i].parentNode, elClone = el.cloneNode(true);
                        let iCopy = i;

                        el.parentNode.replaceChild(elClone, el);
                        elClone.id = 'sI(' + iCopy + ')';
                        elClone.addEventListener('click', function () { selectItem(iCopy); });
                    }());
                }

                document.getElementById('tableInput1').value = '<button class="link" title="Win" id="sI(' + i + ')">';

                saveTableCreate(2, 'items', document.getElementById('categories').parentNode);
            } else {
                alert.render(i18n.t('functions:filetree.contribute.title'), i18n.t('functions:filetree.contribute.question'), file, 'contribute');
            }
        }
    };
    xhr.send();
}

// export function tryGetJson(str) {
//     try {
//         let json = JSON.parse(str);

//         if (json && typeof json === 'object' && json !== null) {
//             return json;
//         }
//     } catch (e) {
//         console.log('Cannot parse JSON from "' + str + '"!');
//     }

//     return false;
// }

export function assignCondition() {
    let condition = document.getElementById('condition');
    let selected = document.getElementById('selected');
    let span = selected.getElementsByTagName('span')[0];

    if (condition.options[0].selected) {
        span.innerHTML = '';
    } else if (condition.options[1].selected) {
        span.innerHTML = i18n.t('functions:filetree.conditions.fn');
    } else if (condition.options[2].selected) {
        span.innerHTML = i18n.t('functions:filetree.conditions.mw');
    } else if (condition.options[3].selected) {
        span.innerHTML = i18n.t('functions:filetree.conditions.ft');
    } else if (condition.options[4].selected) {
        span.innerHTML = i18n.t('functions:filetree.conditions.ww');
    } else if (condition.options[5].selected) {
        span.innerHTML = i18n.t('functions:filetree.conditions.bs');
    }

    saveTableCreate(2, 'items', document.getElementById('categories').parentNode);
}

export function assignStatTrak() {
    let type = document.getElementById('chkType');
    let selected = document.getElementById('selected');
    let span = selected.getElementsByTagName('span')[1];

    if (type.checked) {
        span.innerHTML = '[ST]';
    } else {
        span.innerHTML = '';
    }

    saveTableCreate(2, 'items', document.getElementById('categories').parentNode);
}

export function assignSouvenir() {
    let type = document.getElementById('chkType');
    let selected = document.getElementById('selected');
    let span = selected.getElementsByTagName('span')[1];

    if (type.checked) {
        span.innerHTML = '[SV]';
    } else {
        span.innerHTML = '';
    }

    saveTableCreate(2, 'items', document.getElementById('categories').parentNode);
}

export function hideImages() {
    let data = document.getElementsByClassName('data');
    let link = document.getElementById('hideimages');
    let i, j;

    if (link.classList.contains('shown')) {
        for (i = 0; i < document.querySelectorAll('.data').length; i++) {
            for (j = 0; j < data[i].querySelectorAll('.set').length; j++) {
                data[i].getElementsByTagName('img')[j].style.display = 'none';
            }
        }

        link.innerHTML = i18n.t('functions:filetree.images.show');
        link.classList.add('hidden');
        link.classList.remove('shown');
    } else {
        for (i = 0; i < document.querySelectorAll('.data').length; i++) {
            for (j = 0; j < data[i].querySelectorAll('.set').length; j++) {
                data[i].getElementsByTagName('img')[j].style.display = 'inline';
            }
        }

        link.innerHTML = i18n.t('functions:filetree.images.hide');
        link.classList.add('shown');
        link.classList.remove('hidden');
    }

    saveTableCreate(2, 'items', document.getElementById('categories').parentNode);
}
