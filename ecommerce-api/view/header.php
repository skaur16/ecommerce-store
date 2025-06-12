<?php
if (session_status() === PHP_SESSION_NONE) session_start();

// Handle logout
if (isset($_GET['logout'])) {
    session_destroy();
    header("Location: /ecommerce-store/ecommerce-api/view/index.php");
    exit;
}

// Get cart count
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../models/Cart.php';

$database = new Database();
$db = $database->getConnection();
$cartModel = new Cart($db);

$cartCount = 0;
if (isset($_SESSION['user_id'])) {
    // Logged-in user: count unique items from database
    $cartItems = $cartModel->getUserCart($_SESSION['user_id']);
    if ($cartItems) {
        // Count number of items
        $cartCount = count($cartItems);
    }
} else {
    // Guest user: count unique items from session
    if (isset($_SESSION['guest_cart']) && !empty($_SESSION['guest_cart'])) {
        $cartCount = count($_SESSION['guest_cart']);
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>E-Commerce Store</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            background: #ffffff;
            color: #333333;
            font-family: 'Segoe UI', Arial, sans-serif;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        .header {
            background: #ffffff;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            position: sticky;
            top: 0;
            z-index: 1000;
            width: 100%;
        }

        .nav-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 15px 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .nav-left {
            display: flex;
            align-items: center;
            gap: 20px;
        }

        .nav-center {
            text-align: center;
            font-weight: 600;
            color: #6B46C1;
        }

        .nav-right {
            display: flex;
            align-items: center;
            gap: 20px;
        }

        .logo {
            color: #6B46C1;
            text-decoration: none;
            font-size: 1.5em;
            font-weight: bold;
        }

        .nav-link {
            color: #333333;
            text-decoration: none;
            font-weight: 500;
            transition: color 0.3s ease;
        }

        .nav-link:hover {
            color: #6B46C1;
        }

        .cart-icon {
            position: relative;
            text-decoration: none;
            color: #333333;
        }

        .cart-count {
            position: absolute;
            top: -8px;
            right: -8px;
            background: #6B46C1;
            color: white;
            border-radius: 50%;
            padding: 2px 6px;
            font-size: 0.8em;
        }

        .welcome-text {
            color: #6B46C1;
            font-weight: 600;
            margin-right: 10px;
        }

        .logout-link {
            color: #dc3545;
            text-decoration: none;
            font-weight: 500;
            transition: color 0.3s ease;
        }

        .logout-link:hover {
            color: #c82333;
        }

        main {
            flex: 1;
            width: 100%;
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }
    </style>
</head>
<body>
    <header class="header">
        <nav class="nav-container">
            <div class="nav-left">
                <a href="/ecommerce-store/ecommerce-api/view/index.php" class="logo">BookStore</a>
                <a href="/ecommerce-store/ecommerce-api/view/products.php" class="nav-link">Products</a>
                <a href="/ecommerce-store/ecommerce-api/view/comments.php" class="nav-link">Reviews</a>
            </div>

            <div class="nav-center">
                <?php if (isset($_SESSION['username'])): ?>
                    <span class="welcome-text">Welcome, <?= htmlspecialchars($_SESSION['username']) ?></span>
                <?php endif; ?>
            </div>

            <div class="nav-right">
                <?php if (isset($_SESSION['user_id'])): ?>
                    <a href="/ecommerce-store/ecommerce-api/view/index.php?logout=1" class="logout-link">Logout</a>
                <?php else: ?>
                    <a href="/ecommerce-store/ecommerce-api/view/login.php" class="nav-link">Sign In</a>
                <?php endif; ?>
                
                <a href="/ecommerce-store/ecommerce-api/view/cart.php" class="cart-icon">
                    🛒
                    <?php if ($cartCount > 0): ?>
                        <span class="cart-count"><?= $cartCount ?></span>
                    <?php endif; ?>
                </a>
            </div>
        </nav>
    </header>

<main>
