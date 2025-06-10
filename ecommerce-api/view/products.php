<?php include __DIR__ . '/header.php'; ?>

<style>
    h1 {
        color: #6B46C1;
        margin-bottom: 40px;
        text-align: center;
        font-size: 2em;
        position: relative;
        padding-bottom: 15px;
    }

    h1:after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 50%;
        transform: translateX(-50%);
        width: 100px;
        height: 3px;
        background: #6B46C1;
        border-radius: 2px;
    }

    .books-row {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 25px;
        margin-bottom: 40px;
        padding: 0 20px;
    }

    .book-card {
        background: #ffffff;
        border-radius: 15px;
        box-shadow: 0 4px 15px rgba(0,0,0,0.08);
        overflow: hidden;
        transition: all 0.3s ease;
        position: relative;
        display: flex;
        flex-direction: column;
    }

    .book-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 8px 25px rgba(0,0,0,0.12);
    }

    .book-image-container {
        position: relative;
        width: 100%;
        height: 280px;
        overflow: hidden;
    }

    .book-card img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.5s ease;
    }

    .book-card:hover img {
        transform: scale(1.1);
    }

    .book-content {
        padding: 15px;
        display: flex;
        flex-direction: column;
        gap: 8px;
        background: #ffffff;
    }

    .book-description {
        color: #333333;
        font-size: 0.95em;
        font-weight: normal;
        margin: 0;
        line-height: 1.3;
    }

    .book-price {
        color: #6B46C1;
        font-weight: normal;
        font-size: 1em;
        margin: 0;
    }

    .book-controls {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 10px;
        margin-top: 5px;
        width: 100%;
    }

    .quantity-control {
        display: flex;
        align-items: center;
        gap: 5px;
        background: #f8f9fa;
        padding: 5px;
        border-radius: 6px;
        border: 1px solid #eaeaea;
        flex: 1;
        justify-content: center;
    }

    .book-card input[type="number"] {
        width: 40px;
        padding: 5px;
        border: none;
        background: transparent;
        color: #333333;
        font-size: 0.9em;
        text-align: center;
    }

    .book-card input[type="number"]:focus {
        outline: none;
    }

    .add-to-cart-btn {
        background: #6B46C1;
        color: #ffffff;
        border: none;
        width: 40px;
        height: 40px;
        border-radius: 6px;
        cursor: pointer;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.2em;
        flex-shrink: 0;
    }

    .add-to-cart-btn::before {
        content: '🛒';
    }

    .add-to-cart-btn:hover {
        background: #553C9A;
        transform: translateY(-2px);
    }

    .add-to-cart-btn:active {
        transform: translateY(0);
    }

    @media (max-width: 1200px) {
        .books-row {
            grid-template-columns: repeat(3, 1fr);
        }
    }

    @media (max-width: 900px) {
        .books-row {
            grid-template-columns: repeat(2, 1fr);
        }
    }

    @media (max-width: 600px) {
        .books-row {
            grid-template-columns: 1fr;
        }
    }
</style>

<h1>Our Products</h1>

<div class="books-row">
    <!-- Product 1 -->
    <div class="book-card">
        <div class="book-image-container">
            <img src="../images/book1.jpeg" alt="Book 1" />
        </div>
        <div class="book-content">
            <p class="book-description">Daughter Of Man</p>
            <p class="book-price">$20.00</p>
            <div class="book-controls">
                <div class="quantity-control">
                    <input type="number" min="1" value="1" />
                </div>
                <button class="add-to-cart-btn" title="Add to Cart"></button>
            </div>
        </div>
    </div>

    <!-- Product 2 -->
    <div class="book-card">
        <div class="book-image-container">
            <img src="../images/book2.jpeg" alt="Book 2" />
        </div>
        <div class="book-content">
            <p class="book-description">Fortress Blood</p>
            <p class="book-price">$18.50</p>
            <div class="book-controls">
                <div class="quantity-control">
                    <input type="number" min="1" value="1" />
                </div>
                <button class="add-to-cart-btn" title="Add to Cart"></button>
            </div>
        </div>
    </div>

    <!-- Product 3 -->
    <div class="book-card">
        <div class="book-image-container">
            <img src="../images/book3.webp" alt="Book 3" />
        </div>
        <div class="book-content">
            <p class="book-description">Call Avalon</p>
            <p class="book-price">$22.00</p>
            <div class="book-controls">
                <div class="quantity-control">
                    <input type="number" min="1" value="1" />
                </div>
                <button class="add-to-cart-btn" title="Add to Cart"></button>
            </div>
        </div>
    </div>

    <!-- Product 4 -->
    <div class="book-card">
        <div class="book-image-container">
            <img src="../images/book4.webp" alt="Book 4" />
        </div>
        <div class="book-content">
            <p class="book-description">Dune</p>
            <p class="book-price">$20.00</p>
            <div class="book-controls">
                <div class="quantity-control">
                    <input type="number" min="1" value="1" />
                </div>
                <button class="add-to-cart-btn" title="Add to Cart"></button>
            </div>
        </div>
    </div>
</div>

<div class="books-row">
    <!-- Product 5 -->
    <div class="book-card">
        <div class="book-image-container">
            <img src="../images/book5.webp" alt="Book 5" />
        </div>
        <div class="book-content">
            <p class="book-description">Diary Of a Martian</p>
            <p class="book-price">$18.50</p>
            <div class="book-controls">
                <div class="quantity-control">
                    <input type="number" min="1" value="1" />
                </div>
                <button class="add-to-cart-btn" title="Add to Cart"></button>
            </div>
        </div>
    </div>

    <!-- Product 6 -->
    <div class="book-card">
        <div class="book-image-container">
            <img src="../images/book6.webp" alt="Book 6" />
        </div>
        <div class="book-content">
            <p class="book-description">The Last Wish</p>
            <p class="book-price">$19.99</p>
            <div class="book-controls">
                <div class="quantity-control">
                    <input type="number" min="1" value="1" />
                </div>
                <button class="add-to-cart-btn" title="Add to Cart"></button>
            </div>
        </div>
    </div>

    <!-- Product 7 -->
    <div class="book-card">
        <div class="book-image-container">
            <img src="../images/book7.webp" alt="Book 7" />
        </div>
        <div class="book-content">
            <p class="book-description">The Witcher</p>
            <p class="book-price">$21.50</p>
            <div class="book-controls">
                <div class="quantity-control">
                    <input type="number" min="1" value="1" />
                </div>
                <button class="add-to-cart-btn" title="Add to Cart"></button>
            </div>
        </div>
    </div>

    <!-- Product 8 -->
    <div class="book-card">
        <div class="book-image-container">
            <img src="../images/book8.webp" alt="Book 8" />
        </div>
        <div class="book-content">
            <p class="book-description">Blood of Elves</p>
            <p class="book-price">$20.99</p>
            <div class="book-controls">
                <div class="quantity-control">
                    <input type="number" min="1" value="1" />
                </div>
                <button class="add-to-cart-btn" title="Add to Cart"></button>
            </div>
        </div>
    </div>
</div>

<div class="books-row">
    <!-- Product 9 -->
    <div class="book-card">
        <div class="book-image-container">
            <img src="../images/book9.webp" alt="Book 9" />
        </div>
        <div class="book-content">
            <p class="book-description">Time of Contempt</p>
            <p class="book-price">$22.50</p>
            <div class="book-controls">
                <div class="quantity-control">
                    <input type="number" min="1" value="1" />
                </div>
                <button class="add-to-cart-btn" title="Add to Cart"></button>
            </div>
        </div>
    </div>

    <!-- Product 10 -->
    <div class="book-card">
        <div class="book-image-container">
            <img src="../images/book10.webp" alt="Book 10" />
        </div>
        <div class="book-content">
            <p class="book-description">Baptism of Fire</p>
            <p class="book-price">$21.99</p>
            <div class="book-controls">
                <div class="quantity-control">
                    <input type="number" min="1" value="1" />
                </div>
                <button class="add-to-cart-btn" title="Add to Cart"></button>
            </div>
        </div>
    </div>

    <!-- Product 11 -->
    <div class="book-card">
        <div class="book-image-container">
            <img src="../images/book11.webp" alt="Book 11" />
        </div>
        <div class="book-content">
            <p class="book-description">The Tower of Swallows</p>
            <p class="book-price">$23.50</p>
            <div class="book-controls">
                <div class="quantity-control">
                    <input type="number" min="1" value="1" />
                </div>
                <button class="add-to-cart-btn" title="Add to Cart"></button>
            </div>
        </div>
    </div>

    <!-- Product 12 -->
    <div class="book-card">
        <div class="book-image-container">
            <img src="../images/book12.webp" alt="Book 12" />
        </div>
        <div class="book-content">
            <p class="book-description">Lady of the Lake</p>
            <p class="book-price">$24.99</p>
            <div class="book-controls">
                <div class="quantity-control">
                    <input type="number" min="1" value="1" />
                </div>
                <button class="add-to-cart-btn" title="Add to Cart"></button>
            </div>
        </div>
    </div>
</div>

<div class="books-row">
    <!-- Product 13 -->
    <div class="book-card">
        <div class="book-image-container">
            <img src="../images/book13.webp" alt="Book 13" />
        </div>
        <div class="book-content">
            <p class="book-description">Season of Storms</p>
            <p class="book-price">$22.99</p>
            <div class="book-controls">
                <div class="quantity-control">
                    <input type="number" min="1" value="1" />
                </div>
                <button class="add-to-cart-btn" title="Add to Cart"></button>
            </div>
        </div>
    </div>

    <!-- Product 14 -->
    <div class="book-card">
        <div class="book-image-container">
            <img src="../images/book14.webp" alt="Book 14" />
        </div>
        <div class="book-content">
            <p class="book-description">The Sword of Destiny</p>
            <p class="book-price">$21.50</p>
            <div class="book-controls">
                <div class="quantity-control">
                    <input type="number" min="1" value="1" />
                </div>
                <button class="add-to-cart-btn" title="Add to Cart"></button>
            </div>
        </div>
    </div>

    <!-- Product 15 -->
    <div class="book-card">
        <div class="book-image-container">
            <img src="../images/book15.webp" alt="Book 15" />
        </div>
        <div class="book-content">
            <p class="book-description">The Edge of the World</p>
            <p class="book-price">$20.99</p>
            <div class="book-controls">
                <div class="quantity-control">
                    <input type="number" min="1" value="1" />
                </div>
                <button class="add-to-cart-btn" title="Add to Cart"></button>
            </div>
        </div>
    </div>
</div>

<?php include __DIR__ . '/footer.php'; ?>

