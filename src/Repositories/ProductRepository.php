<?php

namespace App\Repositories;

use App\Models\Product;
use App\Models\Category;

class ProductRepository extends BaseRepository{
    public function __construct()
    {
        parent::__construct();
    }

    public function find(int $productId) :?Product{
        $sql = "SELECT p.*,c.name as category_name, c.slug as category_slug FROM products p left join categories c on c.id = p.category_id WHERE p.id = :id";

        $row = $this->first($sql, ["id"=>$productId]);
        if(empty($row))
            return null;
        return new Product(
                $row["id"],
                $row["name"],
                $row["description"],
                $row["price"],
                $row["stock"],
                new Category(
                            $row["category_id"],
                            $row["category_name"],
                            $row["category_slug"]),
                $row["image_url"]);

    }

    public function getProducts(array $params): array
    {
        $sql = "SELECT p.*,c.name as category_name, c.slug as category_slug FROM products p left join categories c on c.id = p.category_id WHERE 1=1";
        $bindings = [];

        //Search
        if (!empty($params['search'])) {
            $sql .= " AND (p.name LIKE :search OR p.description LIKE :search)";
            $bindings['search'] = '%' . $params['search'] . '%';
        }

        //Category
        if (!empty($params['category_id'])) {
            $sql .= " AND p.category_id = :category_id";
            $bindings['category_id'] = (int)$params['category_id'];
        }

        //Min price
        if (!empty($params['min_price'])) {
            $sql .= " AND p.price >= :min_price";
            $bindings['min_price'] = (float)$params['min_price'];
        }

        //Max price
        if (!empty($params['max_price'])) {
            $sql .= " AND p.price <= :max_price";
            $bindings['max_price'] = (float)$params['max_price'];
        }

        //Sorting (WHITELIST!)
        $allowedSorts = [
            'price_asc'  => 'p.price ASC',
            'price_desc' => 'p.price DESC',
            'name_asc'     => 'p.name ASC',
            'name_desc'     => 'p.name DESC'
        ];

        if (!empty($params['sort']) && isset($allowedSorts[$params['sort']])) {
            $sql .= " ORDER BY " . $allowedSorts[$params['sort']];
        } else {
            $sql .= " ORDER BY p.id DESC";
        }

        //Pagination
        $page  = max(0, (int)($params['page'] ?? 0));
        $count = min(100, (int)($params['count']==0?5:$params['count']));

        $offset = $page * $count;
        $sql .= " LIMIT $offset, $count";
        
        $rows = $this->select($sql, $bindings);
        if(empty($rows))
            return [];
        return array_map(
            fn ($row) => new Product(
                (int)$row['id'],
                $row['name'],
                $row['description'],
                (float)$row['price'],
                (int)$row['stock'],
                new Category((int)$row['category_id'],$row['category_name'],$row['category_slug']),
                $row['image_url']
            ),
            $rows
        );
    }

    public function getProductById(int $id): ?Product
    {
        $sql = "SELECT p.*,c.name as category_name, c.slug as category_slug FROM products p join categories c on c.id = p.category_id WHERE p.id = :id";
        $row = $this->first($sql, ["id"=>$id]);
        if(empty($row))
            return null;
       return  new Product(
                (int)$row['id'],
                $row['name'],
                $row['description'],
                (float)$row['price'],
                (int)$row['stock'],
                new Category((int)$row['category_id'],$row['category_name'],$row['category_slug']),
                $row['image_url']
            );

    }
    public function getAllCategory(): ?array
    {
        $sql = "SELECT * FROM categories ";
        $rows = $this->select($sql);
        if(empty($rows))
            return null;
        return array_map(
            fn ($row) => new Category(
                (int)$row['id'],
                $row['name'],
                $row['slug']
            ),
            $rows
        );
    }

}