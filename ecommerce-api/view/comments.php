<?php
// ✅ MUST be at the top to prevent output before session_start()
if (session_status() === PHP_SESSION_NONE) session_start();

// ✅ Redirect if not logged in
//  if (!isset($_SESSION['user_id'])) {
//      header("Location: /online_store/public/index.php?url=user/showLoginForm");
//     exit;
// }
?>




<?php include __DIR__ . '/header.php'; ?>

<style>
    /* ... [All your CSS remains unchanged] ... */
</style>


<h2>Welcome, <?= htmlspecialchars($_SESSION['username']) ?>!</h2>

<?php $product = ['productID' => 1, 'description' => 'Sample Product']; ?>

<h3>Product: <?= $product['description'] ?></h3>

<h3>Leave a Comment</h3>
<form action="?url=comment/add" method="POST" enctype="multipart/form-data">
    <input type="hidden" name="productID" value="<?= $product['productID'] ?>">

    <label>Rating:</label>
    <select name="rating" required>
        <option value="">Select</option>
        <option value="1">⭐</option>
        <option value="2">⭐⭐</option>
        <option value="3">⭐⭐⭐</option>
        <option value="4">⭐⭐⭐⭐</option>
        <option value="5">⭐⭐⭐⭐⭐</option>
    </select>

    <label>Comment:</label>
    <textarea name="text" required></textarea>

    <label>Upload Image:</label>
    <input type="file" name="image" accept="image/*">

    <input type="submit" value="Submit Comment">
</form>

<hr>

<h3>All Comments</h3>

<?php
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../models/Comment.php';

$db = (new Database())->getConnection();
$commentModel = new Comment($db);
$comments = $commentModel->getCommentsByProduct($product['productID']);
?>

<?php foreach ($comments as $comment): ?>
    <div class="comment-box">
        <strong><?= htmlspecialchars($comment['username']) ?></strong> rated: <?= str_repeat('⭐', $comment['rating']) ?><br>
        <p><?= nl2br(htmlspecialchars($comment['text'])) ?></p>
        <?php if (!empty($comment['image'])): ?>
            <img src="/online_store/public/<?= $comment['image'] ?>" alt="Comment Image">
        <?php endif; ?>
    </div>
<?php endforeach; ?>

<?php include __DIR__ . '/../footer.php'; ?>
