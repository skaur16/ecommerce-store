<?php
if (session_status() === PHP_SESSION_NONE) session_start();

// Handle login
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    require_once __DIR__ . '/../config/database.php';
    require_once __DIR__ . '/../models/User.php';

    $db = (new Database())->getConnection();
    $userModel = new User($db);

    $email = $_POST['email'];
    $password = $_POST['password'];

    $user = $userModel->login($email);

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['userID'];
        $_SESSION['username'] = $user['username'];
        header("Location: /ecommerce-store/ecommerce-api/view/index.php");
        exit;
    } else {
        $_SESSION['error'] = "Invalid email or password.";
        header("Location: /ecommerce-store/ecommerce-api/view/login.php");
        exit;
    }
}

require_once __DIR__ . '/../controllers/ProductController.php';
require_once __DIR__ . '/../config/database.php';

$database = new Database();
$db = $database->getConnection();
$controller = new ProductController($db);
$product = $controller->getSingleProduct();
?>

<?php include __DIR__ . '/header.php'; ?>

<style>
    body {
        background: #ffffff;
        color: #333333;
        font-family: 'Segoe UI', Arial, sans-serif;
        margin: 0;
        padding: 0;
    }
    h1, h2 {
        color: #6B46C1;
    }
    a, a:visited {
        color: #6B46C1;
    }
    .hero-section {
        background: #f8f9fa;
        padding: 40px 0 0 0;
    }
    .hero-section img {
        border-radius: 12px;
        box-shadow: 0 4px 16px rgba(0,0,0,0.08);
        max-width: 100%;
        height: auto;
    }
    .why-shop {
        background: #f8f9fa;
        border-radius: 10px;
        margin: 0 auto 40px auto;
        padding: 30px 20px;
        color: #333333;
        max-width: 800px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.05);
        border: 1px solid #eaeaea;
    }
    .why-shop h2 {
        color: #6B46C1;
    }
    .why-shop ul li {
        margin-bottom: 10px;
    }
    .featured-books-title {
        color: #6B46C1;
        margin-bottom: 30px;
    }
    .books-row {
        display: flex;
        flex-wrap: wrap;
        justify-content: center;
        gap: 20px;
        max-width: 1000px;
        margin: 0 auto 40px auto;
    }
    .book-card {
        flex: 0 0 30%;
        box-sizing: border-box;
        border: 1px solid #eaeaea;
        padding: 18px 12px 20px 12px;
        text-align: center;
        margin-bottom: 20px;
        background: #ffffff;
        border-radius: 12px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.05);
        color: #333333;
        transition: transform 0.2s, box-shadow 0.2s;
    }
    .book-card:hover {
        transform: translateY(-6px) scale(1.03);
        box-shadow: 0 6px 24px rgba(0,0,0,0.08);
    }
    .book-card img {
        max-width: 100%;
        height: auto;
        border-radius: 8px;
        margin-bottom: 15px;
        border: 1px solid #eaeaea;
        background: #ffffff;
    }
    .book-card h2 {
        color: #6B46C1;
        font-size: 1.2em;
        margin: 10px 0 8px 0;
    }
    .book-card p {
        margin: 6px 0;
        color: #333333;
    }
    .book-card form input[type="number"] {
        width: 50px;
        padding: 4px;
        border-radius: 4px;
        border: 1px solid #eaeaea;
        background: #ffffff;
        color: #333333;
        margin-right: 8px;
    }
    .book-card form input[type="submit"] {
        background: #6B46C1;
        color: #ffffff;
        border: none;
        border-radius: 4px;
        padding: 6px 16px;
        font-weight: bold;
        cursor: pointer;
        transition: background 0.2s;
    }
    .book-card form input[type="submit"]:hover {
        background: #553C9A;
    }
    .features-container {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 24px;
        max-width: 1200px;
        margin: 0 auto 40px auto;
        padding: 0 20px;
    }

    .feature-card {
        background: #ffffff;
        border-radius: 12px;
        padding: 30px 20px;
        text-align: center;
        box-shadow: 0 2px 8px rgba(0,0,0,0.05);
        border: 1px solid #eaeaea;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .feature-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 6px 24px rgba(0,0,0,0.08);
    }

    .feature-icon {
        font-size: 2.5em;
        color: #6B46C1;
        margin-bottom: 20px;
    }

    .feature-card h3 {
        color: #6B46C1;
        margin: 0 0 15px 0;
        font-size: 1.3em;
    }

    .feature-card p {
        color: #666666;
        margin: 0;
        line-height: 1.6;
    }
</style>

<!-- Welcome Text -->
<h1 style="text-align:center; color:#6B46C1;">Welcome to our online bookstore!</h1>
<p style="text-align:center; max-width:700px; margin: 0 auto 30px auto; color:#333333;">
    Discover a curated selection of the latest and most popular books. Enjoy fast shipping and great prices!
</p>

<!-- Hero Image Centered -->
<div class="hero-section" style="display:flex; justify-content:center; align-items:center; margin-bottom:40px;">
    <img src="../images/hero.jpg" alt="Bookstore Hero" style="max-width:100%; height:auto;" />
</div>

<!-- Additional Content Start -->
<div style="text-align:center; max-width:1200px; margin: 0 auto 40px auto; color:#333333;">
    <h2 style="color:#4a90e2; margin-bottom: 40px;">Why Choose Our Cards?</h2>
    
    <div class="features-container">
        <div class="feature-card">
            <i class="fas fa-gem feature-icon"></i>
            <h3>Premium Quality</h3>
            <p>Our cards are crafted with high-quality materials and exquisite designs that stand out.</p>
        </div>

        <div class="feature-card">
            <i class="fas fa-truck feature-icon"></i>
            <h3>Express Delivery</h3>
            <p>Get your cards delivered to your doorstep with our fast and reliable shipping service.</p>
        </div>

        <div class="feature-card">
            <i class="fas fa-shield-alt feature-icon"></i>
            <h3>Secure Transactions</h3>
            <p>Shop with confidence knowing your payments and personal information are protected.</p>
        </div>

        <div class="feature-card">
            <i class="fas fa-headset feature-icon"></i>
            <h3>Personalized Service</h3>
            <p>Our team is dedicated to helping you find the perfect card for any occasion.</p>
        </div>
    </div>

    <p style="margin-top:30px; font-size:1.15em;">
        <em>Browse our collection of beautiful cards below and find the perfect one for your special moments!</em>
    </p>
</div>
<!-- Additional Content End -->

<h1 class="featured-books-title" style="text-align:center;">Featured Books</h1>

<!-- 3 Picture Cards, No Description -->
<div class="books-row">
    <div class="book-card">
        <img src="../images/book6.webp" alt="Book 1" />
    </div>
    <div class="book-card">
        <img src="../images/book11.webp" alt="Book 2" />
    </div>
    <div class="book-card">
        <img src="../images/book10.webp" alt="Book 3" />
    </div>
</div>

<?php include __DIR__ . '/footer.php'; ?>
