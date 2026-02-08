<?php

namespace App\Repositories;

use App\Enum\CouponType;
use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Category;
use App\Models\Coupon;
use App\Models\Product;

class CartRepository extends BaseRepository
{
    public function __construct()
    {
        parent::__construct();
    }

    public function getCart(string $sessionId): ?Cart
    {
        $sql = "SELECT c.*, 
                        t.quantity as cart_item_quantity, t.id as cart_item_id , t.product_id as cart_product_id,
                        p.name as product_name, p.price as product_price, p.stock as product_stock, p.image_url as product_image_url, 
                        ca.name as product_category_name , ca.slug as product_category_slug, ca.id as product_category_id,
                        cc.code as coupon_code, cc.type as coupon_type, cc.value as coupon_value, cc.min_cart_total as coupon_min_cart_total, cc.expires_at as coupon_expires_at
                            FROM carts c 
                            join cart_items t on t.cart_id = c.id 
                            join products p on p.id = t.product_id
                            join categories ca on ca.id = p.category_id
                            left join coupons cc on cc.id = c.coupon_id
                where session_id = :session_id";
        $rows = $this->select($sql, ["session_id" => $sessionId]);

        if (empty($rows)) {
            return null;
        }

        $firstRow = $rows[0];

        $coupon = null;

        if ($firstRow['coupon_id']) {
            $coupon = new Coupon(
                (int)$firstRow["coupon_id"],
                $firstRow["coupon_code"],
                CouponType::from($firstRow["coupon_type"]),
                $firstRow["coupon_value"],
                $firstRow["coupon_min_cart_total"],
                new \DateTimeImmutable($firstRow["coupon_expires_at"])
            );
        }
        $cart_items = [];
        foreach ($rows as $row) {
            $product = new Product(
                (int)$row["cart_product_id"],
                $row["product_name"],
                "",
                $row["product_price"],
                $row["product_stock"],
                new Category($row["product_category_id"],$row["product_category_name"],$row["product_category_slug"]),
                $row["product_image_url"]
            );

            $cartItem = new CartItem(
                (int)$row["cart_item_id"],
                (int)$row["id"],
                $product,
                $row["cart_item_quantity"]
            );

            $cart_items[] = $cartItem; // ya da 
        }

        $cart = new Cart(
            (int)$firstRow["id"],
            $firstRow["session_id"],
            $coupon,
            $cart_items
        );

        return $cart;
    }

    public function create(string $sessionId): Cart
    {
        $this->execute(
            "insert into carts (session_id) values (:session_id)",
            ['session_id' => $sessionId]
        );

        $id = $this->lastInsertId();

        return new Cart($id, $sessionId);
    }

    public function save(Cart $cart): void
    {
        
        $this->execute(
                "update carts set coupon_id = :coupon_id where id = :id",
                [
                    'id' => $cart->id,
                    'coupon_id'  => ($cart->coupon===null?null:$cart->coupon->id)
                ]
            );
        
        foreach ($cart->items() as $item) {

            if ($item->id === null) {
                $this->execute(
                    "insert into cart_items (cart_id, product_id, quantity)
                    values (:cart_id, :product_id, :quantity)",
                    [
                        'cart_id' => $cart->id,
                        'product_id' => $item->product->id,
                        'quantity' => $item->quantity
                    ]
                );
            } else {
                $this->execute(
                    "update cart_items set quantity = :quantity where id = :id",
                    [
                        'quantity' => $item->quantity,
                        'id'  => $item->id
                    ]
                );
            }
        }
    }

    public function updateItemQuantity(int $itemId, int $quantity): void
    {
        $this->execute(
            "update cart_items set quantity = :quantity where id = :id",
            [
                'quantity' => $quantity,
                'id'  => $itemId
            ]
        );
    }

    public function removeCartItem(string $sessionId, int $cartItemId){
        $this->execute(
            "delete ci from cart_items ci join carts c on c.id = ci.cart_id 
                            where ci.id = :id
                            and c.session_id = :session_id",
            [
                'id' => $cartItemId,
                'session_id' => $sessionId
            ]
        );
    }

    public function removeAllCartItem(string $sessionId){
        $this->execute(
            "delete ci from cart_items ci join carts c on c.id = ci.cart_id 
                            where c.session_id = :session_id",
            [
                'session_id' => $sessionId
            ]
        );
    }
}
