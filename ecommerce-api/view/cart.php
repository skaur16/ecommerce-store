<?php include __DIR__ . '/header.php'; ?>
<?php
session_start();
// if (!isset($_SESSION['user_id'])) {
//     header('Location: login.php');
//     exit;
// }

$userId = 1; // For testing purposes, replace with actual user ID from session
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../models/Product.php';
require_once __DIR__ . '/../models/Cart.php';

$database = new Database();
$db = $database->getConnection(); // Your DB connection function
$productModel = new Product($db);
$cartModel = new Cart($db);
//$userId = $_SESSION['user_id'];

// Handle form submissions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['add_to_cart'])) {
        $productId = intval($_POST['product_id']);
        $quantity = max(1, intval($_POST['quantity']));
        $cartModel->addToCart($userId, $productId, $quantity);
    }

    if (isset($_POST['update_quantity'])) {
        $productId = intval($_POST['product_id']);
        $quantity = intval($_POST['quantity']);
        $cartModel->updateQuantity($userId, $productId, $quantity);
    }

    if (isset($_POST['remove_item'])) {
        $productId = intval($_POST['product_id']);
        $cartModel->removeItem($userId, $productId);
    }
}

// Fetch user cart items
$cartItemsStmt = $cartModel->getUserCart($userId);
$cartItems = $cartItemsStmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title>Your Cart</title>
    <style>
        body {
            font-family: 'Segoe UI', Arial, sans-serif;
            background: #000814;
            color: #FFD60A;
            padding: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        th, td {
            padding: 12px;
            border-bottom: 1px solid #FFC300;
            text-align: center;
        }
        img {
            width: 80px;
            height: 100px;
            object-fit: contain;
            border-radius: 6px;
            border: 1px solid #003566;
            background: #003566;
        }
        input[type="number"] {
            width: 60px;
            padding: 6px;
            border-radius: 4px;
            border: 1px solid #FFC300;
            background: #003566;
            color: #FFD60A;
        }
        button {
            background: #FFC300;
            color: #001d3d;
            border: none;
            padding: 8px 12px;
            border-radius: 5px;
            cursor: pointer;
            font-weight: bold;
        }
        button:hover {
            background: #FFD60A;
            color: #000814;
        }
        .total-row {
            font-size: 1.2em;
            font-weight: bold;
            color: #FFC300;
        }
    </style>
</head>
<body>

<h1>Your Shopping Cart</h1>

<?php if (count($cartItems) === 0): ?>
    <p>Your cart is empty. <a href="products.php" style="color:#FFC300;">Browse products</a></p>
<?php else: ?>
    <form method="post" action="cart.php">
        <table>
            <thead>
                <tr>
                    <th>Book</th>
                    <th>Description</th>
                    <th>Price</th>
                    <th>Quantity</th>
                    <th>Subtotal</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $total = 0;
                foreach ($cartItems as $item):
                    $product = $productModel->getById($item['productID']);
                    if (!$product) continue; // skip if product not found
                    $subtotal = $product['price'] * $item['quantity'];
                    $total += $subtotal;
                ?>
                <tr>
                    <td><img src="<?= htmlspecialchars($product['image']) ?>" alt="<?= htmlspecialchars($product['description']) ?>" /></td>
                    <td><?= htmlspecialchars($product['description']) ?></td>
                    <td>$<?= number_format($product['price'], 2) ?></td>
                    <td>
                        <form method="post" action="cart.php" style="display:inline;">
                            <input type="hidden" name="product_id" value="<?= $product['productID'] ?>" />
                            <input type="number" name="quantity" value="<?= $item['quantity'] ?>" min="1" />
                            <button type="submit" name="update_quantity">Update</button>
                        </form>
                    </td>
                    <td>$<?= number_format($subtotal, 2) ?></td>
                    <td>
                        <form method="post" action="cart.php" style="display:inline;">
                            <input type="hidden" name="product_id" value="<?= $product['productID'] ?>" />
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
    </form>
<?php endif; ?>

<p><a href="products.php" style="color:#FFC300;">Continue Shopping</a></p>

</body>
<?php include __DIR__ . '/footer.php'; ?>
</html>
