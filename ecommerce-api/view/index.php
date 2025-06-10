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

// Initialize guest cart if not exists
if (!isset($_SESSION['guest_cart'])) {
    $_SESSION['guest_cart'] = [];
}

// Handle add to cart
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_to_cart'])) {
    $productId = intval($_POST['product_id']);
    $quantity = max(1, intval($_POST['quantity']));
    
    if (isset($_SESSION['user_id'])) {
        require_once __DIR__ . '/../models/Cart.php';
        $cartModel = new Cart($db);
        $cartModel->addToCart($_SESSION['user_id'], $productId, $quantity);
    } else {
        if (isset($_SESSION['guest_cart'][$productId])) {
            $_SESSION['guest_cart'][$productId] += $quantity;
        } else {
            $_SESSION['guest_cart'][$productId] = $quantity;
        }
    }
    header('Location: cart.php');
    exit;
}
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

<!-- Featured Book -->
<?php if ($product): ?>
<div class="books-row">
    <div class="book-card">
        <img src="<?= htmlspecialchars($product['image']) ?>" alt="<?= htmlspecialchars($product['description']) ?>" />
        <h2><?= htmlspecialchars($product['description']) ?></h2>
        <p style="color:#6B46C1; font-weight:bold;">$<?= number_format($product['price'], 2) ?></p>
        <form method="post" action="index.php">
            <input type="hidden" name="product_id" value="<?= $product['productID'] ?>" />
            <input type="number" name="quantity" value="1" min="1" />
            <input type="submit" name="add_to_cart" value="Add to Cart" />
        </form>
    </div>
</div>
<?php endif; ?>

<!-- Why Shop With Us -->
<div class="why-shop">
    <h2>Why Shop With Us?</h2>
    <ul>
        <li>Wide selection of books across all genres</li>
        <li>Fast and reliable shipping</li>
        <li>Competitive prices</li>
        <li>Secure payment options</li>
        <li>Excellent customer service</li>
    </ul>
</div>

<!-- Features -->
<div class="features-container">
    <div class="feature-card">
        <div class="feature-icon">📚</div>
        <h3>Extensive Collection</h3>
        <p>Browse through thousands of titles across all genres</p>
    </div>
    <div class="feature-card">
        <div class="feature-icon">🚚</div>
        <h3>Fast Shipping</h3>
        <p>Get your books delivered quickly and safely</p>
    </div>
    <div class="feature-card">
        <div class="feature-icon">💰</div>
        <h3>Great Prices</h3>
        <p>Enjoy competitive prices and regular discounts</p>
    </div>
</div>

<?php include __DIR__ . '/footer.php'; ?>
