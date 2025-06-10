<?php
require_once '../config/Database.php';
require_once '../models/Comment.php';
require_once '../models/Product.php';

session_start();

$database = new Database();
$db = $database->getConnection();
$comment = new Comment($db);
$product = new Product($db);

// Get product ID from URL
$productId = isset($_GET['id']) ? $_GET['id'] : null;

// Handle comment submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_SESSION['user_id']) && $productId) {
    $rating = $_POST['rating'];
    $text = $_POST['text'];
    $image = null;

    // Handle image upload
    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $uploadDir = '../uploads/';
        $fileName = uniqid() . '_' . basename($_FILES['image']['name']);
        $uploadFile = $uploadDir . $fileName;

        if (move_uploaded_file($_FILES['image']['tmp_name'], $uploadFile)) {
            $image = $fileName;
        }
    }

    $comment->addComment($productId, $_SESSION['user_id'], $rating, $text, $image);
    
    // Redirect with a flag to highlight the new review
    header("Location: ?page=comments&id=" . $productId . "&new_review=1");
    exit();
}

// Get all products
$products = $product->getAll();

// Get specific product data if ID is provided
if ($productId) {
    $productData = $product->getProductById($productId);
    if (!$productData) {
        header("Location: index.php");
        exit();
    }
    // Get comments for the selected product
    $comments = $comment->getCommentsByProductId($productId);
} else {
    $comments = [];
}

include 'header.php';
?>

<style>
    .container {
        max-width: 1400px;
        margin: 0 auto;
        padding: 20px;
    }

    .products-grid {
        display: grid;
        grid-template-columns: repeat(6, 1fr);
        gap: 15px;
        margin-top: 20px;
    }

    .product-card {
        background: white;
        border-radius: 12px;
        padding: 15px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        text-align: center;
        transition: transform 0.2s;
        cursor: pointer;
        text-decoration: none;
        color: inherit;
        position: relative;
    }

    .product-card:hover {
        transform: translateY(-5px);
    }

    .product-card.selected {
        border: 2px solid #6B46C1;
        background: #f8f5ff;
    }

    .selected-label {
        position: absolute;
        top: -10px;
        left: 50%;
        transform: translateX(-50%);
        background: #6B46C1;
        color: white;
        padding: 4px 12px;
        border-radius: 12px;
        font-size: 0.8em;
        font-weight: 500;
        box-shadow: 0 2px 5px rgba(0,0,0,0.1);
    }

    .product-card img {
        width: 120px;
        height: 160px;
        object-fit: cover;
        border-radius: 8px;
        margin-bottom: 10px;
    }

    .product-card h3 {
        color: #333;
        margin: 0 0 8px 0;
        font-size: 0.9em;
        line-height: 1.3;
        height: 2.6em;
        overflow: hidden;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
    }

    .rating {
        color: #ffc107;
        font-size: 1.1em;
        margin-bottom: 5px;
    }

    .rating span {
        color: #666;
        font-size: 0.8em;
        margin-left: 5px;
    }

    .page-title {
        color: #6B46C1;
        text-align: center;
        margin-bottom: 30px;
    }

    .review-section {
        margin-top: 40px;
        padding-top: 20px;
        border-top: 1px solid #eee;
    }

    .review-form {
        background: white;
        padding: 30px;
        border-radius: 12px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        margin-bottom: 30px;
        max-width: 800px;
        margin-left: auto;
        margin-right: auto;
    }

    .sign-in-prompt {
        background: #f8f5ff;
        padding: 30px;
        border-radius: 12px;
        text-align: center;
        margin-bottom: 30px;
        max-width: 800px;
        margin-left: auto;
        margin-right: auto;
    }

    .sign-in-prompt h3 {
        color: #6B46C1;
        margin: 0 0 15px 0;
        font-size: 1.5em;
    }

    .sign-in-prompt p {
        color: #666;
        margin: 0 0 20px 0;
    }

    .sign-in-btn {
        display: inline-block;
        background: #6B46C1;
        color: white;
        text-decoration: none;
        padding: 10px 25px;
        border-radius: 8px;
        font-weight: 500;
        transition: all 0.2s;
    }

    .sign-in-btn:hover {
        background: #553C9A;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(107, 70, 193, 0.2);
    }

    .review-form h3 {
        color: #333;
        margin: 0 0 25px 0;
        font-size: 1.5em;
        text-align: center;
        position: relative;
        padding-bottom: 15px;
    }

    .review-form h3:after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 50%;
        transform: translateX(-50%);
        width: 60px;
        height: 3px;
        background: #6B46C1;
        border-radius: 2px;
    }

    .form-group {
        margin-bottom: 25px;
    }

    .form-group label {
        display: block;
        margin-bottom: 10px;
        color: #333;
        font-weight: 500;
        font-size: 1.1em;
    }

    .rating-input {
        display: flex;
        flex-direction: row-reverse;
        gap: 8px;
        justify-content: center;
        margin: 15px 0;
    }

    .rating-input input {
        display: none;
    }

    .rating-input label {
        font-size: 2.5em;
        color: #ddd;
        cursor: pointer;
        transition: all 0.2s;
        padding: 5px;
    }

    .rating-input input:checked ~ label,
    .rating-input label:hover,
    .rating-input label:hover ~ label {
        color: #ffc107;
        transform: scale(1.1);
    }

    .rating-input label:hover {
        transform: scale(1.2);
    }

    textarea {
        width: 100%;
        min-height: 120px;
        padding: 15px;
        border: 2px solid #eee;
        border-radius: 12px;
        resize: vertical;
        font-size: 1em;
        line-height: 1.5;
        transition: border-color 0.2s;
    }

    textarea:focus {
        outline: none;
        border-color: #6B46C1;
    }

    .image-upload {
        border: 2px dashed #ddd;
        border-radius: 12px;
        padding: 20px;
        text-align: center;
        cursor: pointer;
        transition: all 0.2s;
        position: relative;
    }

    .image-upload:hover {
        border-color: #6B46C1;
        background: #f8f5ff;
    }

    .image-upload input[type="file"] {
        display: none;
    }

    .image-upload label {
        display: block;
        cursor: pointer;
        color: #666;
    }

    .image-upload i {
        font-size: 2em;
        color: #6B46C1;
        margin-bottom: 10px;
    }

    .image-preview {
        margin-top: 15px;
        display: none;
    }

    .image-preview img {
        max-width: 200px;
        max-height: 200px;
        border-radius: 8px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    }

    .remove-image {
        display: inline-block;
        margin-top: 10px;
        color: #dc3545;
        cursor: pointer;
        font-size: 0.9em;
        text-decoration: underline;
    }

    .remove-image:hover {
        color: #c82333;
    }

    .submit-btn {
        background: #6B46C1;
        color: white;
        border: none;
        padding: 12px 30px;
        border-radius: 8px;
        cursor: pointer;
        font-weight: 500;
        font-size: 1.1em;
        transition: all 0.2s;
        display: block;
        width: 200px;
        margin: 30px auto 0;
        text-align: center;
    }

    .submit-btn:hover {
        background: #553C9A;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(107, 70, 193, 0.2);
    }

    .reviews-grid {
        display: flex;
        flex-direction: column;
        gap: 20px;
    }

    .review-card {
        background: white;
        border-radius: 12px;
        padding: 20px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        transition: all 0.3s ease;
    }

    .review-card.new-review {
        animation: highlightNew 2s ease-out;
    }

    @keyframes highlightNew {
        0% {
            background: #f8f5ff;
            transform: translateY(-10px);
            opacity: 0;
        }
        100% {
            background: white;
            transform: translateY(0);
            opacity: 1;
        }
    }

    .review-header {
        display: flex;
        align-items: center;
        gap: 15px;
        margin-bottom: 15px;
    }

    .user-avatar {
        width: 40px;
        height: 40px;
        background: #6B46C1;
        color: white;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: bold;
        font-size: 1.2em;
    }

    .review-content {
        flex: 1;
    }

    .reviewer-name {
        font-weight: bold;
        color: #333;
        margin-bottom: 5px;
    }

    .review-rating {
        color: #ffc107;
        font-size: 1.1em;
        margin-bottom: 5px;
    }

    .review-text {
        color: #666;
        margin: 0;
        line-height: 1.5;
    }

    .review-image-container {
        margin-top: 15px;
        width: 200px;
        height: 200px;
        border-radius: 8px;
        overflow: hidden;
    }

    .review-image {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .no-reviews {
        text-align: center;
        padding: 40px;
        background: white;
        border-radius: 12px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.05);
    }

    .no-reviews p {
        color: #666;
        margin: 0;
    }

    @media (max-width: 1200px) {
        .products-grid {
            grid-template-columns: repeat(4, 1fr);
        }
    }

    @media (max-width: 768px) {
        .products-grid {
            grid-template-columns: repeat(2, 1fr);
        }
    }
</style>

<div class="container">
    <h1 class="page-title">Select a Book to Review</h1>
    
    <div class="products-grid">
        <?php foreach ($products as $p): 
            $productComments = $comment->getCommentsByProductId($p['productID']);
            $avgRating = 0;
            if (!empty($productComments)) {
                $totalRating = array_sum(array_column($productComments, 'rating'));
                $avgRating = $totalRating / count($productComments);
            }
            $isSelected = $productId == $p['productID'];
        ?>
            <a href="?page=comments&id=<?= $p['productID'] ?>" class="product-card <?= $isSelected ? 'selected' : '' ?>">
                <?php if ($isSelected): ?>
                    <div class="selected-label">Selected Book</div>
                <?php endif; ?>
                <img src="<?= htmlspecialchars($p['image']) ?>" alt="<?= htmlspecialchars($p['description']) ?>">
                <h3><?= htmlspecialchars($p['description']) ?></h3>
                <div class="rating">
                    <?= str_repeat('★', round($avgRating)) . str_repeat('☆', 5 - round($avgRating)) ?>
                    <span>(<?= number_format($avgRating, 1) ?> / 5)</span>
                </div>
            </a>
        <?php endforeach; ?>
    </div>

    <?php if ($productId): ?>
        <div class="review-section">
            <?php if (isset($_SESSION['user_id'])): ?>
                <div class="review-form">
                    <h3>Write a Review</h3>
                    <form action="?page=comments&id=<?= $productId ?>" method="POST" enctype="multipart/form-data">
                        <div class="form-group">
                            <label>How would you rate this book?</label>
                            <div class="rating-input">
                                <?php for($i = 5; $i >= 1; $i--): ?>
                                    <input type="radio" name="rating" value="<?= $i ?>" id="star<?= $i ?>" required>
                                    <label for="star<?= $i ?>">★</label>
                                <?php endfor; ?>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label for="text">Share your thoughts about this book</label>
                            <textarea name="text" id="text" placeholder="Write your review here..." required></textarea>
                        </div>
                        
                        <div class="form-group">
                            <label>Add a photo to your review (optional)</label>
                            <div class="image-upload">
                                <input type="file" name="image" id="image" accept="image/*" onchange="previewImage(this)">
                                <label for="image">
                                    <i>📷</i>
                                    <div>Click to upload an image</div>
                                    <small>or drag and drop</small>
                                </label>
                                <div class="image-preview" id="imagePreview">
                                    <img id="previewImg" src="" alt="Preview">
                                    <div class="remove-image" onclick="removeImage()">Remove image</div>
                                </div>
                            </div>
                        </div>
                        
                        <button type="submit" class="submit-btn">Submit Review</button>
                    </form>
                </div>
            <?php else: ?>
                <div class="sign-in-prompt">
                    <h3>Want to share your thoughts?</h3>
                    <p>Sign in to write a review for this book.</p>
                    <a href="signin.php" class="sign-in-btn">Sign In</a>
                </div>
            <?php endif; ?>

            <div class="reviews-grid">
                <?php if (empty($comments)): ?>
                    <div class="no-reviews">
                        <p>No reviews yet. Be the first to review this book!</p>
                    </div>
                <?php else: ?>
                    <?php foreach ($comments as $index => $c): 
                        $isNewReview = isset($_GET['new_review']) && $index === 0;
                    ?>
                        <div class="review-card <?= $isNewReview ? 'new-review' : '' ?>">
                            <div class="review-header">
                                <div class="user-avatar">
                                    <?= strtoupper(substr($c['username'], 0, 1)) ?>
                                </div>
                                <div class="review-content">
                                    <div class="reviewer-name"><?= htmlspecialchars($c['username']) ?></div>
                                    <div class="review-rating">
                                        <?= str_repeat('★', $c['rating']) . str_repeat('☆', 5 - $c['rating']) ?>
                                    </div>
                                </div>
                            </div>
                            <p class="review-text"><?= htmlspecialchars($c['text']) ?></p>
                            <?php if ($c['image']): ?>
                                <div class="review-image-container">
                                    <img src="../uploads/<?= htmlspecialchars($c['image']) ?>" alt="Review image" class="review-image">
                                </div>
                            <?php endif; ?>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>
    <?php endif; ?>
</div>

<script>
function previewImage(input) {
    const preview = document.getElementById('imagePreview');
    const previewImg = document.getElementById('previewImg');
    
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        
        reader.onload = function(e) {
            previewImg.src = e.target.result;
            preview.style.display = 'block';
        }
        
        reader.readAsDataURL(input.files[0]);
    }
}

function removeImage() {
    const input = document.getElementById('image');
    const preview = document.getElementById('imagePreview');
    const previewImg = document.getElementById('previewImg');
    
    input.value = '';
    previewImg.src = '';
    preview.style.display = 'none';
}
</script>

<?php include 'footer.php'; ?>
