<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/util/db.php";
require_once "Model.php";

class Review extends Model {
    public string $body;
    public int $mark;
    public int $userId;
    public int $bookId;

    public function save($userId) {
        $query = "INSERT INTO reviews (body, mark, book_id, user_id) ";
        $query = $query . "VALUES (:body, :mark, :book_id, :user_id)";

        $params = [
            ":body" => $this->body,
            ":mark" => $this->mark,
            ":book_id" => $this->bookId,
            ":user_id" => $userId
        ];

        self::$db->prepare($query, $params);
        return self::$db->execute();
    }

    public static function getAllByBook($bookId) {
        $query = "SELECT * FROM reviews WHERE book_id = :id";
        $params = [":id" => $bookId];

        self::$db->prepare($query, $params);
        return self::$db->fetchAll();
    }
}

Review::setDb($DB);