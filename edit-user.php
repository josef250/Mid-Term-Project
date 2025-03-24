<?php
// Include necessary files
require_once 'Includes/Classes/UserFilter.php';
require_once 'Includes/Classes/UserManager.php';

use Classes\UserFilter;
use Classes\UserManager;

// Get the user ID from the URL
$userId = isset($_GET['id']) ? $_GET['id'] : null;
if (!$userId) {
    die("User ID not provided.");
}

// Create an instance of UserFilter to fetch the user details
$userFilter = new UserFilter($userId);
$userData = $userFilter->getUserinfo();

// Ensure the user exists in the database
if (!$userData) {
    die("User not found.");
} else {
    // Access the first (and only) element in the array
    $userData = $userData[0];
}

// Create an instance of UserManager to handle user updates
$userManager = new UserManager();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $firstname = isset($_POST["firstname"]) ? htmlspecialchars($_POST["firstname"]) : '';
    $lastname = isset($_POST["lastname"]) ? htmlspecialchars($_POST["lastname"]) : '';
    $email = isset($_POST["email"]) ? htmlspecialchars($_POST["email"]) : '';
    $phone = isset($_POST["phone"]) ? htmlspecialchars($_POST["phone"]) : '';
    $username = isset($_POST["username"]) ? htmlspecialchars($_POST["username"]) : '';
    $role = isset($_POST["role"]) ? htmlspecialchars($_POST["role"]) : '';

    // Call the method to update user details
    try {
        $userManager->editUser($userId, $firstname, $lastname, $email, $phone, $username, $role);
        echo '<script>alert("User updated successfully!"); window.location.href="Add-User.php";</script>';
    } catch (PDOException $e) {
        echo '<script>alert("Error: ' . $e->getMessage() . '");</script>';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit User</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .container {
            margin-top: 50px;
        }
        .card {
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
            max-width: 600px;
            margin: auto;
        }
        .form-label {
            font-weight: bold;
        }
    </style>
</head>
<body>
<div class="container">
    <div class="card p-4">
        <h3 class="text-center">Edit User</h3>
        <form method="POST">
            <!-- First Name -->
            <div class="mb-3">
                <label for="firstname" class="form-label">First Name</label>
                <input type="text" class="form-control" name="firstname" value="<?= htmlspecialchars($userData['firstname'] ?? '') ?>" required>
            </div>

            <!-- Last Name -->
            <div class="mb-3">
                <label for="lastname" class="form-label">Last Name</label>
                <input type="text" class="form-control" name="lastname" value="<?= htmlspecialchars($userData['lastname'] ?? '') ?>" required>
            </div>

            <!-- Email -->
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" name="email" value="<?= htmlspecialchars($userData['email'] ?? '') ?>" required>
            </div>

            <!-- Phone -->
            <div class="mb-3">
                <label for="phone" class="form-label">Phone</label>
                <input type="text" class="form-control" name="phone" value="<?= htmlspecialchars($userData['phone'] ?? '') ?>" required>
            </div>

            <!-- Username -->
            <div class="mb-3">
                <label for="username" class="form-label">Username</label>
                <input type="text" class="form-control" name="username" value="<?= htmlspecialchars($userData['username'] ?? '') ?>" required>
            </div>

            <!-- Role -->
            <div class="mb-3">
                <label for="role" class="form-label">Role</label>
                <select class="form-control" name="role" required>
                    <option value="Admin" <?= ($userData['role'] ?? '') == 'Admin' ? 'selected' : '' ?>>Admin</option>
                    <option value="User" <?= ($userData['role'] ?? '') == 'User' ? 'selected' : '' ?>>User</option>
                </select>
            </div>

            <!-- Submit Button -->
            <button type="submit" class="btn btn-primary w-100">Save Changes</button>
        </form>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
