<?php

namespace App\Controllers;

use App\Models\Cart;

class CartController
{
    protected $cartModel;

    public function __construct()
    {
        $this->cartModel = new Cart();
    }

    public function addToCart($userId, $productId, $quantity)
    {
        // Logic to add item to cart
        return $this->cartModel->addItem($userId, $productId, $quantity);
    }

    public function getCart($userId)
    {
        // Logic to get user's cart
        return $this->cartModel->getItems($userId);
    }

    public function updateCart($userId, $productId, $quantity)
    {
        // Logic to update item quantity in cart
        return $this->cartModel->updateItem($userId, $productId, $quantity);
    }

    public function removeFromCart($userId, $productId)
    {
        // Logic to remove item from cart
        return $this->cartModel->removeItem($userId, $productId);
    }
}