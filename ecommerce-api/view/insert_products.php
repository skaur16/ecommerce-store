<?php
require_once __DIR__ . '/../config/database.php';

$database = new Database();
$db = $database->getConnection();

try {
    // First, clear existing comments
    $db->exec("DELETE FROM comments");
    
    // Then clear existing cart items
    $db->exec("DELETE FROM cart");
    
    // Finally clear existing products
    $db->exec("DELETE FROM products");

    // Products data
    $products = [
        [
            'description' => 'Daughter Of Man',
            'image' => '../images/book1.jpeg',
            'price' => 20.00,
            'shippingCost' => 5.00
        ],
        [
            'description' => 'Fortress Blood',
            'image' => '../images/book2.jpeg',
            'price' => 18.50,
            'shippingCost' => 5.00
        ],
        [
            'description' => 'Call Avalon',
            'image' => '../images/book3.webp',
            'price' => 22.00,
            'shippingCost' => 5.00
        ],
        [
            'description' => 'Dune',
            'image' => '../images/book4.webp',
            'price' => 20.00,
            'shippingCost' => 5.00
        ],
        [
            'description' => 'Diary Of a Martian',
            'image' => '../images/book5.webp',
            'price' => 18.50,
            'shippingCost' => 5.00
        ],
        [
            'description' => 'The Last Wish',
            'image' => '../images/book6.webp',
            'price' => 19.99,
            'shippingCost' => 5.00
        ],
        [
            'description' => 'The Witcher',
            'image' => '../images/book7.webp',
            'price' => 21.50,
            'shippingCost' => 5.00
        ],
        [
            'description' => 'Blood of Elves',
            'image' => '../images/book8.webp',
            'price' => 20.99,
            'shippingCost' => 5.00
        ],
        [
            'description' => 'Time of Contempt',
            'image' => '../images/book9.webp',
            'price' => 22.50,
            'shippingCost' => 5.00
        ],
        [
            'description' => 'Baptism of Fire',
            'image' => '../images/book10.webp',
            'price' => 21.99,
            'shippingCost' => 5.00
        ],
        [
            'description' => 'The Tower of Swallows',
            'image' => '../images/book11.webp',
            'price' => 23.50,
            'shippingCost' => 5.00
        ],
        [
            'description' => 'Lady of the Lake',
            'image' => '../images/book12.webp',
            'price' => 24.99,
            'shippingCost' => 5.00
        ],
        [
            'description' => 'Season of Storms',
            'image' => '../images/book13.webp',
            'price' => 22.99,
            'shippingCost' => 5.00
        ],
        [
            'description' => 'The Sword of Destiny',
            'image' => '../images/book14.webp',
            'price' => 21.50,
            'shippingCost' => 5.00
        ],
        [
            'description' => 'The Edge of the World',
            'image' => '../images/book15.webp',
            'price' => 20.99,
            'shippingCost' => 5.00
        ]
    ];

    // Insert products
    $query = "INSERT INTO products (description, image, price, shippingCost) VALUES (?, ?, ?, ?)";
    $stmt = $db->prepare($query);

    foreach ($products as $product) {
        $stmt->execute([
            $product['description'],
            $product['image'],
            $product['price'],
            $product['shippingCost']
        ]);
    }

    echo "Products inserted successfully!";
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?> 