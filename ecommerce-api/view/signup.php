<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title>Sign Up</title>
    <style>
        body {
            font-family: 'Segoe UI', Arial, sans-serif;
            background: #000814;
            color: #FFD60A;
            padding: 20px;
        }
        .container {
            max-width: 420px;
            margin: 40px auto 0 auto;
            background: #001d3d;
            padding: 28px 24px 24px 24px;
            border-radius: 12px;
            box-shadow: 0 2px 16px rgba(0,8,20,0.18);
            color: #FFD60A;
        }
        h1 {
            color: #FFC300;
            text-align: center;
            margin-bottom: 22px;
        }
        label {
            font-weight: 500;
        }
        input[type="text"], input[type="email"], input[type="password"], textarea {
            width: 100%;
            padding: 10px;
            margin: 10px 0 18px 0;
            border-radius: 6px;
            border: 1.5px solid #FFC300;
            background: #003566;
            color: #FFD60A;
            font-size: 1em;
            resize: vertical;
        }
        input[type="text"]:focus, input[type="email"]:focus, input[type="password"]:focus, textarea:focus {
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
    </style>
</head>
<body>
    <div class="container">
        <h1>Sign Up</h1>

        <?php if (!empty($error)) echo "<p class='error'>".htmlspecialchars($error)."</p>"; ?>
        <?php if (!empty($success)) echo "<p class='success'>".htmlspecialchars($success)."</p>"; ?>

        <form action="/online_store/public/index.php?url=user/signup" method="POST">
            <label>Username: </label>
            <input type="text" name="username" required>

            <label>Email: </label>
            <input type="email" name="email" required>

            <label>Password: </label>
            <input type="password" name="password" required>

            <label>Shipping Address: </label>
            <textarea name="shippingAddress" required></textarea>

            <input type="submit" value="Sign Up">
        </form>

        <p style="text-align:center; margin-top:18px;">
            Already have an account? <a href="login.php">Login here</a>.
        </p>
    </div>
</body>
</html>


