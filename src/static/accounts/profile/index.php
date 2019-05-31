<?php
    include_once $_SERVER['DOCUMENT_ROOT'].'/resources/dargmuesli/base/skeleton.php';
    include_once $_SERVER['DOCUMENT_ROOT'].'/resources/dargmuesli/translation/translations.php';

    include_once $_SERVER['DOCUMENT_ROOT'].'/resources/dargmuesli/account.php';
    include_once $_SERVER['DOCUMENT_ROOT'].'/resources/dargmuesli/sessioncookie.php';
    include_once $_SERVER['DOCUMENT_ROOT'].'/resources/dargmuesli/warning.php';

    include_once $_SERVER['DOCUMENT_ROOT'].'/resources/dargmuesli/filesystem/environment.php';

    // Load .env file
    load_env_file($_SERVER['SERVER_ROOT'].'/credentials');

    // Get database handle
    $dbh = get_dbh($_ENV['PGSQL_DATABASE']);

    if ($email == null || $hash == null) {
        $_SESSION['error'] = translate('pages.accounts.profile.error');

        die(header('Location:../accounts/'));
    }

    // Initialize the required table
    init_table($dbh, 'accounts');

    $stmt_privacy = $dbh->prepare('SELECT privacy FROM accounts WHERE mail = :email');
    $stmt_privacy->bindParam(':email', $email);
    $stmt_view = $dbh->prepare('SELECT view FROM accounts WHERE mail = :email');
    $stmt_view->bindParam(':email', $email);
    $stmt_storage = $dbh->prepare('SELECT storage FROM accounts WHERE mail = :email');
    $stmt_storage->bindParam(':email', $email);
    $stmt_youtube = $dbh->prepare('SELECT youtube FROM accounts WHERE mail = :email');
    $stmt_youtube->bindParam(':email', $email);
    $stmt_encoding = $dbh->prepare('SELECT encoding FROM accounts WHERE mail = :email');
    $stmt_encoding->bindParam(':email', $email);
    $stmt_prices = $dbh->prepare('SELECT prices FROM accounts WHERE mail = :email');
    $stmt_prices->bindParam(':email', $email);

    if (!$stmt_privacy->execute()) {
        throw new PDOException($stmt_privacy->errorInfo()[2]);
    }

    if (!$stmt_view->execute()) {
        throw new PDOException($stmt_view->errorInfo()[2]);
    }

    if (!$stmt_storage->execute()) {
        throw new PDOException($stmt_storage->errorInfo()[2]);
    }

    if (!$stmt_youtube->execute()) {
        throw new PDOException($stmt_youtube->errorInfo()[2]);
    }

    if (!$stmt_encoding->execute()) {
        throw new PDOException($stmt_encoding->errorInfo()[2]);
    }

    if (!$stmt_prices->execute()) {
        throw new PDOException($stmt_prices->errorInfo()[2]);
    }

    $privacy = $stmt_privacy->fetch()[0];
    $view = $stmt_view->fetch()[0];
    $storage = $stmt_storage->fetch()[0];
    $youtube = $stmt_youtube->fetch()[0];
    $encoding = $stmt_encoding->fetch()[0];
    $prices = $stmt_prices->fetch()[0];

    $skeletonTitle = translate('pages.accounts.profile.title.head');
    $skeletonDescription = 'View all settings of your personal account';
    $skeletonFeatures = ['lcl/ext/css', 'lcl/ext/js'];
    $skeletonKeywords = 'profile, settings, account, features, controls, instructions, set, display, file, encoding';
    $skeletonContent = '
        <header>'.get_warning_html($success, $error).'
            <div id="saveStatus">
                <img src="'.getenv('BASE_URL').'/resources/dargmuesli/icons/ajax-loader-arrows.gif" alt="Save Status">
            </div>
            <div id="back">
                <a class="rotate" href="../" title="Back"></a>
            </div>
            <div id="account">
                '.get_account_html($email).'
            </div>
        </header>
        <main>
            <h1>
                '.translate('pages.accounts.profile.title.head').'
            </h1>
            <div>
                <section>
                    <h2>
                        '.translate('pages.accounts.profile.information.title').'
                    </h2>
                    <p>
                        '.translate('pages.accounts.profile.information.description').': <span class="inconsolata">'.$hash.'</span>
                    </p>
                </section>
            </div>
            <div>
                <section>
                    <h2>
                        '.translate('pages.accounts.profile.settings.title').'
                    </h2>
                    <section>
                        <h3>
                            '.translate('pages.accounts.profile.settings.prices.title').'
                        </h3>
                        <p>
                            '.translate('pages.accounts.profile.settings.prices.description').'
                        </p>
                        <form id="priceForm">
                            <fieldset>
                                <input type="radio" id="sS(priceForm, true)" name="prices" value="Yes" ';
    if ($prices) {
        $skeletonContent .= 'checked';
    }

    $skeletonContent .= '><label for="sS(priceForm, true)"> '.translate('pages.accounts.profile.settings.prices.yes').'</label>
                                <br>
                                <input type="radio" id="sS(priceForm, false)" name="prices" value="No" ';

    if (!$prices) {
        $skeletonContent .= 'checked';
    }

    $skeletonContent .= '><label for="sS(priceForm, false)"> '.translate('pages.accounts.profile.settings.prices.no').'</label>
                            </fieldset>
                        </form>
                    </section>
                    <section>
                        <h3>
                            '.translate('pages.accounts.profile.settings.privacy.title').'
                        </h3>
                        <p>
                            '.translate('pages.accounts.profile.settings.privacy.description').'
                        </p>
                        <form id="privacyForm">
                            <fieldset>
                                <input type="radio" id="sS(privacyForm, E-mail address)" name="privacy" value="E-mail address" ';

    if ($privacy == 'E-mail address') {
        $skeletonContent .= 'checked';
    }

    $skeletonContent .= '><label for="sS(privacyForm, E-mail address)"> '.translate('pages.accounts.profile.settings.privacy.input.email').'</label>
                                <br>
                                <input type="radio" id="sS(privacyForm, Member)" name="privacy" value="Member" ';

    if ($privacy == 'Member') {
        $skeletonContent .= 'checked';
    }

    $skeletonContent .= '><label for="sS(privacyForm, Member)"> '.translate('pages.accounts.profile.settings.privacy.input.member').'</label>
                                <br>
                                <input type="radio" id="sS(privacyForm, Custom)" name="privacy" value="Username" ';

    if (($privacy != 'E-mail address') && ($privacy != 'Member')) {
        $skeletonContent .= 'checked';
    }

    $skeletonContent .= '><label for="sS(privacyForm, Custom);"></label>
                                <input type="text" name="privacy" id="sS(privacyForm, this.value)" size="15" maxlength="15" value="';

    if (($privacy != 'E-mail address') && ($privacy != 'Member')) {
        $skeletonContent .= $privacy;
    } else {
        $skeletonContent .= substr($email, 0, strrpos($email, '@'));
    }

    $skeletonContent .= '">
                            </fieldset>
                        </form>
                    </section>
                    <section>
                        <h3>
                            '.translate('pages.accounts.profile.settings.encoding.title').'
                        </h3>
                        <p>
                            '.translate('pages.accounts.profile.settings.encoding.description').'
                        </p>
                        <form id="encodingForm">
                            <fieldset>
                                <input type="radio" id="sS(encodingForm, UTF-8)" name="encoding" value="UTF-8" ';

    if ($encoding == 'UTF-8') {
        $skeletonContent .= 'checked';
    }

    $skeletonContent .= '><label for="sS(encodingForm, UTF-8)"> UTF-8</label>
                                <br>
                                <input type="radio" id="sS(encodingForm, ISO-8859-1)" name="encoding" value="ISO-8859-1" ';

    if ($encoding == 'ISO-8859-1') {
        $skeletonContent .= 'checked';
    }

    $skeletonContent .= '><label for="sS(encodingForm, ISO-8859-1)"> ISO-8859-1</label>
                                <br>
                                <input type="radio" id="sS(encodingForm, Custom)" name="encoding" value="etcetera" ';

    if (($encoding != 'UTF-8') && ($encoding != 'ISO-8859-1')) {
        $skeletonContent .= 'checked';
    }

    $skeletonContent .= '><label for="sS(encodingForm, Custom);"></label>
                                <input type="text" name="encoding" id="sS(encodingForm, this.value)" maxlength="15" size="15" value="';

    if (($encoding != 'UTF-8') && ($encoding != 'ISO-8859-1')) {
        $skeletonContent .= $encoding;
    }

    $skeletonContent .= '">
                            </fieldset>
                        </form>
                    </section>
                    <section>
                        <h3>
                            '.translate('pages.accounts.profile.settings.view.title').'
                        </h3>
                        <p>
                            '.translate('pages.accounts.profile.settings.view.description').'
                        </p>
                        <form id="viewForm">
                            <fieldset>
                                <input type="radio" id="sS(viewForm, Instructions)" name="view" value="Instructions" ';

    if ($view == 'Instructions') {
        $skeletonContent .= 'checked';
    }

    $skeletonContent .= '><label for="sS(viewForm, Instructions)"> '.translate('pages.accounts.profile.settings.view.input.explanations').'</label>
                                <br>
                                <input type="radio" id="sS(viewForm, Controls)" name="view" value="Controls" ';

    if ($view == 'Controls') {
        $skeletonContent .= 'checked';
    }

    $skeletonContent .= '><label for="sS(viewForm, Controls)"> '.translate('pages.accounts.profile.settings.view.input.controls').'</label>
                                <br>
                                <input type="radio" id="sS(viewForm, Data)" name="view" value="Data" ';

    if ($view == 'Data') {
        $skeletonContent .= 'checked';
    }

    $skeletonContent .= '><label for="sS(viewForm, Data)"> Daten</label>
                            </fieldset>
                        </form>
                    </section>
                    <section>
                        <h3>
                            '.translate('pages.accounts.profile.settings.storage.title').'
                        </h3>
                        <p>
                            '.translate('pages.accounts.profile.settings.storage.description').'
                        </p>
                        <form id="storageForm">
                            <fieldset>
                                <input type="radio" id="sS(storageForm, Session)" name="storage" value="Session" ';

    if ($storage == 'Session') {
        $skeletonContent .= 'checked';
    }

    $skeletonContent .= '><label for="sS(storageForm, Session)"> '.translate('pages.accounts.profile.settings.storage.input.session').'</label>
                                <br>
                                <input type="radio" id="sS(storageForm, Cookies)" name="storage" value="Cookies" ';

    if ($storage == 'Cookies') {
        $skeletonContent .= 'checked';
    }

    $skeletonContent .= '><label for="sS(storageForm, Cookies)"> Cookies [Beta]</label>
                            </fieldset>
                        </form>
                    </section>
                    <section>
                        <h3>
                            YouTube
                        </h3>
                        <p>
                            '.translate('pages.accounts.profile.settings.youtube.description').'
                        </p>
                        <form id="youtubeForm">
                            <input type="url" id="sS(youtubeForm, this.value)" name="youtube" pattern="https://www\.youtube\.com\/user\/(.+)" size="100" maxlength="250" placeholder="https://www.youtube.com/user/..." value="'.$youtube.'">
                        </form>
                    </section>
                </section>
            </div>
        </main>'.get_footer();

    output_html($skeletonTitle, $skeletonDescription, $skeletonContent, $skeletonFeatures, $skeletonKeywords);
