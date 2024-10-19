<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/util/db.php";
require_once "Model.php";

class Card extends Model {
    public int $id;
    public $expiringDate;
    public string $cvv;
    public string $number;
    public int $userId;

    public static function getAllByUserId($userId) {
        $query = "SELECT * FROM cards WHERE user_id = :user_id";
        $params = [":user_id" => $userId];

        self::$db->prepare($query, $params);
        return self::$db->fetchAll();
    }

    public function save() {
        $query = "INSERT INTO cards (card_number, cvv, expiring_date, user_id) ";
        $query = $query . "VALUES (:card_number, :cvv, :expiring_date, :user_id)";

        $params = [
            ":card_number" => $this->number,
            ":cvv" => $this->cvv,
            ":expiring_date" => $this->expiringDate,
            ":user_id" => $this->userId
        ];

        self::$db->prepare($query, $params);
        return self::$db->execute();
    }
}

Card::setDb($DB);