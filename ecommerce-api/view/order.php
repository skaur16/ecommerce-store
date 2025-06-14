<?php
session_start();
require_once __DIR__ . '/../config/database.php'; // Adjust if needed

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$userId = $_SESSION['user_id'];

$database = new Database();
$db = $database->getConnection();

// Fetch all orders by this user
$stmt = $db->prepare("SELECT * FROM orders WHERE userID = :userId ORDER BY orderDate DESC");
$stmt->execute([':userId' => $userId]);
$orders = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html>
<head>
    <title>My Orders</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f9f9f9;
            padding: 20px;
        }
        .container {
            max-width: 900px;
            margin: auto;
            background: #fff;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        h2 {
            color: #6B46C1;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 25px;
        }
        th, td {
            padding: 12px;
            border-bottom: 1px solid #ddd;
            text-align: center;
        }
        th {
            background: #f0e9ff;
            color: #6B46C1;
        }
        .btn {
            background-color: #6B46C1;
            color: white;
            padding: 8px 14px;
            text-decoration: none;
            border-radius: 5px;
        }
        .btn:hover {
            background-color: #553c9a;
        }
    </style>
</head>
<body>
<?php include 'header.php'; ?>

<div class="container">
    <h2>My Orders</h2>

    <?php if (count($orders) > 0): ?>
        <table>
            <thead>
                <tr>
                    <th>Order ID</th>
                    <th>Date</th>
                    <th>Total Amount</th>
                    <th>View Receipt</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($orders as $order): ?>
                    <tr>
                        <td><?= htmlspecialchars($order['orderID']) ?></td>
                        <td><?= htmlspecialchars($order['orderDate']) ?></td>
                        <td>$<?= number_format($order['totalAmount'], 2) ?></td>
                        <td><a class="btn" href="receipt.php?order_id=<?= urlencode($order['orderID']) ?>">View</a></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>No orders found.</p>
    <?php endif; ?>
</div>

<?php include 'footer.php'; ?>
</body>
</html>
