<?php
    include_once $_SERVER['DOCUMENT_ROOT'].'/resources/dargmuesli/base/skeleton.php';
    include_once $_SERVER['DOCUMENT_ROOT'].'/resources/dargmuesli/translation/translations.php';

    $skeletonTitle = translate('pages.error.title.head').' '.$_GET['errorCode'];
    $skeletonDescription = 'Something went wrong';
    $skeletonFeatures = ['lcl/ext/css'];
    $skeletonKeywords = '';
    $skeletonContent = '
        <header>
            <a class="rotate" href="';

    if (isset($_SERVER['HTTP_REFERER']) && $_SERVER['HTTP_REFERER'] != '') {
        $skeletonContent .= $_SERVER['HTTP_REFERER'];
    } else {
        $skeletonContent .= getenv('BASE_URL').'/index.php';
    }

    $skeletonContent .= '" title="Back" id="back"></a>
        </header>
        <main>
            <div>
                <h1>
                    Error '.$_GET['errorCode'].'
                </h1>
                <p>
                    '.translate('pages.error.content').'
                </p>
            </div>
        </main>';

    output_html($skeletonTitle, $skeletonDescription, $skeletonContent, $skeletonFeatures, $skeletonKeywords);
