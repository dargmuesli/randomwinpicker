<?php
    include_once $_SERVER['DOCUMENT_ROOT'].'/resources/dargmuesli/base/skeleton.php';
    include_once $_SERVER['DOCUMENT_ROOT'].'/resources/dargmuesli/translation/translations.php';

    include_once $_SERVER['DOCUMENT_ROOT'].'/resources/dargmuesli/account.php';
    include_once $_SERVER['DOCUMENT_ROOT'].'/resources/dargmuesli/sessioncookie.php';
    include_once $_SERVER['DOCUMENT_ROOT'].'/resources/dargmuesli/warning.php';
    include_once $_SERVER['DOCUMENT_ROOT'].'/resources/dargmuesli/tableload.php';

    if ($error != null) {
        die(header('Location: ../items/'));
    }

    if (isset($email) && isset($_COOKIE['participants'])) {
        if (count($_COOKIE['participants']) == 0) {
            participants_error();
        }
    } elseif (isset($_SESSION['participants'])) {
        if (count($_SESSION['participants']) == 0) {
            participants_error();
        }
    } else {
        participants_error();
    }

    if (isset($email) && isset($_COOKIE['items'])) {
        if (count($_COOKIE['items']) == 0) {
            items_error();
        }
    } elseif (isset($_SESSION['items'])) {
        if (count($_SESSION['items']) == 0) {
            items_error();
        }
    } else {
        items_error();
    }

    function participants_error()
    {
        $_SESSION['error'] = translate('pages.draw.error.participants');
        die(header('Location: ../participants/'));
    }

    function items_error()
    {
        $_SESSION['error'] = translate('pages.draw.error.items');
        die(header('Location: ../items/'));
    }

    $skeletonTitle = translate('pages.draw.title.head');
    $skeletonDescription = 'A random winner is chosen based on your inputs';
    $skeletonFeatures = ['lcl/ext/css', 'lcl/ext/js'];
    $skeletonKeywords = 'random, winner, choose, input, animation';
    $skeletonContent = '
        <main>
            <h1>
                '.translate('pages.draw.title.head').'
            </h1>
            <p class="display_inline-block" id="go">
                <button class="link" id="letsgo" title="Go!">
                    '.translate('pages.draw.button').'
                </button>
            </p>
            <div id="fader">
                <p id="again" class="colorful">
                    <button class="link" title="Reveal the next winner" id="reveal">
                        '.translate('pages.draw.next').'
                    </button>
                </p>
            </div>
            <div>
                <p id="loading" class="hide">
                    <img src="'.getenv('BASE_URL').'/resources/dargmuesli/icons/ajax-loader.gif" alt="Loading">
                </p>
            </div>
            <div id="content" class="data">
            </div>
            <p id="percentageleft" class="seethrough">
            </p>
        </main>'.get_footer();

    output_html($skeletonTitle, $skeletonDescription, $skeletonContent, $skeletonFeatures, $skeletonKeywords);
