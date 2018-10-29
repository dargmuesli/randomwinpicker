<?php
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }

    if (isset($_GET['quantity'])) {
        $_SESSION['quantity'] = $_GET['quantity'];
        die(header('Location:'.getenv('BASE_URL').'/dialog/draw/'));
    }
