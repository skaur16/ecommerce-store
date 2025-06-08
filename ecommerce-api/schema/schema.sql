CREATE DATABASE ecommerce;

USE ecommerce;

CREATE TABLE users (
    userID INT AUTO_INCREMENT PRIMARY KEY,
    email VARCHAR(100) UNIQUE,
    password VARCHAR(255),
    username VARCHAR(50),
    shippingAddress TEXT
);

CREATE TABLE products (
    productID INT AUTO_INCREMENT PRIMARY KEY,
    description TEXT,
    image VARCHAR(255),
    price DECIMAL(10, 2),
    shippingCost DECIMAL(10, 2)
);

CREATE TABLE comments (
    commentID INT AUTO_INCREMENT PRIMARY KEY,
    productID INT,
    userID INT,
    rating INT,
    image VARCHAR(255),
    text TEXT,
    FOREIGN KEY (productID) REFERENCES products(productID),
    FOREIGN KEY (userID) REFERENCES users(userID)
);

CREATE TABLE cart (
    cartID INT AUTO_INCREMENT PRIMARY KEY,
    userID INT,
    productID INT,
    quantity INT,
    FOREIGN KEY (userID) REFERENCES users(userID),
    FOREIGN KEY (productID) REFERENCES products(productID)
);

CREATE TABLE orders (
    orderID INT AUTO_INCREMENT PRIMARY KEY,
    userID INT,
    orderDate TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    totalAmount DECIMAL(10,2),
    FOREIGN KEY (userID) REFERENCES users(userID)
);
