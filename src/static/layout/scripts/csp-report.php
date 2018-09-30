<?php
    require_once $_SERVER['DOCUMENT_ROOT'] . '/layout/scripts/mail.php';

    // Send `204 No Content` status code
    http_response_code(204);

    // Get the raw POST data
    $data = file_get_contents('php://input');
    // Only continue if it's valid JSON that is not just `null`, `0`, `false` or an
    // empty string, i.e. if it could be a CSP violation report.
    if ($data = json_decode($data)) {
        // Prettify the JSON-formatted data
        $data = json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
        // Mail the CSP violation report

        $mail = get_mailer(
            'e-mail@randomwinpicker.de',
            'CSP violation',
            $data
        );

        //$mail->send();
    }
