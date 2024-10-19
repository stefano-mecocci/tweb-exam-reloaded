<?php

namespace App\Models;

require_once __DIR__ . '/../core/BaseRepo.php';
require_once __DIR__ . '/../core/querybuilder/index.php';

use App\Core\BaseRepo;
use App\Core\Querybuilder\InsertQuery;
use App\Core\Querybuilder\QueryBuilder;
use App\Core\Querybuilder\SelectQuery;
use App\Core\Querybuilder\SqlOperators;

class UserRepo extends BaseRepo
{
    private $fields = ["id", "email", "password_hash", "first_name", "last_name", "address", "role", "question", "answer"];

    private function allExcept(array $notInclude)
    {
        $result = [];

        foreach ($this->fields as $f) {
            if (!in_array($f, $notInclude)) {
                $result[] = $f;
            }
        }

        return $result;
    }

    private function mapPlaceholders(array $valuesMap)
    {
        return array_combine(
            array_map(fn($v) => ":$v", array_keys($valuesMap)),
            array_values($valuesMap)
        );
    }

    public function save(array $user)
    {
        $cols = ["email", "password_hash", "first_name", "last_name", "address", "role", "question", "answer"];
        $q = (new InsertQuery())
            ->into("users")
            ->columns($cols)
            ->values(array_values($user));

        $qb = new QueryBuilder();
        $query = $qb->toSql($q);

        $this->prepare($query, array_combine(
            array_map(fn($v) => ":$v", array_keys($q->valuesMap)),
            array_values($q->valuesMap)
        ));

        return $this->execute();
    }

    public function getBy(string $field, $value)
    {
        $cols = $this->allExcept(["id", "password_hash"]);
        $q = (new SelectQuery())
            ->from("users")
            ->columns($cols)
            ->where()
            ->cond($field, SqlOperators::EQ, $value);

        $qb = new QueryBuilder();
        $query = $qb->toSql($q);

        $this->prepare($query, $this->mapPlaceholders($q->valuesMap));

        return $this->fetchOne();
    }
}