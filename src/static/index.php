<?php
    include_once $_SERVER['DOCUMENT_ROOT'].'/resources/dargmuesli/cache/enabled.php';
    include_once $_SERVER['DOCUMENT_ROOT'].'/resources/dargmuesli/base/skeleton.php';
    include_once $_SERVER['DOCUMENT_ROOT'].'/resources/dargmuesli/translation/translations.php';

    include_once $_SERVER['DOCUMENT_ROOT'].'/resources/dargmuesli/account.php';
    include_once $_SERVER['DOCUMENT_ROOT'].'/resources/dargmuesli/sessioncookie.php';
    include_once $_SERVER['DOCUMENT_ROOT'].'/resources/dargmuesli/warning.php';

    last_modified(get_page_mod_time());

    $skeletonTitle = translate('pages.start.title.head');
    $skeletonDescription = 'Choose a random winner for case openings or similar raffles';
    $skeletonFeatures = ['lcl/ext/css'];
    $skeletonKeywords = 'website, true, random, winner, choose, best, randomwinpicker, raffle, winning, user';
    $skeletonContent = '
        <div id="group1" class="parallax__group">
            <div class="parallax__layer parallax__layer--base" id="hubble">
            </div>
            <div class="parallax__layer parallax__layer--fore">
                <header>'.get_warning_html($success, $error).'
                    <div id="account">
                        '.get_account_html($email).'
                    </div>
                </header>
                <div class="greez">
                    <h1>
                        '.translate('pages.start.title.body').'
                    </h1>
                </div>
                <div id="top">
                    <a href="dialog/participants.php" title="Start">
                        <img src="/resources/dargmuesli/icons/arrow.png" alt="Participants" class="next">
                    </a>
                    <p class="hint">
                        '.translate('pages.start.hint').'
                    </p>
                </div>
            </div>
        </div>
        <div id="group2" class="parallax__group">
            <div class="parallax__layer parallax__layer--back" id="stars">
            </div>
            <div class="parallax__layer parallax__layer--base">
                <div class="content">
                    <main>
                        <section>
                            <h2>
                                '.translate('pages.start.about.title').'
                            </h2>
                            <p>
                                '.translate('pages.start.about.content').'
                            </p>
                        </section>
                        <section>
                            <h2>
                                '.translate('pages.start.randomness.title').'
                            </h2>
                            <p>
                                '.translate('pages.start.randomness.content').'
                            </p>
                        </section>
                        <section>
                            <h2>
                                '.translate('pages.start.overview.title').'
                            </h2>
                            <p>
                                '.translate('pages.start.overview.content.prefix').'
                                <br>
                            </p>
                            <ol>
                                <li>
                                    '.translate('pages.start.overview.content.table.li1').'
                                </li>
                                <li>
                                    '.translate('pages.start.overview.content.table.li2').'
                                </li>
                            </ol>
                            <p>
                                '.translate('pages.start.overview.content.suffix').'
                            </p>
                        </section>
                        <a href="dialog/participants.php" title="Start">
                            <img src="/resources/dargmuesli/icons/arrow.png" alt="Participants" class="next"/>
                        </a>
                    </main>
                    <footer>
                        <p id="language">';

    switch (get_language()) {
        case 'de':
            $skeletonContent .= '
                <button class="link en" id="lang" title="Switch to English">
                    <img src="/resources/dargmuesli/icons/en.png" alt="English Flag" id="flag">';
            break;
        default:
            $skeletonContent .= '
                <button class="link de" id="lang" title="Switch to German">
                    <img src="/resources/dargmuesli/icons/de.png" alt="German Flag" id="flag">';
    }

    $skeletonContent .= '
                            </button>
                        </p>
                        <p class="seethrough">
                            -
                            <a href="imprint" title="Imprint">
                                '.translate('pages.general.footer.imprint').'
                            </a>
                            |
                            <button id="bug" class="link" title="Report a bug">
                                '.translate('pages.general.footer.bug-report').'
                            </button>
                            -
                        </p>
                    </footer>
                </div>
            </div>
        </div>';

    output_html($skeletonTitle, $skeletonDescription, $skeletonContent, $skeletonFeatures, $skeletonKeywords);
