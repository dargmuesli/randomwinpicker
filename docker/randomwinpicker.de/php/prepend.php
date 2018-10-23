<?php
    set_error_handler('error_handler');
    set_exception_handler('exception_handler');
    register_shutdown_function('shutdown_handler');
    ini_set('display_errors', 'off');
    error_reporting(E_ALL);

    $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? 'https://' : 'http://';
    $simpleLogging = strrchr($_SERVER['SERVER_NAME'], '.') == '.test' ? false : true;

    $_SERVER['SERVER_ROOT'] = dirname($_SERVER['DOCUMENT_ROOT']);
    $_SERVER['SERVER_ROOT_URL'] = $protocol.$_SERVER['HTTP_HOST'];

    if (substr($_SERVER['SERVER_ROOT_URL'], -1) != '/') {
        $_SERVER['SERVER_ROOT_URL'] .= '/';
    }

    if (array_key_exists('HTTP_X_FORWARDED_PREFIX', $_SERVER)) {
        $_SERVER['SERVER_ROOT_URL'] .= $_SERVER['HTTP_X_FORWARDED_PREFIX'];
    }

    function error_handler($errorLevel, $errorMessage, $errorFile, $errorLine, $errorContext)
    {
        switch ($errorLevel) {
            case E_ERROR:               throw new ErrorException($errorMessage, 0, $errorLevel, $errorFile, $errorLine);
            case E_WARNING:             throw new WarningException($errorMessage, 0, $errorLevel, $errorFile, $errorLine);
            case E_PARSE:               throw new ParseException($errorMessage, 0, $errorLevel, $errorFile, $errorLine);
            case E_NOTICE:              throw new NoticeException($errorMessage, 0, $errorLevel, $errorFile, $errorLine);
            case E_CORE_ERROR:          throw new CoreErrorException($errorMessage, 0, $errorLevel, $errorFile, $errorLine);
            case E_CORE_WARNING:        throw new CoreWarningException($errorMessage, 0, $errorLevel, $errorFile, $errorLine);
            case E_COMPILE_ERROR:       throw new CompileErrorException($errorMessage, 0, $errorLevel, $errorFile, $errorLine);
            case E_COMPILE_WARNING:     throw new CoreWarningException($errorMessage, 0, $errorLevel, $errorFile, $errorLine);
            case E_USER_ERROR:          throw new UserErrorException($errorMessage, 0, $errorLevel, $errorFile, $errorLine);
            case E_USER_WARNING:        throw new UserWarningException($errorMessage, 0, $errorLevel, $errorFile, $errorLine);
            case E_USER_NOTICE:         throw new UserNoticeException($errorMessage, 0, $errorLevel, $errorFile, $errorLine);
            case E_STRICT:              throw new StrictException($errorMessage, 0, $errorLevel, $errorFile, $errorLine);
            case E_RECOVERABLE_ERROR:   throw new RecoverableErrorException($errorMessage, 0, $errorLevel, $errorFile, $errorLine);
            case E_DEPRECATED:          throw new DeprecatedException($errorMessage, 0, $errorLevel, $errorFile, $errorLine);
            case E_USER_DEPRECATED:     throw new UserDeprecatedException($errorMessage, 0, $errorLevel, $errorFile, $errorLine);
            default:                    throw new ErrorException($errorMessage, 0, $errorLevel, $errorFile, $errorLine);
        }

        return true;
    }

    function shutdown_handler()
    {
        $lastError = error_get_last();

        if ($lastError['type'] == E_ERROR) {
            throw new ErrorException($lastError['message'], 0, $lastError['type'], $lastError['file'], $lastError['line']);
        }
    }

    function exception_handler(Exception $exception)
    {
        global $simpleLogging;

        http_response_code(500);

        $errorOutput = $exception->getMessage();

        if (!$simpleLogging) {
            $errorOutput .= ' in \'' . $exception->getFile() . '\' on line: ' . $exception->getLine();
        }

        echo '
            <section>
                <h2>
                    DE
                </h2>
                <p>
                Ein Fehler trat auf und wurde protokolliert. Kontaktiere mich bitte direkt, wenn der Fehler in drei Tagen nicht behoben ist und nenne folgende Fehlermeldung:
                <br>
                "'.$errorOutput.'"
                </p>
            </section>
            <section>
                <h2>
                    EN
                </h2>
                <p>
                An error occurred and has been logged. Please contact me directly if this error is not resolved in three days and name the following error message:
                <br>
                "'.$errorOutput.'"
                </p>
            </section>';
    }

    class WarningException extends ErrorException
    {
    }
    class ParseException extends ErrorException
    {
    }
    class NoticeException extends ErrorException
    {
    }
    class CoreErrorException extends ErrorException
    {
    }
    class CoreWarningException extends ErrorException
    {
    }
    class CompileErrorException extends ErrorException
    {
    }
    class CompileWarningException extends ErrorException
    {
    }
    class UserErrorException extends ErrorException
    {
    }
    class UserWarningException extends ErrorException
    {
    }
    class UserNoticeException extends ErrorException
    {
    }
    class StrictException extends ErrorException
    {
    }
    class RecoverableErrorException extends ErrorException
    {
    }
    class DeprecatedException extends ErrorException
    {
    }
    class UserDeprecatedException extends ErrorException
    {
    }

    function show_debug($var)
    {
        highlight_string('<?php\n\$data =\n' . var_export($var, true) . ';\n?>');
    }
