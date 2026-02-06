<?php

namespace App\Controllers;

use App\Helpers\Response;

class CartController
{
    private CartService $cartService;
    public function __construct()
    {
        $this->cartService = new CartService(
            new CartRepository()
        );
    }

    public function show(){
        //
    }
}