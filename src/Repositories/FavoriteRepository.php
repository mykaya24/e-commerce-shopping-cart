<?php

namespace App\Repositories;

use App\Models\Product;
use App\Models\Category;
use App\Models\Favorite;

class FavoriteRepository extends BaseRepository{
    public function __construct()
    {
        parent::__construct();
    }

    public function getFavorites(string $sessionId) :?array{
        $sql = "SELECT f.*,
                    p.name as product_name, p.price as product_price, p.stock as product_stock, p.image_url as product_image_url, p.description as product_description, 
                    c.name as category_name, c.slug as category_slug, c.id as category_id
                    FROM favorites f join products p on p.id = f.product_id 
                                    left join categories c on c.id = p.category_id 
                    WHERE f.session_id = :session_id";

        $rows = $this->select($sql, ["session_id"=>$sessionId]);
        if(empty($rows))
            return null;
        
        return array_map(
            fn ($row) => new Favorite(
                (int)$row['id'],
                $row['session_id'],
                new Product(
                    (int)$row['product_id'],
                    $row['product_name'],
                    $row['product_description'],
                    (float)$row['product_price'],
                    (int)$row['product_stock'],
                    new Category(
                                (int)$row['category_id'],
                                $row['category_name'],
                                $row['category_slug']
                                ),
                    $row['product_image_url']
                )
            ),
            $rows
        );

    }

    public function getFavorite(string $sessionId, int $productId) :?Favorite{
        $sql = "select f.*,
                    p.name as product_name, p.price as product_price, p.stock as product_stock, p.image_url as product_image_url, p.description as product_description, 
                    c.name as category_name, c.slug as category_slug, c.id as category_id
                    from favorites f join products p on p.id = f.product_id 
                                    left join categories c on c.id = p.category_id 
                    where f.session_id = :session_id
                    and f.product_id = :product_id";

        $row = $this->first($sql, ["session_id"=>$sessionId,"product_id"=>$productId]);
        if(empty($row))
            return null;
        
        return new Favorite(
                (int)$row['id'],
                $row['session_id'],
                new Product(
                    (int)$row['product_id'],
                    $row['product_name'],
                    $row['product_description'],
                    (float)$row['product_price'],
                    (int)$row['product_stock'],
                    new Category(
                                (int)$row['category_id'],
                                $row['category_name'],
                                $row['category_slug']
                                ),
                    $row['product_image_url']
                )
        );

    }

    public function getFavoriteById(string $sessionId, int $id) :?Favorite{
        $sql = "select f.*,
                    p.name as product_name, p.price as product_price, p.stock as product_stock, p.image_url as product_image_url, p.description as product_description, 
                    c.name as category_name, c.slug as category_slug, c.id as category_id
                    from favorites f join products p on p.id = f.product_id 
                                    left join categories c on c.id = p.category_id 
                    where f.id = :id
                    and f.session_id = :session_id";

        $row = $this->first($sql, ["session_id"=>$sessionId,"id"=>$id]);
        if(empty($row))
            return null;
        
        return new Favorite(
                (int)$row['id'],
                $row['session_id'],
                new Product(
                    (int)$row['product_id'],
                    $row['product_name'],
                    $row['product_description'],
                    (float)$row['product_price'],
                    (int)$row['product_stock'],
                    new Category(
                                (int)$row['category_id'],
                                $row['category_name'],
                                $row['category_slug']
                                ),
                    $row['product_image_url']
                )
        );

    }
    public function create(string $sessionId,int $productId): ?Favorite
    {
        $this->execute(
            "insert into favorites (session_id,product_id,created_at) values (:session_id,:product_id,now())",
            ['session_id' => $sessionId,'product_id' => $productId]
        );
        $id = $this->lastInsertId();
        $favorite = $this->getFavoriteById($sessionId,$id);
        return $favorite;
    }
    public function remove(string $sessionId,int $productId): void
    {
        $this->execute(
            "delete from favorites where product_id = :product_id and session_id = :session_id",
            ['session_id' => $sessionId,'product_id' => $productId]
        );
    }

    

}