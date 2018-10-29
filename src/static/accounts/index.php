<?php
    include_once $_SERVER['DOCUMENT_ROOT'].'/resources/dargmuesli/cache/enabled.php';
    include_once $_SERVER['DOCUMENT_ROOT'].'/resources/dargmuesli/base/skeleton.php';
    include_once $_SERVER['DOCUMENT_ROOT'].'/resources/dargmuesli/translation/translations.php';

    include_once $_SERVER['DOCUMENT_ROOT'].'/resources/dargmuesli/account.php';
    include_once $_SERVER['DOCUMENT_ROOT'].'/resources/dargmuesli/sessioncookie.php';
    include_once $_SERVER['DOCUMENT_ROOT'].'/resources/dargmuesli/warning.php';

    include_once $_SERVER['DOCUMENT_ROOT'].'/resources/dargmuesli/filesystem/environment.php';

    last_modified(get_page_mod_time());

    // Load .env file
    load_env_file($_SERVER['SERVER_ROOT'].'/credentials');

    // Get database handle
    $dbh = get_dbh($_ENV['PGSQL_DATABASE']);

    if (isset($email)) {
        // Initialize the required table
        init_table($dbh, 'accounts');

        $stmt = $dbh->prepare('SELECT hash FROM accounts WHERE mail = :email');
        $stmt->bindParam(':email', $email);

        if (!$stmt->execute()) {
            throw new PDOException($stmt->errorInfo()[2]);
        }

        $row = $stmt->fetch()[0];

        if ($hash == $row) {
            $dieLocation = getenv('BASE_URL').'/dialog/participants/';
        }
    }

    // Redirect accordingly
    if (isset($dieLocation)) {
        die(header('Location: ' . $dieLocation));
    }

    $skeletonTitle = translate('pages.accounts.title.head');
    $skeletonDescription = 'Login to or register for RandomWinPicker to gain access to all features';
    $skeletonFeatures = ['lcl/ext/css'];
    $skeletonKeywords = 'login, register, signin, signup, login, account, password, features, password, access';
    $skeletonContent = '
        <header>'.get_warning_html($success, $error).'
            <div id="back">
                <a class="rotate" href="../" title="Back"></a>
            </div>
        </header>
        <main>
            <h1>
                '.translate('pages.accounts.title.head').'
            </h1>
            <p>
                '.translate('pages.accounts.description.short').'
            </p>
            <p>
                '.translate('pages.accounts.description.details').'
            </p>
            <form method="post" action="'.getenv('BASE_URL').'/resources/dargmuesli/logreg.php?task=in';

    if (isset($_GET['file'])) {
        $skeletonContent .= '&file=' . $_GET['file'];
    }

    $skeletonContent .= '">
            <p>
                <input pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,3}$" required title="'.translate('pages.accounts.input.email.title').'" type="email" name="email" placeholder="'.translate('pages.accounts.input.email.placeholder').'" id="email" size="30">
                <input pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{6,}" required title="'.translate('pages.accounts.input.password.title').'" type="password" name="password" placeholder="'.translate('pages.accounts.input.password.placeholder').'" id="password" size="30">
            </p>';

    $now = new DateTime('now', new DateTimeZone('UTC'));

    if (!isset($_SESSION['time'])) {
        $_SESSION['time'] = serialize($now);
    } else {
        $then = unserialize($_SESSION['time']);
        $interval = $then->diff($now);
        $timespan = $interval->format('%s');
        $_SESSION['time'] = serialize($now);

        if ($timespan < 5) {
            $skeletonContent .= '
                <p>
                    <img id="captcha" alt="CAPTCHA Image" src="'.getenv('BASE_URL').'/resources/packages/composer/dapphp/securimage/securimage_show.php"></img>
                    <br>
                    <input type="text" title="6 characters and numbers." pattern=".{6,}" required size="6" name="captcha_code" placeholder="captcha" size="10" maxlength="6" />
                </p>';
        }
    }

    $skeletonContent .= '
            <p>
                <input type="checkbox" name="save" id="save"> '.translate('pages.accounts.input.checkbox').'
            </p>
            <p>
                <button type="submit" name="submit">
                    '.translate('pages.accounts.title.head').'
                </button>
            </p>
        </form>
        <p>
            <a href="./recovery/" title="Reset password">
                '.translate('pages.accounts.link.recovery').'
            </a>
        </p>
        <p>
            <a href="'.getenv('BASE_URL').'/dialog/participants/" title="Skip">
                '.translate('pages.accounts.link.skip').'
            </a>
        </p>
    </main>'.get_footer();

    output_html($skeletonTitle, $skeletonDescription, $skeletonContent, $skeletonFeatures, $skeletonKeywords);
