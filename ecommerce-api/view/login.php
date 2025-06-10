<?php
if (session_status() === PHP_SESSION_NONE) session_start();
include __DIR__ . '/header.php';

// If user is already logged in, redirect to home
if (isset($_SESSION['user_id'])) {
    header("Location: /ecommerce-store/ecommerce-api/view/index.php");
    exit;
}

$error = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    require_once '../models/User.php';
    $user = new User();
    
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';
    
    if ($user->login($email, $password)) {
        header("Location: /ecommerce-store/ecommerce-api/view/index.php");
        exit;
    } else {
        $error = "Invalid email or password";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign In - BookStore</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: 'Segoe UI', Arial, sans-serif;
            background: #f5f5f5;
            min-height: 100vh;
        }

        .login-container {
            max-width: 400px;
            margin: 40px auto;
            padding: 30px;
            background: #ffffff;
            border-radius: 12px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        }

        .login-title {
            color: #6B46C1;
            text-align: center;
            font-size: 2em;
            margin-bottom: 30px;
            position: relative;
            padding-bottom: 15px;
        }

        .login-title:after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 50%;
            transform: translateX(-50%);
            width: 60px;
            height: 3px;
            background: #6B46C1;
            border-radius: 2px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            color: #333;
            font-weight: 500;
        }

        .form-group input {
            width: 100%;
            padding: 12px;
            border: 1px solid #ddd;
            border-radius: 8px;
            font-size: 1em;
            transition: all 0.3s ease;
        }

        .form-group input:focus {
            border-color: #6B46C1;
            outline: none;
            box-shadow: 0 0 0 2px rgba(107, 70, 193, 0.1);
        }

        .submit-btn {
            width: 100%;
            padding: 12px;
            background: #6B46C1;
            color: #ffffff;
            border: none;
            border-radius: 8px;
            font-size: 1em;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .submit-btn:hover {
            background: #553C9A;
            transform: translateY(-2px);
        }

        .submit-btn:active {
            transform: translateY(0);
        }

        .error-message {
            color: #dc3545;
            background: #fff;
            padding: 10px;
            border: 1px solid #dc3545;
            border-radius: 6px;
            margin-bottom: 20px;
            text-align: center;
            font-size: 0.9em;
        }

        .signup-link {
            text-align: center;
            margin-top: 20px;
            color: #666;
        }

        .signup-link a {
            color: #6B46C1;
            text-decoration: none;
            font-weight: 500;
        }

        .signup-link a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <h1 class="login-title">Sign In</h1>
        
        <?php if ($error !== null): ?>
            <div class="error-message"><?= $error ?></div>
        <?php endif; ?>

        <form action="/ecommerce-store/ecommerce-api/view/index.php" method="POST">
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" required>
            </div>

            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" required>
            </div>

            <button type="submit" class="submit-btn">Sign In</button>
        </form>

        <div class="signup-link">
            Don't have an account? <a href="/ecommerce-store/ecommerce-api/view/signup.php">Sign Up</a>
        </div>
    </div>
</body>
</html>
