<?php
require_once 'Includes/Classes/UserManager.php';

use Classes\UserManager;

$userManager = new UserManager();
$message = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST["username"] ?? '');
    $email = trim($_POST["email"] ?? '');
    $newPassword = trim($_POST["new_password"] ?? '');
    $confirmPassword = trim($_POST["confirm_password"] ?? '');

    // Check if all fields are filled
    if (empty($username) || empty($email) || empty($newPassword) || empty($confirmPassword)) {
        $message = "All fields are required.";
    } elseif ($newPassword !== $confirmPassword) {
        $message = "Passwords do not match.";
    } else {
        // Attempt to reset the password
        $resetSuccess = $userManager->resetPassword($username, $email, $newPassword);

        if ($resetSuccess) {
            $message = "Password reset successfully!";
        } else {
            $message = "Invalid username or email.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .container {
            background: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
            width: 400px;
            text-align: center;
        }
        h2 {
            margin-bottom: 20px;
        }
        input {
            width: 95%;
            padding: 10px;
            margin: 8px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        button {
            width: 100%;
            background: #007bff;
            color: white;
            padding: 10px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
        }
        button:hover {
            background: #007bff;
        }
        .message {
            color: red;
            margin-top: 10px;
        }
    </style>
</head>
<body>

<div class="container">
    <h2>Reset Password</h2>

    <?php if (!empty($message)): ?>
        <p class="message"><?php echo htmlspecialchars($message); ?></p>
    <?php endif; ?>

    <form action="reset-password.php" method="post">
        <input type="text" name="username" placeholder="Enter Username" required>
        <input type="email" name="email" placeholder="Enter Email" required>
        <input type="password" name="new_password" placeholder="Enter New Password" required>
        <input type="password" name="confirm_password" placeholder="Confirm New Password" required>
        <button type="submit">Reset Password</button>
        <a href="index.php">Login</a>
    </form>
</div>

</body>
</html>
