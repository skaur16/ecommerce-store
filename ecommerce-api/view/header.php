
<!DOCTYPE html>
<html>
<head>
    <title>Book Store</title>
    <style>
        body {
            background: #000814;
            color: #FFD60A;
            font-family: 'Segoe UI', Arial, sans-serif;
            margin: 0;
            padding: 0;
        }
        nav {
            background-color: #001d3d;
            padding: 16px 0;
            box-shadow: 0 2px 8px rgba(0,0,0,0.10);
            text-align: center;
        }
        nav a {
            color: #FFD60A;
            margin: 0 18px;
            text-decoration: none;
            font-weight: 500;
            font-size: 1.1em;
            transition: color 0.2s;
            padding: 6px 10px;
            border-radius: 4px;
        }
        nav a:hover, nav a.active {
            color: #001d3d;
            background: #FFD60A;
            text-decoration: none;
        }
    </style>
</head>
<body>

<nav>
    <a href="/ecommerce-store/ecommerce-api/view/index.php">Home</a>
    <a href="/ecommerce-store/ecommerce-api/view/products.php">Products</a>
    <a href="/ecommerce-store/ecommerce-api/view/comments.php">Comments</a>
    <a href="/ecommerce-store/ecommerce-api/view/login.php">Login</a>
    <a href="/ecommerce-store/ecommerce-api/view/signup.php">Signup</a>
    <a href="/ecommerce-store/ecommerce-api/view/cart.php">Cart</a>
</nav>
