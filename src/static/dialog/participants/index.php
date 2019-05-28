<?php
    include_once $_SERVER['DOCUMENT_ROOT'].'/resources/dargmuesli/base/skeleton.php';
    include_once $_SERVER['DOCUMENT_ROOT'].'/resources/dargmuesli/translation/translations.php';

    include_once $_SERVER['DOCUMENT_ROOT'].'/resources/dargmuesli/account.php';
    include_once $_SERVER['DOCUMENT_ROOT'].'/resources/dargmuesli/sessioncookie.php';
    include_once $_SERVER['DOCUMENT_ROOT'].'/resources/dargmuesli/warning.php';

    include_once $_SERVER['DOCUMENT_ROOT'].'/resources/dargmuesli/tableload.php';

    if (isset($_COOKIE['view'])) {
        $view = $_COOKIE['view'];
    } elseif (isset($_SESSION['view'])) {
        $view = $_SESSION['view'];
    } else {
        $view = 'Instructions';
        $_SESSION['view'] = $view;
    }

    $skeletonTitle = translate('pages.participants.title.head');
    $skeletonDescription = 'Enter all participants\' names and their chance of winning';
    $skeletonFeatures = ['lcl/ext/css', 'lcl/ext/js'];
    $skeletonKeywords = 'participants, chance, random, win, picker';
    $skeletonContent = '
        <header>'.get_warning_html($success, $error).'
            <div id="back">
                <a class="rotate" href="'.getenv('BASE_URL').'/" title="Back"></a>
            </div>
            <div id="account">
                '.get_account_html($email).'
            </div>
        </header>
        <main>
            <h1>
                '.translate('pages.participants.title.head').'
            </h1>';

    if ($view == 'Instructions') {
        $skeletonContent .= '
            <section class="double">
                <h2>
                    '.translate('pages.participants.data.title').'
                </h2>
                <p>
                    '.translate('pages.participants.data.content').'
                </p>
            </section>
            <section class="double">
                <h2>
                    '.translate('pages.participants.csv.title').'
                </h2>
                <p>
                    '.translate('pages.participants.csv.content').'
                </p>
                <p>
                    <button class="link" title="'.translate('pages.participants.csv.button').'" id="spoiler">
                        <span id="link">
                            &#x25B8;
                        </span>
                        '.translate('pages.participants.csv.button').'
                    </button>
                </p>
                <p class="spoiler" title="username;quantity&#10;Dargmuesli;1&#10;Megaquest;3&#10;...">
                    '.translate('pages.participants.csv.spoiler').'
                </p>
            </section>';
    }

    $skeletonContent .= '
    <div class="alone">
        <table class="box">
            <tbody id="tbody">
                <tr>
                    <th>
                        '.translate('pages.participants.table.username').'
                    </th>
                    <th>
                        '.translate('pages.participants.table.quantity').'
                    </th>
                    <th>
                        '.translate('pages.participants.table.remove').'
                    </th>
                    <th>
                        '.translate('pages.participants.table.up').'
                    </th>
                    <th>
                        '.translate('pages.participants.table.down').'
                    </th>
                </tr>';

    if (isset($email) && isset($_COOKIE['participants']) && ($_COOKIE['participants'] != '')) {
        $skeletonContent .= get_init_table_html(json_decode($_COOKIE['participants'], true), 'participants');
    } elseif (isset($_SESSION['participants']) && ($_SESSION['participants'] != '')) {
        $skeletonContent .= get_init_table_html($_SESSION['participants'], 'participants');
    } else {
        $skeletonContent .= get_init_table_html(null, 'participants');
    }

    $skeletonContent .= '
            </tbody>
        </table>';

    if ($view != 'Data') {
        $skeletonContent .= '
            <p>
                <input id="tableInput0" name="username" placeholder="Benutzername" required title="'.translate('pages.participants.form.username').'" type="text">
                <input id="tableInput1" min="1" name="quantity" placeholder="Quantität" required title="'.translate('pages.participants.form.quantity').'" type="number" value="1">
            </p>
            <p>
                <button type="button" id="add" name="add" value="add">
                    '.translate('pages.participants.form.add').'
                </button>
                <button type="button" id="reset" name="reset" value="reset">
                    '.translate('pages.participants.form.reset').'
                </button>
            </p>
            <p>
                <button disabled id="csv-click">
                    '.translate('pages.participants.form.upload').'
                </button>
                <input type="file" accept=".csv" id="csv-file" name="files" class="hide" />
            </p>';
    }

    $skeletonContent .= '
                <p>
                    <a href="../items/" title="Items">
                        <img src="'.getenv('BASE_URL').'/resources/dargmuesli/icons/arrow.png" alt="Items" class="next">
                    </a>
                </p>
            </div>
        </main>'.get_footer();

    output_html($skeletonTitle, $skeletonDescription, $skeletonContent, $skeletonFeatures, $skeletonKeywords);
