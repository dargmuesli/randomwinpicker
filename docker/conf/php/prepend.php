<?php
    set_error_handler('errorHandler');
    set_exception_handler('exceptionHandler');
    register_shutdown_function('shutdownHandler');
    ini_set('display_errors', 'off');
    error_reporting(E_ALL);

    $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? 'https://' : 'http://';
    $_SERVER['SERVER_ROOT'] = str_replace(DIRECTORY_SEPARATOR.$_SERVER['HTTP_HOST'], '', $_SERVER['DOCUMENT_ROOT']);
    $_SERVER['SERVER_ROOT_URL'] = $protocol.$_SERVER['HTTP_HOST'];
    // $firstErrorLogged = false;
    $simpleLogging = $_SERVER['SERVER_NAME'] == 'localhost' ? true : true;

    function errorHandler($errorLevel, $errorMessage, $errorFile, $errorLine, $errorContext)
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

    function shutdownHandler()
    {
        $lastError = error_get_last();

        if ($lastError['type'] == E_ERROR) {
            throw new ErrorException($errorMessage, 0, $errorLevel, $errorFile, $errorLine);
        }
    }

    function exceptionHandler(Exception $exception)
    {
        // global $firstErrorLogged;
        global $simpleLogging;

        $errorOutput = $exception->getMessage();

        if (!$simpleLogging) {
            $errorOutput .= ' in "' . $exception->getFile() . '" on line: ' . $exception->getLine();
        }

        // if (!$firstErrorLogged) {
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
                A error occurred and has been logged. Please contact me directly if this error is not resolved in three days and name the following error message:
                <br>
                "'.$errorOutput.'"
                </p>
            </section>';
        // }

        // $firstErrorLogged = true;
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

    function showDebug($var)
    {
        highlight_string("<?php\n\$data =\n" . var_export($var, true) . ";\n?>");
    }
