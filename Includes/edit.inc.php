<?php
require_once 'Classes/UserManager.php';

use Classes\UserManager;

$userManager = new UserManager();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    try {
        $userId    = $_POST['user_id'];
        $firstname = $_POST['firstname'];
        $lastname  = $_POST['lastname'];
        $email     = $_POST['email'];
        $phone     = $_POST['phone'];
        $username  = $_POST['username'];
        $role      = $_POST['role'];

        $userManager->editUser($userId, $firstname, $lastname, $email, $phone, $username, $role);

        echo '<script>alert("User Updated Successfully!");</script>';
        echo '<script>location.href = "..Add-User.php";</script>';
    } catch (Exception $e) {
        echo '<script>alert("Error: ' . $e->getMessage() . '");</script>';
    }
}
