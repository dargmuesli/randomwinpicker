<?php
    if (isset($_GET['quantity'])) {
        $_SESSION['quantity'] = $_GET['quantity'];
        die(header('Location:/dialog/draw/'));
    }
