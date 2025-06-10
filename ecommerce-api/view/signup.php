<?php
if (session_status() === PHP_SESSION_NONE) session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    require_once __DIR__ . '/../config/database.php';

    $db = (new Database())->getConnection();

    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $address = trim($_POST['address']);

    // Check if email already exists
    $stmt = $db->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->execute([$email]);
    if ($stmt->fetch()) {
        $_SESSION['error'] = "Email already registered.";
        header("Location: signup.php");
        exit;
    }

    // Hash the password
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // Insert user
    $stmt = $db->prepare("INSERT INTO users (username, email, password, shippingAddress) VALUES (?, ?, ?, ?)");
    if ($stmt->execute([$username, $email, $hashedPassword, $address])) {
        // Optionally log the user in automatically:
        $_SESSION['user_id'] = $db->lastInsertId();
        $_SESSION['username'] = $username;
        header("Location: index.php");
        exit;
    } else {
        $_SESSION['error'] = "Registration failed. Please try again.";
        header("Location: signup.php");
        exit;
    }
}

include __DIR__ . '/header.php';
?>

<style>
    .signup-container {
        max-width: 500px;
        margin: 40px auto;
        padding: 30px;
        background: #ffffff;
        border-radius: 12px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.05);
    }

    .signup-title {
        color: #6B46C1;
        text-align: center;
        font-size: 2em;
        margin-bottom: 30px;
        position: relative;
        padding-bottom: 15px;
    }

    .signup-title:after {
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

    .login-link {
        text-align: center;
        margin-top: 20px;
        color: #666;
    }

    .login-link a {
        color: #6B46C1;
        text-decoration: none;
        font-weight: 600;
    }

    .login-link a:hover {
        text-decoration: underline;
    }

    .error-message {
        color: #dc3545;
        background: #f8d7da;
        padding: 10px;
        border-radius: 6px;
        margin-bottom: 20px;
        text-align: center;
    }
</style>

<div class="signup-container">
    <h1 class="signup-title">Create Account</h1>
    
    <?php if (isset($_SESSION['error'])): ?>
        <div class="error-message">
            <?= htmlspecialchars($_SESSION['error']) ?>
            <?php unset($_SESSION['error']); ?>
        </div>
    <?php endif; ?>

    <form action="/ecommerce-store/ecommerce-api/view/signup.php" method="POST">
        <div class="form-group">
            <label for="username">Username</label>
            <input type="text" id="username" name="username" required>
        </div>

        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" id="email" name="email" required>
        </div>

        <div class="form-group">
            <label for="password">Password</label>
            <input type="password" id="password" name="password" required>
        </div>

        <div class="form-group">
            <label for="address">Shipping Address</label>
            <input type="text" id="address" name="address" required>
        </div>

        <button type="submit" class="submit-btn">Sign Up</button>
    </form>

    <div class="login-link">
        Already have an account? <a href="/ecommerce-store/ecommerce-api/view/login.php">Sign In</a>
    </div>
</div>

<?php include __DIR__ . '/footer.php'; ?>


