<?php

require_once 'Classes/Login.php';

use Classes\Login;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = htmlspecialchars($_POST["username"]);
    $password = $_POST["password"];

    // Create a Login object and pass username/password
    $login = new Login($username, $password);

    // Perform the login
    $login_results = $login->login();

    if ($login_results === true) {
        header('Location: ../Add-User.php');
        exit;
    } else {
        // Show error message
        echo '<script>alert("' . $login_results . '"); window.location.href = "../index.php";</script>';
    }
}
