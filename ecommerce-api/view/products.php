<?php
session_start();

// Initialize guest cart if not exists
if (!isset($_SESSION['guest_cart'])) {
    $_SESSION['guest_cart'] = [];
}

require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../models/Product.php';
require_once __DIR__ . '/../models/Cart.php';

$database = new Database();
$db = $database->getConnection();
$productModel = new Product($db);
$cartModel = new Cart($db);

// Handle add to cart
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_to_cart'])) {
    $productId = intval($_POST['product_id']);
    $quantity = max(1, intval($_POST['quantity']));
    
    if (isset($_SESSION['user_id'])) {
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

// Get all products
$products = $productModel->getAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title>Products</title>
    <style>
        html, body {
            height: 100%;
            margin: 0;
            padding: 0;
        }
        body {
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            font-family: 'Segoe UI', Arial, sans-serif;
            background: #ffffff;
            color: #333333;
        }
        main {
            flex: 1 0 auto;
            padding: 20px;
        }
        .products-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
            gap: 20px;
            padding: 20px;
        }
        .product-card {
            background: #ffffff;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            padding: 15px;
            display: flex;
            flex-direction: column;
            align-items: center;
            text-align: center;
        }
        .product-image {
            width: 200px;
            height: 250px;
            object-fit: contain;
            margin-bottom: 15px;
            border-radius: 6px;
            border: 1px solid #eaeaea;
            background: #ffffff;
        }
        .product-description {
            font-size: 1.1em;
            margin-bottom: 10px;
            color: #333333;
        }
        .product-price {
            font-size: 1.2em;
            font-weight: bold;
            color: #6B46C1;
            margin-bottom: 15px;
        }
        .add-to-cart-form {
            display: flex;
            align-items: center;
            gap: 10px;
        }
        input[type="number"] {
            width: 60px;
            padding: 6px;
            border-radius: 4px;
            border: 1px solid #eaeaea;
            background: #ffffff;
            color: #333333;
        }
        button {
            background: #6B46C1;
            color: #ffffff;
            border: none;
            padding: 8px 12px;
            border-radius: 5px;
            cursor: pointer;
            font-weight: bold;
        }
        button:hover {
            background: #553C9A;
        }
        .cart-count {
            background: #FFC300;
            color: #333333;
            padding: 4px 8px;
            border-radius: 12px;
            font-size: 0.9em;
            margin-left: 5px;
        }
    </style>
</head>
<body>
<?php include __DIR__ . '/header.php'; ?>

<main>
    <h1>Our Products</h1>
    
    <div class="products-grid">
        <?php foreach ($products as $product): ?>
        <div class="product-card">
            <img src="<?= htmlspecialchars($product['image']) ?>" alt="<?= htmlspecialchars($product['description']) ?>" class="product-image" />
            <div class="product-description"><?= htmlspecialchars($product['description']) ?></div>
            <div class="product-price">$<?= number_format($product['price'], 2) ?></div>
            <form method="post" action="products.php" class="add-to-cart-form">
                <input type="hidden" name="product_id" value="<?= $product['productID'] ?>" />
                <input type="number" name="quantity" value="1" min="1" />
                <button type="submit" name="add_to_cart">Add to Cart</button>
            </form>
        </div>
        <?php endforeach; ?>
    </div>
</main>

<?php include __DIR__ . '/footer.php'; ?>
</body>
</html>

