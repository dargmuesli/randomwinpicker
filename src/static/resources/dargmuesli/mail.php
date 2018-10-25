<?php
    include_once $_SERVER['DOCUMENT_ROOT'].'/resources/packages/composer/autoload.php';
    include_once $_SERVER['DOCUMENT_ROOT'].'/resources/dargmuesli/filesystem/environment.php';

    function get_mailer($address, $subject, $body, $altBody = "")
    {
        // Load .env file
        load_env_file($_SERVER['SERVER_ROOT'].'/credentials');

        $mail = new PHPMailer;

        $mail->isSMTP();
        $mail->CharSet = 'UTF-8';
        $mail->Host = $_ENV['MAIL_HOST'];
        $mail->Port = $_ENV['MAIL_PORT'];
        $mail->SMTPAuth = true;
        $mail->SMTPSecure = 'ssl';
        $mail->Username = $_ENV['MAIL_USERNAME'];
        $mail->Password = $_ENV['MAIL_PASSWORD'];
        $mail->From = $_ENV['MAIL_USERNAME'];
        $mail->FromName = 'RandomWinPicker';
        $mail->isHTML();
        $mail->addAddress($address);
        $mail->Subject = $subject;
        $mail->Body    = $body;
        $mail->AltBody = $altBody;

        return $mail;
    }
