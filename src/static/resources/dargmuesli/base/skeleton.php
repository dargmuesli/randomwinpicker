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
            <html dir="ltr" id="space" lang="'.get_language().'">
                <head>
                    <meta charset="UTF-8">
                    <title>
                        '.$title.' - RandomWinPicker
                    </title>
                    <base href="'.$baseUrl;

        if (isset($_GET['code'])) {
            $html .= '/error/">';
        }

        $html .= '
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
                '.get_feature_translation(['drg/gtm/mjs'])
                .$featureTranslation.'
            </body>';

        $html .= '
            </html>';

        echo get_indented_ml($html);
    }
