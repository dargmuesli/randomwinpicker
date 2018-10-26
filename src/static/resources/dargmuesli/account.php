<?php
    include_once $_SERVER['DOCUMENT_ROOT'].'/resources/dargmuesli/database/pdo.php';
    include_once $_SERVER['DOCUMENT_ROOT'].'/resources/dargmuesli/filesystem/environment.php';
    include_once $_SERVER['DOCUMENT_ROOT'].'/resources/dargmuesli/translation/translations.php';

    function get_account_html($email)
    {
        $accountHtml = '';

        // Load .env file
        load_env_file($_SERVER['SERVER_ROOT'].'/credentials');

        // Get database handle
        $dbh = get_dbh($_ENV['PGSQL_DATABASE']);

        if (isset($email)) {
            // Initialize the required table
            init_table($dbh, 'accounts');

            $stmt = $dbh->prepare('SELECT privacy FROM accounts WHERE mail = :email');
            $stmt->bindParam(':email', $email);

            if (!$stmt->execute()) {
                throw new PDOException($stmt->errorInfo()[2]);
            }

            $privacy = $stmt->fetch()[0];
        }

        if (!isset($privacy)) {
            $accountHtml = translate('scripts.account.guest').' | <a href="/accounts/" title="'.translate('scripts.account.login').'">'.translate('scripts.account.login').'</a>';
        } elseif (($privacy == 'E-mail address') && isset($email)) {
            $accountHtml = '<a href="/accounts/profile/" title="'.translate('scripts.account.profile').'">' . $email . ' &#x2261;</a> | <a href="/resources/dargmuesli/logreg.php?task=out" title="'.translate('scripts.account.logout').'">'.translate('scripts.account.logout').'</a>';
        } elseif ($privacy == 'Member') {
            $accountHtml = '<a href="/accounts/profile/" title="'.translate('scripts.account.profile').'">'.translate('scripts.account.member').' &#x2261;</a> | <a href="/resources/dargmuesli/logreg.php?task=out" title="'.translate('scripts.account.logout').'">'.translate('scripts.account.logout').'</a>';
        } elseif (($privacy != 'E-mail address') && ($privacy != 'Member')) {
            $accountHtml = '<a href="/accounts/profile/" title="'.translate('scripts.account.profile').'">' . $privacy . ' &#x2261;</a> | <a href="/resources/dargmuesli/logreg.php?task=out" title="'.translate('scripts.account.logout').'">'.translate('scripts.account.logout').'</a>';
        }

        return $accountHtml;
    }
