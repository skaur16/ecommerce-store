<?php
session_start();
require_once __DIR__ . '/../config/database.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$orderId = $_GET['order_id'] ?? null;
if (!$orderId) {
    echo "Invalid order ID.";
    exit;
}

$database = new Database();
$db = $database->getConnection();

// Fetch order
$orderStmt = $db->prepare("SELECT * FROM orders WHERE orderID = :orderID AND userID = :userID");
$orderStmt->execute([':orderID' => $orderId, ':userID' => $_SESSION['user_id']]);
$order = $orderStmt->fetch();

if (!$order) {
    echo "Order not found.";
    exit;
}

// Fetch order items
$itemsStmt = $db->prepare("
    SELECT oi.*, p.description, p.image
    FROM order_items oi
    JOIN products p ON oi.productID = p.productID
    WHERE oi.orderID = :orderID
");
$itemsStmt->execute([':orderID' => $orderId]);
$orderItems = $itemsStmt->fetchAll();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Order Receipt</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f7f7f7;
            padding: 20px;
        }
        .container {
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
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        th, td {
            padding: 12px;
            text-align: center;
            border-bottom: 1px solid #eee;
        }
        th {
            background-color: #f0e9ff;
            color: #6B46C1;
        }
        .total-row td {
            font-weight: bold;
            font-size: 1.1em;
            border-top: 2px solid #6B46C1;
        }
        img {
            max-width: 60px;
            max-height: 70px;
        }
        .btn {
            background-color: #6B46C1;
            color: #fff;
            padding: 12px 24px;
            text-decoration: none;
            border-radius: 6px;
            display: inline-block;
            margin-top: 10px;
        }
        .btn:hover {
            background-color: #553c9a;
        }
        .download-btn {
            margin-left: 15px;
        }
    </style>
</head>
<body>
<?php include __DIR__ . '/header.php'; ?>

<div class="container">
    <h2>Order Receipt</h2>
    <p><strong>Order ID:</strong> <?= htmlspecialchars($order['orderID']) ?></p>
    <p><strong>Date:</strong> <?= htmlspecialchars($order['orderDate']) ?></p>
    <table>
        <thead>
            <tr>
                <th>Image</th>
                <th>Description</th>
                <th>Price</th>
                <th>Qty</th>
                <th>Subtotal</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($orderItems as $item): ?>
                <tr>
                    <td><img src="<?= htmlspecialchars($item['image']) ?>" alt="Product Image"></td>
                    <td><?= htmlspecialchars($item['description']) ?></td>
                    <td>$<?= number_format($item['price'], 2) ?></td>
                    <td><?= $item['quantity'] ?></td>
                    <td>$<?= number_format($item['price'] * $item['quantity'], 2) ?></td>
                </tr>
            <?php endforeach; ?>
            <tr class="total-row">
                <td colspan="4" style="text-align: right;">Total:</td>
                <td>$<?= number_format($order['totalAmount'], 2) ?></td>
            </tr>
        </tbody>
    </table>

    <a href="/ecommerce-store/ecommerce-api/view/index.php" class="btn">Back to Home</a>
    <a href="download_receipt.php?order_id=<?= urlencode($order['orderID']) ?>" class="btn download-btn">Download Receipt</a>
</div>

<?php include __DIR__ . '/footer.php'; ?>
</body>
</html>
