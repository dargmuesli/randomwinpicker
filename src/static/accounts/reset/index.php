<?php
    include_once $_SERVER['DOCUMENT_ROOT'].'/resources/dargmuesli/cache/enabled.php';
    include_once $_SERVER['DOCUMENT_ROOT'].'/resources/dargmuesli/base/skeleton.php';
    include_once $_SERVER['DOCUMENT_ROOT'].'/resources/dargmuesli/translation/translations.php';

    include_once $_SERVER['DOCUMENT_ROOT'].'/resources/dargmuesli/account.php';
    include_once $_SERVER['DOCUMENT_ROOT'].'/resources/dargmuesli/sessioncookie.php';
    include_once $_SERVER['DOCUMENT_ROOT'].'/resources/dargmuesli/warning.php';

    include_once $_SERVER['DOCUMENT_ROOT'].'/resources/dargmuesli/filesystem/environment.php';

    last_modified(get_page_mod_time());

    $skeletonTitle = translate('pages.accounts.reset.title.head');
    $skeletonDescription = 'Enter your new password here to regain access to your account';
    $skeletonFeatures = ['lcl/ext/css'];
    $skeletonKeywords = 'password, change, enter, new, regain, access, account';
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
                '.translate('pages.accounts.reset.title.head').'
            </h1>
            <p>
                '.translate('pages.accounts.reset.description').'
            </p>
            <form method="post" action="/resources/dargmuesli/recover.php?task=reset&amp;email=';

    if (isset($_GET['email']) && isset($_GET['code'])) {
        $email = $_GET['email'];
        $code = $_GET['code'];

        $skeletonContent .= $email.'&amp;code='.$code;
    } else {
        die(header('Location:/accounts/'));
    }

    $skeletonContent .= '">
                <p>
                    <input pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{6,}" required size="25" title="'.translate('pages.accounts.reset.input.password.title').'" type="password" name="password" placeholder="'.translate('pages.accounts.reset.input.password.placeholder').'" id="password">
                </p>
                <p>
                    <input type="submit" name="change" value="'.translate('pages.accounts.reset.input.change').'">
                </p>
            </form>
        </main>'.get_footer();

    output_html($skeletonTitle, $skeletonDescription, $skeletonContent, $skeletonFeatures, $skeletonKeywords);
