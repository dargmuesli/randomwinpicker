<?php
    include_once $_SERVER['DOCUMENT_ROOT'].'/resources/dargmuesli/cache/enabled.php';
    include_once $_SERVER['DOCUMENT_ROOT'].'/resources/dargmuesli/base/skeleton.php';
    include_once $_SERVER['DOCUMENT_ROOT'].'/resources/dargmuesli/translation/translations.php';

    include_once $_SERVER['DOCUMENT_ROOT'].'/resources/dargmuesli/account.php';
    include_once $_SERVER['DOCUMENT_ROOT'].'/resources/dargmuesli/sessioncookie.php';
    include_once $_SERVER['DOCUMENT_ROOT'].'/resources/dargmuesli/warning.php';

    include_once $_SERVER['DOCUMENT_ROOT'].'/resources/dargmuesli/filesystem/environment.php';

    last_modified(get_page_mod_time());

    $skeletonTitle = translate('pages.accounts.recovery.title.head');
    $skeletonDescription = 'If you lost your password you can recover it right here';
    $skeletonFeatures = ['lcl/ext/css'];
    $skeletonKeywords = 'password, recovery, lost, enter, address, reset, link, sent';
    $skeletonContent = '
        <header>'.get_warning_html($success, $error).'
            <div id="back">
                <a class="rotate" href="../" title="Back"></a>
            </div>
            <div id="account">
                '.get_account_html($email).'
            </div>
        </header>
        <main>
            <h1>
                '.translate('pages.accounts.recovery.title.head').'
            </h1>
            <p>
                '.translate('pages.accounts.recovery.description').'
            </p>
            <form method="post" action="/resources/dargmuesli/recover.php?task=recover">
                <p>
                    <input pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,3}$" required size="25" title="'.translate('pages.accounts.recovery.input.email.title').'" type="email" name="email" placeholder="'.translate('pages.accounts.recovery.input.email.placeholder').'" id="email">
                </p>
                <p>
                    <input type="submit" name="submit" value="'.translate('pages.accounts.recovery.input.send').'">
                </p>
            </form>
        </main>'.get_footer();

    output_html($skeletonTitle, $skeletonDescription, $skeletonContent, $skeletonFeatures, $skeletonKeywords);
