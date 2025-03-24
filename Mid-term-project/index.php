<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-color: #f8f9fa;
        }
        .login-container {
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 400px;
        }
    </style>
</head>
<body>
<div class="login-container">
    <h3 class="text-center">Login</h3>
    <form action="includes/login.inc.php" method="post">
        <div class="mb-3">
            <label for="email" class="form-label">Email address</label>
            <input type="username" class="form-control" id="username" name="username" placeholder="Username" required>
        </div>
        <div class="mb-3">
            <label for="password" class="form-label">Password</label>
            <input type="password" class="form-control" id="password" name="password" placeholder="Password" required>
        </div>
        <button type="submit" class="btn btn-primary w-100">Login</button>
    </form>
    <p class="text-center mt-3">
        <a href="reset-password.php">Forgot password?</a>
    </p>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
