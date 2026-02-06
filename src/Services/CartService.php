<?php

namespace App\Services;
use App\Repositories\CartRepository;

class CartService
{
    public function __construct(
        private CartRepository $cartRepository
    ) {}
    public function getCart(int $sessionId): array
    {
        return $this->cartRepository->getCart($sessionId);
    }
    
}