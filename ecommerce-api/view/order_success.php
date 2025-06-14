<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$orderId = $_GET['order_id'] ?? null;
if (!$orderId) {
    echo "Invalid order.";
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Order Success</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f7f7f7;
            padding: 20px;
        }
        .success-container {
            max-width: 800px;
            margin: auto;
            background: #fff;
            padding: 40px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            text-align: center;
        }
        h2 {
            color: #28a745;
        }
        p {
            font-size: 1.1em;
            margin: 20px 0;
        }
        .btn {
            background-color: #6B46C1;
            color: #fff;
            padding: 12px 24px;
            border: none;
            border-radius: 6px;
            text-decoration: none;
            font-size: 1em;
            display: inline-block;
        }
        .btn:hover {
            background-color: #553c9a;
        }
    </style>
</head>
<body>
<?php include __DIR__ . '/header.php'; ?>
<div class="success-container">
    <h2>Thank You for Your Purchase!</h2>
    <p>Your order (ID: <?= htmlspecialchars($orderId) ?>) has been successfully placed.</p>
    <a href="receipt.php?order_id=<?= htmlspecialchars($orderId) ?>" class="btn">View Receipt</a>
</div>
<?php include __DIR__ . '/footer.php'; ?>
</body>
</html>
