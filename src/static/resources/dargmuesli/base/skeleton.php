<?php
    include_once $_SERVER['DOCUMENT_ROOT'].'/resources/dargmuesli/text/markuplanguage.php';
    include_once $_SERVER['DOCUMENT_ROOT'].'/resources/dargmuesli/url/require.php';

    function output_html($title, $description, $content, $features = [], $keywords = 'random, win, picker')
    {
        global $rootPointerInteger;
        global $directoryName;

        $featureTranslation = get_feature_translation($features);
        $baseUrl = getenv('BASE_URL');

        if (isset($_GET['code'])) {
            $title = $_GET['code'];
            $titleShy = $_GET['code'];
        }

        $html = '
            <!DOCTYPE html>
            <html dir="ltr" lang="'.get_language().'">
                <head>
                    <meta charset="UTF-8">
                    <title>
                        '.$title.' - RandomWinPicker
                    </title>
                    <base href="'.$baseUrl;

        if (isset($_GET['code'])) {
            $html .= '/error/';
        }

        $html .= '">
                <link href="'.$_SERVER['REQUEST_URI'].'" rel="canonical">
                <link href="/resources/dargmuesli/icons/favicon.ico" rel="icon" type="image/x-icon">
                <meta name="author" content="Jonas Thelemann" />
                <meta name="description" content="'.$description.'" />
                <meta name="viewport" content="width=device-width, initial-scale=1.0" />
                <meta content="'.$keywords.'" name="keywords">
                <meta property="og:description" content="'.$description.'" />
                <meta property="og:image" content="https://randomwinpicker.de/layout/icons/screenshots/welcome.jpg" />
                <meta property="og:title" content="'.$title.' - RandomWinPicker" />
                <meta property="og:type" content="website" />
                <meta property="og:url" content="https://randomwinpicker.de/" />
                <script src="https://www.google.com/recaptcha/api.js?hl='.get_language().'&amp;render=explicit" async defer></script>
                '.get_feature_translation(['drg/base/stl.mcss']).'
            </head>';

        $html .= '
                <body>
                    <noscript>
                        <iframe height="0" sandbox="" src="//www.googletagmanager.com/ns.html?id=GTM-KL6875" width="0"></iframe>
                    </noscript>
                    '.$content.'
                    <div id="dialogoverlay"></div>
                    <div id="dialogbox">
                        <div>
                            <div id="dialogboxhead">
                            </div>
                            <div id="dialogboxbody">
                            </div>
                            <div id="dialogboxfoot">
                            </div>
                        </div>
                    </div>
                    '.get_feature_translation(['pkg/jq/mjs', 'pkg/jqft/mjs', 'drg/gtm/mjs', 'drg/base/func.js'])
                    .$featureTranslation.'
                </body>
            </html>';

        echo get_indented_ml($html);
    }

    function get_footer()
    {
        $footer = '
            <footer>
                <p id="language">';

        switch (get_language()) {
            case 'de':
                $footer .= '
                    <button class="link en" id="lang" title="Switch to English">
                        <img src="/resources/dargmuesli/icons/en.png" alt="English Flag" id="flag">';
                break;
            default:
                $footer .= '
                    <button class="link de" id="lang" title="Switch to German">
                        <img src="/resources/dargmuesli/icons/de.png" alt="German Flag" id="flag">';
        }

        $footer .= '
                    </button>
                </p>
                <p class="seethrough">
                    -
                    <a href="/imprint/" title="Imprint">
                        '.translate('pages.general.footer.imprint').'
                    </a>
                    |
                    <button id="bug" class="link" title="Report a bug">
                        '.translate('pages.general.footer.bug-report').'
                    </button>
                    -
                </p>
            </footer>';

        return $footer;
    }
