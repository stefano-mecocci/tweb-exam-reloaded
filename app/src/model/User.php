<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/util/db.php";
require_once "Model.php";

class User extends Model
{
    public string $id;
    public int $role = 0;
    public string $email;
    public string $password;
    public string $firstName;
    public string $lastName;
    public string $address;
    public string $question;
    public string $answer;

    public function hashPassword()
    {
        $this->password = password_hash($this->password, PASSWORD_DEFAULT);
    }

    public function save()
    {
        $query = "INSERT INTO users (email, password, first_name, last_name, address, role, question, answer) ";
        $query = $query . "VALUES (:email, :password, :first_name, :last_name, :address, :role, :question, :answer)";

        $params = [
            ":email" => $this->email,
            ":password" => $this->password,
            ":first_name" => $this->firstName,
            ":last_name" => $this->lastName,
            ":address" => $this->address,
            ":role" => $this->role,
            ":question" => $this->question,
            ":answer" => $this->answer
        ];

        self::$db->prepare($query, $params);
        return self::$db->execute();
    }

    public static function updatePassword($email, $newPasswordHash)
    {
        $query = "UPDATE users SET password = :password WHERE email = :email";
        $params = [
            ":email" => $email,
            ":password" => $newPasswordHash
        ];

        self::$db->prepare($query, $params);

        return self::$db->execute();
    }

    public static function getOne($id)
    {
        $query = "SELECT * FROM users WHERE id = :id";
        $params = [":id" => $id];

        self::$db->prepare($query, $params);
        $user = self::$db->fetchOne();

        return ($user == false) ? null : $user;
    }

    public static function getOneByEmail($email)
    {
        $query = "SELECT * FROM users WHERE email = :email";
        $params = [":email" => $email];

        self::$db->prepare($query, $params);
        $user = self::$db->fetchOne();

        return $user;
    }

    public function login()
    {
        $query = "SELECT * FROM users WHERE email = :email";
        $params = [":email" => $this->email];

        self::$db->prepare($query, $params);

        if (($user = self::$db->fetchOne()) == false) {
            return false;
        }

        if (password_verify($this->password, $user["password"])) {
            $this->id = $user["id"];
            $this->role = $user["role"];

            return true;
        } else {
            return false;
        }
    }

    public function update()
    {
        $query = "UPDATE users SET email = :email, first_name = :first_name, last_name = :last_name,";
        $query = $query . " address = :address";

        $params = [
            ":email" => $this->email,
            ":first_name" => $this->firstName,
            ":last_name" => $this->lastName,
            ":address" => $this->address,
            ":id" => $this->id
        ];

        if ($this->password != null) {
            $this->hashPassword();

            $query = $query . ", password = :password";
            $params[":password"] = $this->password;
        }

        $query = $query . " WHERE id = :id";

        self::$db->prepare($query, $params);
        $x = self::$db->execute();

        error_log(json_encode($x));

        return $x;
    }
}

User::setDb($DB);