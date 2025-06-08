<?php
require_once __DIR__ . '/../controllers/ProductController.php';
require_once __DIR__ . '/../config/database.php';

$database = new Database();
$db = $database->getConnection();
$controller = new ProductController($db);
$product = $controller->getSingleProduct();
?>

<?php include __DIR__ . '/header.php'; ?>

<style>
    body {
        background: #000814;
        color: #FFD60A;
        font-family: 'Segoe UI', Arial, sans-serif;
        margin: 0;
        padding: 0;
    }
    h1, h2 {
        color: #FFC300;
    }
    a, a:visited {
        color: #FFD60A;
    }
    .hero-section {
        background: #001d3d;
        padding: 40px 0 0 0;
    }
    .hero-section img {
        border-radius: 12px;
        box-shadow: 0 4px 16px rgba(0,0,0,0.10);
        max-width: 100%;
        height: auto;
    }
    .why-shop {
        background: #003566;
        border-radius: 10px;
        margin: 0 auto 40px auto;
        padding: 30px 20px;
        color: #FFD60A;
        max-width: 800px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.10);
    }
    .why-shop h2 {
        color: #FFC300;
    }
    .why-shop ul li {
        margin-bottom: 10px;
    }
    .featured-books-title {
        color: #FFD60A;
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
        border: 1px solid #FFC300;
        padding: 18px 12px 20px 12px;
        text-align: center;
        margin-bottom: 20px;
        background: #001d3d;
        border-radius: 12px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.15);
        color: #FFD60A;
        transition: transform 0.2s, box-shadow 0.2s;
    }
    .book-card:hover {
        transform: translateY(-6px) scale(1.03);
        box-shadow: 0 6px 24px rgba(255, 195, 0, 0.15);
    }
    .book-card img {
        max-width: 100%;
        height: auto;
        border-radius: 8px;
        margin-bottom: 15px;
        border: 2px solid #FFC300;
        background: #003566;
    }
    .book-card h2 {
        color: #FFD60A;
        font-size: 1.2em;
        margin: 10px 0 8px 0;
    }
    .book-card p {
        margin: 6px 0;
        color: #FFD60A;
    }
    .book-card form input[type="number"] {
        width: 50px;
        padding: 4px;
        border-radius: 4px;
        border: 1px solid #FFC300;
        background: #003566;
        color: #FFD60A;
        margin-right: 8px;
    }
    .book-card form input[type="submit"] {
        background: #FFC300;
        color: #001d3d;
        border: none;
        border-radius: 4px;
        padding: 6px 16px;
        font-weight: bold;
        cursor: pointer;
        transition: background 0.2s;
    }
    .book-card form input[type="submit"]:hover {
        background: #FFD60A;
        color: #000814;
    }
</style>

<!-- Welcome Text -->
<h1 style="text-align:center; color:#FFC300;">Welcome to our online bookstore!</h1>
<p style="text-align:center; max-width:700px; margin: 0 auto 30px auto; color:#FFD60A;">
    Discover a curated selection of the latest and most popular books. Enjoy fast shipping and great prices!
</p>

<!-- Hero Image Centered -->
<div class="hero-section" style="display:flex; justify-content:center; align-items:center; margin-bottom:40px;">
    <img src="../images/hero.jpg" alt="Bookstore Hero" style="max-width:100%; height:auto;" />
</div>

<!-- Additional Content Start -->
<div style="text-align:center; max-width:800px; margin: 0 auto 40px auto; color:#FFD60A; font-size:1.15em;">
    <h2 style="color:#FFC300;">Why Shop With Us?</h2>
    <ul style="list-style:none; padding:0;">
        <li style="margin-bottom:10px;">
            <strong>Wide Selection:</strong> Choose from bestsellers, classics, and new releases across all genres.
        </li>
        <li style="margin-bottom:10px;">
            <strong>Fast Shipping:</strong> Get your books delivered quickly and reliably to your doorstep.
        </li>
        <li style="margin-bottom:10px;">
            <strong>Secure Shopping:</strong> Your data and payments are protected with industry-leading security.
        </li>
        <li style="margin-bottom:10px;">
            <strong>Friendly Support:</strong> Our team is here to help you with any questions or recommendations.
        </li>
    </ul>
    <p style="margin-top:20px;">
        <em>Start exploring our featured books below and find your next great read!</em>
    </p>
</div>
<!-- Additional Content End -->

<h1 class="featured-books-title" style="text-align:center;">Featured Books</h1>

<!-- 3 Picture Cards, No Description -->
<div class="books-row">
    <div class="book-card">
        <img src="../images/book1.jpeg" alt="Book 1" />
    </div>
    <div class="book-card">
        <img src="../images/book2.jpeg" alt="Book 2" />
    </div>
    <div class="book-card">
        <img src="../images/book2.jpeg" alt="Book 3" />
    </div>
</div>

<?php include __DIR__ . '/footer.php'; ?>
