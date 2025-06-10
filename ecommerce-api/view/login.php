<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Fetch user from DB using $_POST['email']
    // Example:
    // $user = getUserByEmail($_POST['email']);
    // if ($user && password_verify($_POST['password'], $user['password'])) {

    // Replace with your actual DB check:
    if ($_POST['email'] === 'user@example.com' && $_POST['password'] === 'password123') {
        $_SESSION['user_id'] = 1; // Replace with real user ID
        $_SESSION['username'] = 'John Doe'; // Replace with real username
        header("Location: index.php");
        exit;
    } else {
        $error = "Invalid email or password.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title>Login</title>
    <style>
        body {
            font-family: 'Segoe UI', Arial, sans-serif;
            background: #000814;
            color: #FFD60A;
            padding: 20px;
        }
        .container {
            max-width: 400px;
            margin: 40px auto 0 auto;
            background: #001d3d;
            padding: 28px 24px 24px 24px;
            border-radius: 12px;
            box-shadow: 0 2px 16px rgba(0,8,20,0.18);
            color: #FFD60A;
        }
        h2 {
            color: #FFC300;
            margin-bottom: 18px;
        }
        input[type="email"], input[type="password"] {
            width: 100%;
            padding: 10px;
            margin: 10px 0 18px 0;
            border-radius: 6px;
            border: 1.5px solid #FFC300;
            background: #003566;
            color: #FFD60A;
            font-size: 1em;
        }
        input[type="email"]:focus, input[type="password"]:focus {
            outline: none;
            border-color: #FFD60A;
            background: #001d3d;
        }
        input[type="submit"], button {
            padding: 10px 20px;
            background: #FFC300;
            color: #001d3d;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-weight: bold;
            font-size: 1em;
            transition: background 0.2s, color 0.2s;
        }
        input[type="submit"]:hover, button:hover {
            background: #FFD60A;
            color: #000814;
        }
        .error {
            color: #FF4C4C;
            background: #1a1a1a;
            border-left: 4px solid #FF4C4C;
            padding: 8px 12px;
            border-radius: 4px;
            margin-bottom: 12px;
        }
        .success {
            color: #28a745;
            background: #1a1a1a;
            border-left: 4px solid #28a745;
            padding: 8px 12px;
            border-radius: 4px;
            margin-bottom: 12px;
        }
        a {
            color: #FFD60A;
            text-decoration: underline;
        }
        a:hover {
            color: #FFC300;
        }
        label {
            font-weight: 500;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Login</h2>

        <?php if (!empty($error)): ?>
            <p class="error"><?= htmlspecialchars($error) ?></p>
        <?php endif; ?>

        <?php if (!empty($success)): ?>
            <p class="success"><?= htmlspecialchars($success) ?></p>
        <?php endif; ?>
        <form action="/ecommerce-store/ecommerce-api/view/index.php" method="POST">
            <label>Email:</label>
            <input type="email" name="email" required>

            <label>Password:</label>
            <input type="password" name="password" required>

            <input type="submit" value="Login">
        </form>
    </div>

    <p style="text-align:center; margin-top:18px;">
        Don't have an account? <a href="signup.php">Sign up here</a>.
    </p>
</body>
</html>
