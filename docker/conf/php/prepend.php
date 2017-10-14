<?php
    set_error_handler('errorHandler');
    register_shutdown_function('shutdownHandler');

    $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? 'https://' : 'http://';

    $_SERVER['SERVER_ROOT'] = str_replace(DIRECTORY_SEPARATOR.$_SERVER['HTTP_HOST'], '', $_SERVER['DOCUMENT_ROOT']);
    $_SERVER['SERVER_ROOT_URL'] = $protocol.$_SERVER['HTTP_HOST'];

    $firstErrorLogged = false;

    $simpleLogging = false;

    function errorHandler($errorLevel, $errorMessage, $errorFile, $errorLine, $errorContext) {
        switch ($errorLevel) {
            case E_ERROR:
            case E_CORE_ERROR:
            case E_COMPILE_ERROR:
            case E_PARSE:
                errorLog('fatal', $errorMessage, $errorFile, $errorLine);
                break;
            case E_USER_ERROR:
            case E_RECOVERABLE_ERROR:
                errorLog('error', $errorMessage, $errorFile, $errorLine);
                break;
            case E_WARNING:
            case E_CORE_WARNING:
            case E_COMPILE_WARNING:
            case E_USER_WARNING:
                errorLog('warn', $errorMessage, $errorFile, $errorLine);
                break;
            case E_NOTICE:
            case E_USER_NOTICE:
                errorLog('info', $errorMessage, $errorFile, $errorLine);
                break;
            case E_STRICT:
                errorLog('debug', $errorMessage, $errorFile, $errorLine);
                break;
            default:
                errorLog('warn', $errorMessage, $errorFile, $errorLine);
        }
    }

    function shutdownHandler() {
        $lasterror = error_get_last();

        switch ($lasterror['type']) {
            case E_ERROR:
            case E_CORE_ERROR:
            case E_COMPILE_ERROR:
            case E_USER_ERROR:
            case E_RECOVERABLE_ERROR:
            case E_CORE_WARNING:
            case E_COMPILE_WARNING:
            case E_PARSE:
                errorLog($lasterror['type'], $lasterror['message'], $lasterror['file'], $lasterror['line']);
                break;
        }
    }

    function errorLog($errorLevel, $errorMessage, $errorFile, $errorLine) {
        global $firstErrorLogged;
        global $simpleLogging;

        $errorOutput = null;

        if ($simpleLogging) {
            $errorOutput = $errorMessage . ' in ' . $errorFile;
        } else {
            $errorOutput = $errorMessage . ' in "' . $errorFile . '" on line: ' . $errorLine;
        }

        if (!$firstErrorLogged) {
            echo '
            <section>
                <h2>
                    DE
                </h2>
                <br>
                Ein Fehler trat auf und wurde protokolliert. Kontaktiere mich bitte direkt, wenn der Fehler in drei Tagen nicht behoben ist und nenne folgende Fehlermeldung:
                <br>
                "'.$errorOutput.'"
            </section>
            <section>
                <h2>
                    EN
                </h2>
                <br>
                A error occurred and has been logged. Please contact me directly if this error is not resolved in three days and name the following error message:
                <br>
                "'.$errorOutput.'"
            </section>';
        }

        $firstErrorLogged = true;
    }

    function showDebug($var) {
        highlight_string("<?php\n\$data =\n" . var_export($var, true) . ";\n?>");
    }
