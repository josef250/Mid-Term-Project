<?php
require_once 'Classes/UserManager.php';

use Classes\UserManager;

if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $userManager = new UserManager();
    $userId = $_GET['id'];

    if ($userManager->deleteUser($userId)) {
        echo "<script>alert('User deleted successfully!');</script>";
    } else {
        echo "<script>alert('Failed to delete user.');</script>";
    }

    echo "<script>window.location.href = '../Add-User.php';</script>";
    exit();
} else {
    echo "<script>alert('Invalid request.'); window.location.href = '../Add-User.php';</script>";
    exit();
}
