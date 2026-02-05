<?php

namespace App\Repositories;

use App\Models\Product;

class ProductRepository extends BaseRepository{
    public function __construct()
    {
        parent::__construct();
    }

    public function getProducts(string $search): array{
        $rows = $this->select(
            "SELECT * FROM products where name like :name",
            ["name"=>'%'.$search.'%']
        );

        return array_map(
            fn ($row) => new Product(
                (int) $row['id'],
                $row['name'],
                (float) $row['price']
            ),
            $rows
        );
    }
}