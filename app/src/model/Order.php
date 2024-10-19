<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/util/db.php";
require_once "Model.php";

class Order extends Model {
    public int $id;

    public static function getAllByUser($userId) {
        $query = "SELECT books.id AS book_id, books.title, books.price, orders.order_date, orders.quantity, orders.id FROM books ";
        $query .= "INNER JOIN orders ON orders.book_id=books.id AND orders.user_id  = :user_id";
        $params = [":user_id" => $userId];

        self::$db->prepare($query, $params);
        return self::$db->fetchAll();
    }

    public function delete($userId) {
        $query = "DELETE FROM orders WHERE id = :id AND user_id = :user_id";
        $params = [
            ":id" => $this->id,
            ":user_id" => $userId
        ];

        self::$db->prepare($query, $params);
        return self::$db->execute();
    }
}

Order::setDb($DB);