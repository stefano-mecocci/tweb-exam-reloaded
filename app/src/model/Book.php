<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/util/db.php";
require_once "Model.php";

class Book extends Model {
    public int $id;
    public string $title;
    public string $description;
    public string $genres;
    public string $authors;
    private int $price;
    public int $quantity;
    public int $sellerId;
    public int $pages;
    
    public function getPrice() {
        return $this->price;
    }

    public function setPrice($priceStr) {
        $priceSafeStr = null;

        if (substr_count($priceStr, ",") >= 1) {
            $priceSafeStr = str_replace(",", "", $priceStr);
        } else {
            $priceSafeStr = $priceStr . "00";
        }
        
        $this->price = intval($priceSafeStr);
    }

    public function deleteFromCart($userId) {
        $query = "DELETE FROM carts WHERE id = :id AND user_id = :user_id";
        $params = [
            ":id" => $this->id,
            ":user_id" => $userId
        ];

        self::$db->prepare($query, $params);
        return self::$db->execute();
    }

    public function deleteFromBooks() {
        $query = "DELETE FROM books WHERE id = :book_id AND seller_id = :user_id";
        $params = [
            ":book_id" => $this->id,
            ":user_id" => $this->sellerId
        ];

        self::$db->prepare($query, $params);
        return self::$db->execute();
    }

    public static function getAllBySeller($sellerId) {
        $query = "SELECT * FROM books where seller_id = :id";
        $params = [":id" => $sellerId];

        self::$db->prepare($query, $params);
        return self::$db->fetchAll();
    }

    public static function getAll() {
        $query = "SELECT books.*, (SELECT AVG(mark) FROM reviews WHERE books.id = reviews.book_id) AS avgMark FROM books";
        $params = [];

        self::$db->prepare($query, $params);
        return self::$db->fetchAll();
    }

    public static function getOne($id) {
        $query = "SELECT books.*, (SELECT AVG(mark) FROM reviews WHERE books.id = reviews.book_id) AS avgMark FROM books WHERE id = :id";
        $params = [":id" => $id];

        self::$db->prepare($query, $params);

        return self::$db->fetchOne();
    }

    public function saveToCart($userId, $quantity = 1) {
        $query = "INSERT INTO carts (book_id, user_id, quantity) ";
        $query .= "VALUES (:book_id, :user_id, :quantity) ON DUPLICATE KEY UPDATE quantity = quantity + :quantity";

        $params = [
            ":book_id" => $this->id,
            ":user_id" => $userId,
            ":quantity" => $quantity
        ];

        self::$db->prepare($query, $params);
        return self::$db->execute();
    }

    public function saveToBooks() {
        $query = "INSERT INTO books (title, description, price, pages, seller_id, genres, quantity, authors) ";
        $query = $query . "VALUES (:title, :description, :price, :pages, :seller_id, :genres, :quantity, :authors)";

        $params = [
            ":title" => $this->title,
            ":description" => $this->description,
            ":price" => $this->price,
            ":pages" => $this->pages,
            ":seller_id" => $this->sellerId,
            ":genres" => $this->genres,
            ":quantity" => $this->quantity,
            ":authors" => $this->authors
        ];

        self::$db->prepare($query, $params);
        return self::$db->execute();
    }

    public function lastBookId() {
        return self::$db->lastInsertId();
    }

    public static function getAvgMark($id) {
        $query = "SELECT AVG(mark) FROM reviews WHERE book_id = :id";
        $params = [":id" => $id];

        self::$db->prepare($query, $params);

        return self::$db->fetchOne();
    }
}

Book::setDb($DB);