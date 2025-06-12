<?php
session_start();

require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../models/Product.php';
require_once __DIR__ . '/../models/Cart.php';

$database = new Database();
$db = $database->getConnection();
$productModel = new Product($db);
$cartModel = new Cart($db);

// Initialize guest cart if not exists
if (!isset($_SESSION['guest_cart'])) {
    $_SESSION['guest_cart'] = [];
}

// Handle form submissions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    error_log('CART POST: ' . print_r($_POST, true));
    $productId = intval($_POST['product_id'] ?? 0);
    $quantity = max(1, intval($_POST['quantity'] ?? 1));
    if (isset($_POST['update_quantity'])) {
        if (isset($_SESSION['user_id'])) {
            $cartModel->updateQuantity($_SESSION['user_id'], $productId, $quantity);
        } else {
            if ($quantity <= 0) {
                unset($_SESSION['guest_cart'][$productId]);
            } else {
                $_SESSION['guest_cart'][$productId] = $quantity;
            }
        }
        header('Location: cart.php');
        exit;
    }
    if (isset($_POST['remove_item'])) {
        if (isset($_SESSION['user_id'])) {
            $cartModel->removeItem($_SESSION['user_id'], $productId);
        } else {
            unset($_SESSION['guest_cart'][$productId]);
        }
        header('Location: cart.php');
        exit;
    }
}

// Fetch cart items
$cartItems = [];
$total = 0;
if (isset($_SESSION['user_id'])) {
    // Logged-in user: fetch from DB
    $cartData = $cartModel->getUserCart($_SESSION['user_id']);
    if ($cartData) {
        foreach ($cartData as $item) {
            $cartItems[] = [
                'productID' => $item['productID'],
                'description' => $item['description'],
                'image' => $item['image'],
                'price' => $item['price'],
                'shippingCost' => $item['shippingCost'],
                'cart_quantity' => $item['quantity'],
            ];
        }
    }
} else if (!empty($_SESSION['guest_cart'])) {
    // Guest user: fetch from session
    $productIds = array_keys($_SESSION['guest_cart']);
    if (count($productIds) > 0) {
        $placeholders = implode(',', array_fill(0, count($productIds), '?'));
        $query = "SELECT * FROM products WHERE productID IN ($placeholders)";
        $stmt = $db->prepare($query);
        $stmt->execute($productIds);
        $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
        foreach ($products as $product) {
            $cartItems[] = [
                'productID' => $product['productID'],
                'description' => $product['description'],
                'image' => $product['image'],
                'price' => $product['price'],
                'shippingCost' => $product['shippingCost'],
                'cart_quantity' => $_SESSION['guest_cart'][$product['productID']],
            ];
        }
    }
}

// Calculate total
foreach ($cartItems as &$item) {
    if (!isset($item['cart_quantity']) || $item['cart_quantity'] < 1) {
        $item['cart_quantity'] = 1;
    }
    $total += $item['price'] * $item['cart_quantity'];
}
unset($item); // break reference
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title>Your Cart</title>
    <style>
        body {
            background: #fff;
            color: #333;
            font-family: 'Segoe UI', Arial, sans-serif;
            margin: 0;
            padding: 0;
        }
        .cart-container {
            max-width: 1100px;
            margin: 40px auto;
            background: #fff;
            border-radius: 10px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.07);
            padding: 30px 24px 40px 24px;
        }
        h1 {
            color: #6B46C1;
            text-align: center;
            margin-bottom: 32px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 24px;
        }
        th, td {
            padding: 14px 10px;
            border-bottom: 1px solid #eaeaea;
            text-align: center;
        }
        th {
            background: #f8f9fa;
            color: #6B46C1;
            font-weight: 600;
        }
        img {
            width: 70px;
            height: 90px;
            object-fit: contain;
            border-radius: 6px;
            border: 1px solid #eaeaea;
            background: #fff;
        }
        input[type="number"] {
            width: 60px;
            padding: 7px;
            border-radius: 4px;
            border: 1px solid #eaeaea;
            background: #fff;
            color: #333;
        }
        button {
            background: #6B46C1;
            color: #fff;
            border: none;
            padding: 7px 14px;
            border-radius: 5px;
            cursor: pointer;
            font-weight: bold;
            margin-left: 4px;
        }
        button:hover {
            background: #553C9A;
        }
        .total-row {
            font-size: 1.1em;
            font-weight: bold;
            color: #6B46C1;
            background: #f8f9fa;
        }
        .checkout-btn {
            background: #FFC300;
            color: #333;
            padding: 12px 24px;
            font-size: 1.1em;
            margin-top: 20px;
            border-radius: 5px;
            text-decoration: none;
            display: inline-block;
        }
        .checkout-btn:hover {
            background: #E6B000;
        }
        .login-prompt {
            background: #f8f9fa;
            padding: 18px;
            border-radius: 8px;
            margin: 20px 0;
            text-align: center;
            border: 1px solid #eaeaea;
        }
        .empty-cart {
            text-align: center;
            padding: 40px 0;
            color: #666;
        }
        .empty-cart a {
            color: #6B46C1;
            text-decoration: none;
            font-weight: 600;
        }
        .empty-cart a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
<?php include __DIR__ . '/header.php'; ?>
<div class="cart-container">
    <h1>Your Shopping Cart</h1>
    <?php if (count($cartItems) === 0): ?>
        <div class="empty-cart">
            <p>Your cart is empty.</p>
            <p><a href="products.php">Browse our products</a> to add items to your cart.</p>
        </div>
    <?php else: ?>
        <table>
            <thead>
                <tr>
                    <th>Product</th>
                    <th>Description</th>
                    <th>Price</th>
                    <th>Quantity</th>
                    <th>Subtotal</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($cartItems as $item): ?>
                <tr>
                    <td><img src="<?= htmlspecialchars($item['image']) ?>" alt="<?= htmlspecialchars($item['description']) ?>" /></td>
                    <td><?= htmlspecialchars($item['description']) ?></td>
                    <td>$<?= number_format($item['price'], 2) ?></td>
                    <td>
                        <form method="post" action="cart.php" style="display:inline;">
                            <input type="hidden" name="product_id" value="<?= $item['productID'] ?>" />
                            <input type="number" name="quantity" value="<?= isset($item['cart_quantity']) ? $item['cart_quantity'] : 1 ?>" min="1" />
                            <button type="submit" name="update_quantity">Update</button>
                        </form>
                    </td>
                    <td>$<?= number_format($item['price'] * (isset($item['cart_quantity']) ? $item['cart_quantity'] : 1), 2) ?></td>
                    <td>
                        <form method="post" action="cart.php" style="display:inline;">
                            <input type="hidden" name="product_id" value="<?= $item['productID'] ?>" />
                            <button type="submit" name="remove_item" onclick="return confirm('Remove this item?');">Remove</button>
                        </form>
                    </td>
                </tr>
                <?php endforeach; ?>
                <tr class="total-row">
                    <td colspan="4" style="text-align:right;">Total:</td>
                    <td colspan="2">$<?= number_format($total, 2) ?></td>
                </tr>
            </tbody>
        </table>
        <?php if (!isset($_SESSION['user_id'])): ?>
            <div class="login-prompt">
                <p>To proceed with checkout, please <a href="login.php" style="color:#6B46C1;">log in</a> or <a href="register.php" style="color:#6B46C1;">create an account</a>.</p>
            </div>
        <?php else: ?>
            <div style="text-align: center;">
                <a href="checkout.php" class="checkout-btn">Proceed to Checkout</a>
            </div>
        <?php endif; ?>
    <?php endif; ?>
</div>
<?php include __DIR__ . '/footer.php'; ?>
</body>
</html> 