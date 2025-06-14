<?php
session_start();
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../models/Product.php';
require_once __DIR__ . '/../models/Cart.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$database = new Database();
$db = $database->getConnection();
$productModel = new Product($db);
$cartModel = new Cart($db);

$userId = $_SESSION['user_id'];
$cartItems = $cartModel->getUserCart($userId);

$total = 0;
foreach ($cartItems as $item) {
    $total += $item['price'] * $item['quantity'];
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['confirm_purchase'])) {
    try {
        $db->beginTransaction();

        // Insert into orders table
        $orderStmt = $db->prepare("INSERT INTO orders (userID, totalAmount) VALUES (:userID, :totalAmount)");
        $orderStmt->execute([
            ':userID' => $userId,
            ':totalAmount' => $total
        ]);
        $orderId = $db->lastInsertId();

        // Insert into order_items
        $itemStmt = $db->prepare("INSERT INTO order_items (orderID, productID, quantity, price) VALUES (:orderID, :productID, :quantity, :price)");
        foreach ($cartItems as $item) {
            $itemStmt->execute([
                ':orderID' => $orderId,
                ':productID' => $item['productID'],
                ':quantity' => $item['quantity'],
                ':price' => $item['price']
            ]);
        }

        // Clear user's cart
        $cartModel->clearUserCart($userId);

        $db->commit();

        // Redirect to success page
        header("Location: order_success.php?order_id=" . $orderId);
        exit;

    } catch (Exception $e) {
        $db->rollBack();
        echo "Failed to complete order: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Checkout</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f7f7f7;
            padding: 20px;
        }
        .checkout-container {
            max-width: 800px;
            margin: auto;
            background: #fff;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        h2 {
            color: #6B46C1;
            margin-bottom: 24px;
        }
        table {
            width: 100%;
            margin-bottom: 20px;
            border-collapse: collapse;
        }
        th, td {
            padding: 12px;
            border-bottom: 1px solid #eee;
            text-align: center;
        }
        .total {
            font-weight: bold;
            font-size: 1.2em;
            text-align: right;
        }
        .confirm-btn {
            background: #28a745;
            color: #fff;
            padding: 14px 24px;
            border: none;
            border-radius: 6px;
            font-size: 1em;
            cursor: pointer;
        }
        .confirm-btn:hover {
            background: #218838;
        }
    </style>
</head>
<body>
<?php include __DIR__ . '/header.php'; ?>

<div class="checkout-container">
    <h2>Order Summary</h2>

    <?php if (count($cartItems) === 0): ?>
        <p>Your cart is empty. <a href="products.php">Shop now</a></p>
    <?php else: ?>
        <table>
            <thead>
                <tr>
                    <th>Product</th>
                    <th>Description</th>
                    <th>Price</th>
                    <th>Quantity</th>
                    <th>Subtotal</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($cartItems as $item): ?>
                    <tr>
                        <td><img src="<?= htmlspecialchars($item['image']) ?>" width="60" height="70" /></td>
                        <td><?= htmlspecialchars($item['description']) ?></td>
                        <td>$<?= number_format($item['price'], 2) ?></td>
                        <td><?= $item['quantity'] ?></td>
                        <td>$<?= number_format($item['price'] * $item['quantity'], 2) ?></td>
                    </tr>
                <?php endforeach; ?>
                <tr>
                    <td colspan="4" class="total">Total:</td>
                    <td><strong>$<?= number_format($total, 2) ?></strong></td>
                </tr>
            </tbody>
        </table>

        <form method="post">
            <button type="submit" name="confirm_purchase" class="confirm-btn">Confirm Purchase</button>
        </form>
    <?php endif; ?>
</div>

<?php include __DIR__ . '/footer.php'; ?>
</body>
</html>
