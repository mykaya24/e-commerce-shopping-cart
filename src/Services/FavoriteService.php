<?php

namespace App\Services;

use App\Exceptions\FavoriteNotFoundException;
use App\Exceptions\ProductAlredyExistsException;
use App\Exceptions\ProductNotFoundException;
use App\Models\Cart;
use App\Models\Favorite;
use App\Models\Product;
use App\Repositories\FavoriteRepository;
use App\Repositories\ProductRepository;

class FavoriteService
{
    public function __construct(
        private FavoriteRepository $favoriteRepository,
        private ProductRepository $productRepository,
        private CartService $cartService
    ) {}
    public function getFavorites(string $sessionId): array
    {
        $favorites = $this->favoriteRepository->getFavorites($sessionId);
        if (!$favorites)
            throw new FavoriteNotFoundException();
        return $favorites;    
    }

    public function getFavorite(string $sessionId,$productId): ?Favorite
    {
        $favorite = $this->favoriteRepository->getFavorite($sessionId,$productId);
        return $favorite;    
    }

    public function addProduct(string $sessionId,int $productId): ?Favorite { 
        $favorite = $this->getFavorite($sessionId,$productId);
        
        if ($favorite !== null) 
            throw new ProductAlredyExistsException();
        $product = $this->productRepository->getProductById($productId);
        if ($product === null) 
            throw new ProductNotFoundException();
        
        $favorite = $this->favoriteRepository->create($sessionId,$productId);
        if ($favorite === null) 
            throw new FavoriteNotFoundException("Favorite product not created");
        return $favorite;
    }

    public function remove(string $sessionId, int $productId): void{
        $favorite = $this->favoriteRepository->getFavorite($sessionId,$productId);
        if(!$favorite)
            throw new FavoriteNotFoundException();
        
        $this->favoriteRepository->remove($sessionId,$productId);
        
    }

    public function addFavoriteProductToCart(string $sessionId, int $productId): Cart{
        $favorite = $this->favoriteRepository->getFavorite($sessionId,$productId);
        if(!$favorite)
            throw new FavoriteNotFoundException();
        $cart= $this->cartService->addProduct($sessionId,$favorite->product->id,1);
        return $cart;
    }
    
}