<?php

namespace App\Services;

use App\Exceptions\CartNotFoundException;
use App\Exceptions\CouponNotFoundException;
use App\Exceptions\ProductNotFoundException;
use App\Exceptions\ProductOutOfStockException;
use App\Models\Cart;
use App\Repositories\CartRepository;
use App\Repositories\ProductRepository;

class CartService
{
    public function __construct(
        private CartRepository $cartRepository,
        private ProductRepository $productRepository,
        private CouponService $couponService
    ) {}

    public function getCart(string $sessionId): ?Cart
    {
        $cart = $this->cartRepository->getCart($sessionId);
        if (!$cart)
            throw new CartNotFoundException();
        return $cart;
    }
    public function addProduct(string $sessionId,int $productId,int $quantity): Cart {
        $cart = $this->cartRepository->getCart($sessionId);
        if ($cart === null) 
            $cart = $this->cartRepository->create($sessionId);
        
        $product = $this->productRepository->find($productId);

        if (!$product)
            throw new ProductNotFoundException();
        if($product->getStock()<= 0)
            throw new ProductOutOfStockException();
        
        $cart->addItem($product, $quantity);
        $this->cartRepository->save($cart);
        return $cart;
    }

    public function updateItemQuantity(string $sessionId,int $cartItemId,int $quantity): Cart {
        $cart = $this->cartRepository->getCart($sessionId);
        if (!$cart)
            throw new CartNotFoundException();

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

    public function applyCoupon(string $sessionId, string $couponCode): ?Cart
    {
        $cart = $this->cartRepository->getCart($sessionId);
        if (!$cart) 
            throw new CartNotFoundException();
        
        $coupon = $this->couponService->validate($couponCode, $cart);
        $cart->applyCoupon($coupon);
        $this->cartRepository->save($cart);
        return $cart;
    }
    public function removeCoupon(string $sessionId): ?Cart {
        $cart = $this->cartRepository->getCart($sessionId);
        if (!$cart) 
            throw new CartNotFoundException();
        if($cart->coupon === null)
            throw new CouponNotFoundException();
        $cart->removeCoupon();
        $this->cartRepository->save($cart);
        return $cart;
    }
}