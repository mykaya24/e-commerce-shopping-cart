<?php

namespace App\Services;

use App\Models\Cart;
use App\Repositories\CartRepository;
use App\Repositories\ProductRepository;

class CartService
{
    public function __construct(
        private CartRepository $cartRepository,
        private ProductRepository $productRepository
    ) {}

    public function getCart(string $sessionId): ?Cart
    {
        return $this->cartRepository->getCart($sessionId);
    }
    public function addProduct(string $sessionId,int $productId,int $quantity): Cart {
        $cart = $this->cartRepository->getCart($sessionId);

        if ($cart === null) {
            $cart = $this->cartRepository->create($sessionId);
        }

        $product = $this->productRepository->find($productId);

        if (!$product) {
            throw new \Exception('Product not found');
        }

        $cart->addItem($product, $quantity);

        $this->cartRepository->save($cart);

        return $cart;
    }

    public function updateItemQuantity(string $sessionId,int $cartItemId,int $quantity): Cart {
        $cart = $this->cartRepository->getCart($sessionId);

        if (!$cart) {
            throw new \Exception('Cart not found');
        }

        $cart->updateItemQuantity($cartItemId, $quantity);

        $this->cartRepository->updateItemQuantity(
            $cartItemId,
            $quantity
        );

        return $cart;
    }

    public function removeCartItem(string $sessionId, int $cartItemId): void{
        $this->cartRepository->removeCartItem($sessionId,$cartItemId);
    }
    public function removeAllCartItem(string $sessionId): void{
        $this->cartRepository->removeAllCartItem($sessionId);
    }
    

    
}