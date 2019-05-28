import i18next from 'i18next';
import { getFirstChild, getLastChild, saveTableCreate, selectItem } from './table';
import { i18n } from './language';

$(document).ready(function () {
    $('.filetree').fileTree({
        root: '/',
        script: document.head.querySelector('[name~=HTTP_X_FORWARDED_PREFIX][content]').content + '/resources/dargmuesli/packages/yarn/jqueryfiletree/connectors/jqueryFileTree.php',
        multiFolder: false
    }, async (file) => await openFile(file));
});

export async function openFile(file) {
    await i18n;

    let nameparts = file;
    nameparts = nameparts.split('/');
    nameparts = nameparts.splice(3, 2);
    let name = nameparts[0] + ', ' + nameparts[1];

    return new Promise(function (resolve, reject) {
        let xhr = new XMLHttpRequest();
        xhr.open('GET', document.head.querySelector('[name~=HTTP_X_FORWARDED_PREFIX][content]').content + '/dialog/items/layout/data/filetree/categories/' + i18next.language + file, true); // + '?' + new Date().getTime()
        xhr.onreadystatechange = async () => {
            if (xhr.readyState !== 4) return;
            if (xhr.status >= 200 && xhr.status < 300) {
                let json = JSON.parse(xhr.responseText);

                if ((json != false) && ((json.name != '') || (json.url != ''))) {
                    let selected = document.getElementById('selected');
                    let btn = selected.parentNode;
                    let td = btn.parentNode;

                    if (getFirstChild(getLastChild(td)).id != 'selected') {
                        await Dargmuesli.Table.selectItem(parseInt(/sI\((.+)\)/.exec(getLastChild(td).id)[1]));
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
                        document.getElementById('sI(' + iCopy + ')').addEventListener('click', async () => await selectItem(iCopy));
                    }());

                    let condition = document.getElementById('condition');

                    condition.disabled = false;
                    condition.selectedIndex = 0;

                    let type = document.getElementById('chkType');

                    if (json.type == 'StatTrak') {
                        document.getElementById('hType').style.display = 'block';
                        type.parentNode.style.display = 'initial';
                        type.parentNode.innerHTML = '<input type="checkbox" name="type" value="StatTrak&trade;" id="chkType"> StatTrak&trade;';
                        type.addEventListener('click', () => { assignStatTrak();});
                    } else if (json.type == 'Souvenir') {
                        document.getElementById('hType').style.display = 'block';
                        type.parentNode.style.display = 'initial';
                        type.parentNode.innerHTML = '<input type="checkbox" name="type" value="Souvenir" id="chkType"> Souvenir';
                        type.addEventListener('click', () => { assignSouvenir();});
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
                            elClone.addEventListener('click', async () => await selectItem(iCopy));
                        }());
                    }

                    document.getElementById('tableInput1').value = '<button class="link" title="Win" id="sI(' + i + ')">';

                    saveTableCreate(2, 'items', document.getElementById('categories').parentNode);
                }

                resolve();
            } else {
                reject({
                    status: xhr.status,
                    statusText: xhr.statusText
                });
            }
        };
        xhr.send();
    });
}

export async function assignCondition() {
    let t = await i18n;
    let condition = document.getElementById('condition');
    let selected = document.getElementById('selected');
    let span = selected.getElementsByTagName('span')[0];

    if (condition.options[0].selected) {
        span.innerHTML = '';
    } else if (condition.options[1].selected) {
        span.innerHTML = t('functions:filetree.conditions.fn');
    } else if (condition.options[2].selected) {
        span.innerHTML = t('functions:filetree.conditions.mw');
    } else if (condition.options[3].selected) {
        span.innerHTML = t('functions:filetree.conditions.ft');
    } else if (condition.options[4].selected) {
        span.innerHTML = t('functions:filetree.conditions.ww');
    } else if (condition.options[5].selected) {
        span.innerHTML = t('functions:filetree.conditions.bs');
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

export async function hideImages() {
    let t = await i18n;
    let data = document.getElementsByClassName('data');
    let link = document.getElementById('hideimages');
    let i, j;

    if (link.classList.contains('shown')) {
        for (i = 0; i < document.querySelectorAll('.data').length; i++) {
            for (j = 0; j < data[i].querySelectorAll('.set').length; j++) {
                data[i].getElementsByTagName('img')[j].style.display = 'none';
            }
        }

        link.innerHTML = t('functions:filetree.images.show');
        link.classList.add('hidden');
        link.classList.remove('shown');
    } else {
        for (i = 0; i < document.querySelectorAll('.data').length; i++) {
            for (j = 0; j < data[i].querySelectorAll('.set').length; j++) {
                data[i].getElementsByTagName('img')[j].style.display = 'inline';
            }
        }

        link.innerHTML = t('functions:filetree.images.hide');
        link.classList.add('shown');
        link.classList.remove('hidden');
    }

    saveTableCreate(2, 'items', document.getElementById('categories').parentNode);
}
