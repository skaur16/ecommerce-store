
<?php include __DIR__ . '/header.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Books</title>
    <style>
        body {
            font-family: 'Segoe UI', Arial, sans-serif;
            background: #000814;
            color: #FFD60A;
            padding: 20px;
        }

        h1 {
            color: #FFC300;
        }

        .books-row {
            display: flex;
            gap: 20px;
            flex-wrap: wrap;
            justify-content: center;
            margin-bottom: 30px;
        }

        .book-card {
            background: #001d3d;
            border-radius: 12px;
            box-shadow: 0 2px 10px rgba(0,8,20,0.15);
            width: 250px;
            overflow: hidden;
            text-align: center;
            padding: 18px 12px 20px 12px;
            transition: 0.3s ease;
            border: 1.5px solid #FFC300;
            color: #FFD60A;
        }

        .book-card:hover {
            transform: translateY(-8px) scale(1.03);
            box-shadow: 0 6px 24px rgba(255, 195, 0, 0.15);
        }

        .book-card img {
            width: 100%;
            height: 200px;
            object-fit: contain;
            border-radius: 8px;
            border: 2px solid #003566;
            background: #003566;
            margin-bottom: 12px;
        }

        .book-description {
            margin: 10px 0;
            color: #FFD60A;
            font-size: 1.08em;
        }

        .book-price {
            color: #FFC300;
            font-weight: bold;
            margin-bottom: 10px;
        }

        .book-card input[type="number"] {
            width: 60px;
            padding: 5px;
            margin-bottom: 10px;
            border-radius: 4px;
            border: 1px solid #FFC300;
            background: #003566;
            color: #FFD60A;
            font-size: 1em;
        }

        .add-to-cart-btn {
            background: #FFC300;
            color: #001d3d;
            padding: 8px 16px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-weight: bold;
            font-size: 1em;
            transition: background 0.2s, color 0.2s;
        }

        .add-to-cart-btn:hover {
            background: #FFD60A;
            color: #000814;
        }
    </style>
</head>
<body>

<h1 style="text-align:center;">Book Shop</h1>

<div class="books-row">
    <!-- Product 1 -->
    <div class="book-card">
        <img src="../images/book1.jpeg" alt="Book 1" />
        <p class="book-description">Daughter Of Man</p>
        <p class="book-price">$20.00</p>
        <input type="number" min="1" value="1" />
        <br>
        <button class="add-to-cart-btn">Add to Cart</button>
    </div>

    <!-- Product 2 -->
    <div class="book-card">
        <img src="../images/book2.jpeg" alt="Book 2" />
        <p class="book-description"> Fortress Blood</p>
        <p class="book-price">$18.50</p>
        <input type="number" min="1" value="1" />
        <br>
        <button class="add-to-cart-btn">Add to Cart</button>
    </div>

    <!-- Product 3 -->
    <div class="book-card">
        <img src="../images/book3.webp" alt="Book 3" />
        <p class="book-description">Call Avalon</p>
        <p class="book-price">$22.00</p>
        <input type="number" min="1" value="1" />
        <br>
        <button class="add-to-cart-btn">Add to Cart</button>
    </div>
</div>

 <!--New  Product Row -->
<div class="books-row">
    <!-- Product 4 -->
    <div class="book-card">
        <img src="../images/book4.webp" alt="Book 1" />
        <p class="book-description">Dune</p>
        <p class="book-price">$20.00</p>
        <input type="number" min="1" value="1" />
        <br>
        <button class="add-to-cart-btn">Add to Cart</button>
    </div>

    <!-- Product 5 -->
    <div class="book-card">
        <img src="../images/book5.webp" alt="Book 2" />
        <p class="book-description"> Diary Of a Martian</p>
        <p class="book-price">$18.50</p>
        <input type="number" min="1" value="1" />
        <br>
        <button class="add-to-cart-btn">Add to Cart</button>
    </div>

    <!-- Product 6 -->
    <div class="book-card">
        <img src="../images/book6.webp" alt="Book 3" />
        <p class="book-description"> Never Ending Sky</p>
        <p class="book-price">$22.00</p>
        <input type="number" min="1" value="1" />
        <br>
        <button class="add-to-cart-btn">Add to Cart</button>
    </div>
</div>

 <!--New  Product Row -->
<div class="books-row">
    <!-- Product 7 -->
    <div class="book-card">
        <img src="../images/book7.webp" alt="Book 1" />
        <p class="book-description"> The Spirit Demon</p>
        <p class="book-price">$20.00</p>
        <input type="number" min="1" value="1" />
        <br>
        <button class="add-to-cart-btn">Add to Cart</button>
    </div>

    <!-- Product 8 -->
    <div class="book-card">
        <img src="../images/book8.webp" alt="Book 2" />
        <p class="book-description"> Too Like The Lightening</p>
        <p class="book-price">$18.50</p>
        <input type="number" min="1" value="1" />
        <br>
        <button class="add-to-cart-btn">Add to Cart</button>
    </div>

    <!-- Product 3 -->
    <div class="book-card">
        <img src="../images/book9.webp" alt="Book 3" />
        <p class="book-description"> Pride And Prejudice</p>
        <p class="book-price">$22.00</p>
        <input type="number" min="1" value="1" />
        <br>
        <button class="add-to-cart-btn">Add to Cart</button>
    </div>
</div>

 <!--New  Product Row -->
<div class="books-row">
    <!-- Product 10 -->
    <div class="book-card">
        <img src="../images/book10.webp" alt="Book 1" />
        <p class="book-description"> Story Thieves</p>
        <p class="book-price">$20.00</p>
        <input type="number" min="1" value="1" />
        <br>
        <button class="add-to-cart-btn">Add to Cart</button>
    </div>

    <!-- Product 11 -->
    <div class="book-card">
        <img src="../images/book11.webp" alt="Book 2" />
        <p class="book-description"> Outer Space </p>
        <p class="book-price">$18.50</p>
        <input type="number" min="1" value="1" />
        <br>
        <button class="add-to-cart-btn">Add to Cart</button>
    </div>

    <!-- Product 12 -->
    <div class="book-card">
        <img src="../images/book12.webp" alt="Book 3" />
        <p class="book-description"> Soul</p>
        <p class="book-price">$22.00</p>
        <input type="number" min="1" value="1" />
        <br>
        <button class="add-to-cart-btn">Add to Cart</button>
    </div>
</div>

 <!--New  Product Row -->
<div class="books-row">
    <!-- Product 13 -->
    <div class="book-card">
        <img src="../images/book13.webp" alt="Book 1" />
        <p class="book-description"> Pulse</p>
        <p class="book-price">$20.00</p>
        <input type="number" min="1" value="1" />
        <br>
        <button class="add-to-cart-btn">Add to Cart</button>
    </div>

    <!-- Product 14 -->
    <div class="book-card">
        <img src="../images/book14.webp" alt="Book 2" />
        <p class="book-description"> The Alcazar</p>
        <p class="book-price">$18.50</p>
        <input type="number" min="1" value="1" />
        <br>
        <button class="add-to-cart-btn">Add to Cart</button>
    </div>

    <!-- Product 15 -->
    <div class="book-card">
        <img src="../images/book15.webp" alt="Book 3" />
        <p class="book-description"> Relic</p>
        <p class="book-price">$22.00</p>
        <input type="number" min="1" value="1" />
        <br>
        <button class="add-to-cart-btn">Add to Cart</button>
    </div>
</div>

</body>
</html>
