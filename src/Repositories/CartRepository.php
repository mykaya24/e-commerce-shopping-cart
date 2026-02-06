<?php

namespace App\Repositories;

use App\Models\Cart;

class CartRepository extends BaseRepository{
    public function __construct()
    {
        parent::__construct();
    }

   public function getCart(): array
    {
        $sql = "SELECT * FROM cart ";
        $rows = $this->select($sql);

        return [];
    } 

}