<?php
    include_once $_SERVER['DOCUMENT_ROOT'].'/resources/dargmuesli/cache/enabled.php';
    include_once $_SERVER['DOCUMENT_ROOT'].'/resources/dargmuesli/base/skeleton.php';
    include_once $_SERVER['DOCUMENT_ROOT'].'/resources/dargmuesli/translation/translations.php';

    include_once $_SERVER['DOCUMENT_ROOT'].'/resources/dargmuesli/account.php';
    include_once $_SERVER['DOCUMENT_ROOT'].'/resources/dargmuesli/sessioncookie.php';
    include_once $_SERVER['DOCUMENT_ROOT'].'/resources/dargmuesli/warning.php';

    include_once $_SERVER['DOCUMENT_ROOT'].'/resources/dargmuesli/tableload.php';

    last_modified(get_page_mod_time());

    if (isset($_COOKIE['view'])) {
        $view = $_COOKIE['view'];
    } elseif (isset($_SESSION['view'])) {
        $view = $_SESSION['view'];
    } else {
        $view = 'Instructions';
        $_SESSION['view'] = $view;
    }

    $skeletonTitle = translate('pages.items.title.head');
    $skeletonDescription = 'Specify all items that can be won by all participants';
    $skeletonFeatures = ['lcl/ext/css', 'lcl/ext/js', 'pkg/jqft/mcss'];
    $skeletonKeywords = 'participants, chance, random, win, picker';
    $skeletonContent = '
        <header>'.get_warning_html($success, $error).'
            <div id="back">
                <a class="rotate" href="/dialog/participants/" title="Back"></a>
            </div>
            <div id="account">
                '.get_account_html($email).'
            </div>
        </header>
        <main>
            <h1>
                '.translate('pages.items.title.head').'
            </h1>
            <section class="double';

    if ($view == 'Data') {
        $skeletonContent .= ' dataview';
    }

    $skeletonContent .= '">';

    if ($view == 'Instructions') {
        $skeletonContent .= '
            <h2>
                '.translate('pages.items.instructions.categories.title').'
            </h2>
            <p>
                '.translate('pages.items.instructions.categories.configure').'
            </p>
            <p>
                '.translate('pages.items.instructions.categories.items').'
            </p>';
    }

    $skeletonContent .= '
        <div class="center">
            <table class="box">
                <tbody id="categories">
                    <tr>
                        <th>
                            '.translate('pages.items.table.class').'
                        </th>
                        <th>
                            '.translate('pages.items.table.win').'
                        </th>
                        <th>
                            '.translate('pages.items.table.remove').'
                        </th>
                        <th>
                            '.translate('pages.items.table.up').'
                        </th>
                        <th>
                            '.translate('pages.items.table.down').'
                        </th>
                    </tr>';

    if (isset($email) && isset($_COOKIE['items']) && ($_COOKIE['items'] != '')) {
        $content = json_decode($_COOKIE['items'], true);
    } elseif (isset($_SESSION['items']) && ($_SESSION['items'] != '')) {
        $content = $_SESSION['items'];
    } else {
        $content = [0 => ['column0' => '1', 'column1' => '<button class="link" title="Win" id="sI(0)"><figure class="item" id="selected"><img>---<br><figcaption><span></span><span></span></figcaption></figure></button>', 'column1classes' => 'data']]; //id="iniTable"
    }

    $skeletonContent .= get_init_table_html($content, 'items').'
            </tbody>
        </table>
        <p class="invisible">
            <input disabled id="tableInput0" name="tableInput0" title="tableInput0" type="number" value="2" class="absolute" min="1">
            <input disabled id="tableInput1" name="tableInput1" title="tableInput1" type="text" value="">
        </p>';

    if ($view != 'Data') {
        $skeletonContent .= '
            <p>
                <button type="button" id="add" name="add" value="add">
                    '.translate('pages.items.form.add').'
                </button>
                <button type="button" id="reset" name="reset" value="reset">
                    '.translate('pages.items.form.reset').'
                </button>
            </p>';
    }

    $skeletonContent .= '
            </div>
        </section>';

    if ($view != 'Data') {
        $skeletonContent .= '
            <section class="double" id="items-right">';

        if ($view == 'Instructions') {
            $skeletonContent .= '
                <h2 id="assignItems">
                        '.translate('pages.items.instructions.items.title').'
                    </h2>
                    <p>
                        '.translate('pages.items.instructions.items.class').'
                    </p>
                    <p>
                        '.translate('pages.items.instructions.items.select').'
                    </p>';
        }

        $skeletonContent .= '
            <section class="double sidebar" id="items-right-left">
                <h3>
                    '.translate('pages.items.condition.title').'
                </h3>
                <p>
                    <select id="condition" disabled>
                        <option>
                            ---
                        </option>
                        <option>
                            '.translate('pages.items.condition.fn').'
                        </option>
                        <option>
                            '.translate('pages.items.condition.mw').'
                        </option>
                        <option>
                            '.translate('pages.items.condition.ft').'
                        </option>
                        <option>
                            '.translate('pages.items.condition.ww').'
                        </option>
                        <option>
                            '.translate('pages.items.condition.bs').'
                        </option>
                    </select>
                </p>
                <h3 id="hType">
                    '.translate('pages.items.type.title').'
                </h3>
                <p>
                    <label for="chkType">
                        <input type="checkbox" name="type" value="StatTrack&trade;" id="chkType"> StatTrack&trade;
                    </label>
                </p>
                <h3>
                    '.translate('pages.items.improvements.title').'
                </h3>
                <p>
                    <button class="link" title="Suggest new items" id="box">
                        '.translate('pages.items.improvements.button').'
                    </button>
                </p>
                <h3>
                    '.translate('pages.items.tools.title').'
                </h3>
                <p>
                    <button class="link shown" title="Hide all images" id="hideimages">
                        '.translate('pages.items.tools.hide').'
                    </button>
                </p>';

        if (isset($email)) {
            $skeletonContent .= '
                <p>
                    <button class="link" title="Import Session" id="importSession">
                        '.translate('pages.items.tools.import').'
                    </button>
                </p>';
        }

        $skeletonContent .= '
            </section>
                <section class="double sidebar" id="items-left-left">
                    <h3>
                        '.translate('pages.items.items.title').'
                    </h3>
                    <p class="filetree box">
                    </p>
                </section>
            </section>';
    }

    $skeletonContent .= '
            <div class="alone">
                <button class="link" title="Draw" id="testGo">
                    <img src="/resources/dargmuesli/icons/arrow.png" alt="Draw" class="next"/>
                </button>
            </div>
        </main>'.get_footer();

    output_html($skeletonTitle, $skeletonDescription, $skeletonContent, $skeletonFeatures, $skeletonKeywords);
