<?php
    if (isset($_GET['quantity'])) {
        $_SESSION['quantity'] = $_GET['quantity'];
        die(header('Location:/dialog/draw/'));
    }

// <?php if (isset($email) && isset($_COOKIE['items'])) {
//     echo count(json_decode($_COOKIE['items']), true);
// } elseif (isset($_SESSION['items'])) {
//     echo count($_SESSION['items']);
// } else {
//     echo 1;
// };
