<?php
    function get_cookie_mod_times()
    {
        $cookieModTimes = [];

        foreach ($_COOKIE as $name => $data) {
            $decodedData = json_decode($data, true);

            if (isset($decodedData['lastupdate'])) {
                array_push($cookieModTimes, $decodedData['lastupdate']);
            }
        }

        return $cookieModTimes;
    }

    function get_page_mod_time()
    {
        $cookieModTimes = get_cookie_mod_times();
        $cookieModTimesCount = count($cookieModTimes);

        $lastChangeStatic = max(array_map('filemtime', array_filter(get_included_files(), 'is_file')));
        $lastChangeDynamic = null;

        if ($cookieModTimesCount > 1) {
            $lastChangeDynamic = intval(max($cookieModTimes));
        } elseif ($cookieModTimesCount == 1) {
            $lastChangeDynamic = intval($cookieModTimes[0]);
        }

        return max($lastChangeStatic, $lastChangeDynamic);
    }

    function last_modified($timestamp, $identifier = '', $strict = false)
    {
        if (headers_sent()) {
            return false;
        } else {
            $clientEtag =
                !empty($_SERVER['HTTP_IF_NONE_MATCH'])
                ?   trim($_SERVER['HTTP_IF_NONE_MATCH'])
                :   null
            ;
            $clientLastModified =
                !empty($_SERVER['HTTP_IF_MODIFIED_SINCE'])
                ?   trim($_SERVER['HTTP_IF_MODIFIED_SINCE'])
                :   null
            ;
            $clientAcceptEncoding =
                isset($_SERVER['HTTP_ACCEPT_ENCODING'])
                ?   $_SERVER['HTTP_ACCEPT_ENCODING']
                :   ''
            ;

            $serverLastModified = gmdate('D, d M Y H:i:s', $timestamp).' GMT';
            $serverEtag = md5($timestamp.$clientAcceptEncoding.$identifier);

            $matchingLastModified = $clientLastModified == $serverLastModified;
            $matchingEtag = $clientEtag && strpos($clientEtag, $serverEtag) !== false;

            header('Last-Modified: '.$serverLastModified);
            header('ETag: "'.$serverEtag.'"');
            header('Cache-Control: no-cache');

            if (
                ($clientLastModified && $clientEtag) || $strict
                ?   $matchingLastModified && $matchingEtag
                :   $matchingLastModified || $matchingEtag
            ) {
                header($_SERVER['SERVER_PROTOCOL'].' 304 Not Modified');
                exit(304);
            }

            return true;
        }
    }
