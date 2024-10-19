<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/util/db.php";
require_once "Model.php";

class Cart extends Model {
    public static function moveAllToOrders($userId) {
        self::$db->conn->beginTransaction();

        $query = "INSERT INTO orders (book_id, user_id, quantity) SELECT book_id, user_id, quantity FROM carts WHERE carts.user_id = :id";
        $params = [":id" => $userId];
        self::$db->prepare($query, $params);
        self::$db->execute();

        $query2 = "DELETE FROM carts WHERE user_id = :id";
        $params2 = [":id" => $userId];
        self::$db->prepare($query2, $params2);
        self::$db->execute();

        return self::$db->conn->commit();
    }

    public static function getAllByUser($userId) {
        $query = "SELECT books.*, carts.id AS cart_id, carts.quantity AS cart_quantity FROM books INNER JOIN carts ";
        $query .= "ON carts.book_id=books.id AND carts.user_id  = :user_id";

        $params = [":user_id" => $userId];

        self::$db->prepare($query, $params);
        return self::$db->fetchAll();
    }

    public static function getTotal($userId) {
        $query = "SELECT SUM(books.price * carts.quantity) AS total FROM books INNER JOIN carts ";
        $query .= "ON carts.book_id=books.id AND carts.user_id  = :user_id";

        $params = [":user_id" => $userId];

        self::$db->prepare($query, $params);
        return self::$db->fetchOne();
    }
}

Cart::setDb($DB);