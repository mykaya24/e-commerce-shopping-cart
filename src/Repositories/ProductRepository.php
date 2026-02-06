<?php

namespace App\Repositories;

use App\Models\Product;
use App\Models\Category;

class ProductRepository extends BaseRepository{
    public function __construct()
    {
        parent::__construct();
    }

    public function getProducts(array $params): array
    {
        $sql = "SELECT p.*,c.name as category_name, c.slug as category_slug FROM products p join categories c on c.id = p.category_id WHERE 1=1";
        $bindings = [];

        //Search
        if (!empty($params['search'])) {
            $sql .= " AND (name LIKE :search OR description LIKE :search)";
            $bindings['search'] = '%' . $params['search'] . '%';
        }

        //Category
        if (!empty($params['category_id'])) {
            $sql .= " AND category_id = :category_id";
            $bindings['category_id'] = (int)$params['category_id'];
        }

        //Min price
        if (!empty($params['min_price'])) {
            $sql .= " AND price >= :min_price";
            $bindings['min_price'] = (float)$params['min_price'];
        }

        //Max price
        if (!empty($params['max_price'])) {
            $sql .= " AND price <= :max_price";
            $bindings['max_price'] = (float)$params['max_price'];
        }

        //Sorting (WHITELIST!)
        $allowedSorts = [
            'price_asc'  => 'price ASC',
            'price_desc' => 'price DESC',
            'name_asc'     => 'name ASC',
            'name_desc'     => 'name DESC'
        ];

        if (!empty($params['sort']) && isset($allowedSorts[$params['sort']])) {
            $sql .= " ORDER BY " . $allowedSorts[$params['sort']];
        } else {
            $sql .= " ORDER BY id DESC";
        }

        //Pagination
        $page  = max(0, (int)($params['page'] ?? 0));
        $count = min(100, (int)($params['count'] ?? 10));

        $offset = $page * $count;
        $sql .= " LIMIT $offset, $count";

        $rows = $this->select($sql, $bindings);

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

    public function getProductById(int $id): array
    {
        $sql = "SELECT p.*,c.name as category_name, c.slug as category_slug FROM products p join categories c on c.id = p.category_id WHERE id = :id";
        $rows = $this->select($sql, ["id"=>$id]);

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
    public function getAllCategory(): array
    {
        $sql = "SELECT * FROM categories ";
        $rows = $this->select($sql);

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