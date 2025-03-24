<?php

require_once 'Classes/UserManager.php';

use Classes\UserManager;

// Initialize UserManager
$userManager = new UserManager();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    try {
        // Retrieve form data
        $firstname = htmlspecialchars($_POST["firstname"]);
        $lastname = htmlspecialchars($_POST["lastname"]);
        $email = htmlspecialchars($_POST["email"]);
        $phone = htmlspecialchars($_POST["phone"]);
        $username = htmlspecialchars($_POST["username"]);
        $role = htmlspecialchars($_POST["role"]);
        $password = htmlspecialchars($_POST["password"]);

        // Begin transaction
        $userManager->beginTransaction();

        // Insert user
        $user_id = $userManager->insertUser($firstname, $lastname, $email, $phone);


        // Insert credentials
        $userManager->insertCredentials($user_id, $username, $role, $password);


        // Commit transaction
        $userManager->commitTransaction();

        echo '<script>alert("User Added Successfully!");</script>';
        echo '<script>location.href = "../Add-User.php";</script>';
    } catch (PDOException $e) {
        $userManager->rollBackTransaction();
        echo '<script>alert("Error: ' . $e->getMessage() . '");</script>';
        echo '<script>location.href = "../Dashboard/users.php";</script>';
    }
}
