// Make links clickable
document.addEventListener('DOMContentLoaded', function () {
    let spoiler = document.getElementById('spoiler');

    if (spoiler != null) {
        spoiler.addEventListener('click', () => { Dargmuesli.Spoiler.showSpoiler();});
    }

    let add = document.getElementById('add');

    if (add != null) {
        add.addEventListener('click', async () => await Dargmuesli.Table.sendRow(2, [0], 'participants'));
    }

    let resetElement = document.getElementById('reset');

    if (resetElement != null) {
        resetElement.addEventListener('click', async () => await Dargmuesli.Table.reset(2, 'participants'));
    }

    let csvClick = document.getElementById('csvClick');

    if (csvClick != null) {
        csvClick.addEventListener('click', () => { document.getElementById('csv-file').click();});
    }

    let i = 1;
    let tr = document.getElementById('tr' + i);

    while (tr != null) {
        for (let j = 0; j < tr.childNodes.length; j++) {
            let child = tr.childNodes[j];

            if (child != null && child.nodeType != 3) {
                (function () {
                    let iCopy = i;

                    if (child.className == 'remove') {
                        Dargmuesli.Table.getChildNode(child, 0).addEventListener('click', async () => await Dargmuesli.Table.removeRow(iCopy, 2, 'participants'));
                    } else if (child.className == 'up' && child.childNodes[1] != null) {
                        Dargmuesli.Table.getChildNode(child, 0).addEventListener('click', () => { Dargmuesli.Table.moveRowUp(iCopy, 2, 'participants');});
                    } else if (child.className == 'down' && child.childNodes[1] != null) {
                        Dargmuesli.Table.getChildNode(child, 0).addEventListener('click', () => { Dargmuesli.Table.moveRowDown(iCopy, 2, 'participants');});
                    }
                }());
            }
        }

        i++;
        tr = document.getElementById('tr' + i);
    }
});
