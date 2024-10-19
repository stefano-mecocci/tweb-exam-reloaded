<?php

namespace App\Core\Querybuilder;

class QueryBuilder
{
    private array $query = [];

    private function addToken(string $token)
    {
        $this->query[] = $token;
    }

    private function build(Query $query)
    {
        if ($query instanceof SelectQuery) {
            return $this->buildSelect($query);
        } else if ($query instanceof DeleteQuery) {
            return $this->buildDelete($query);
        } else if ($query instanceof InsertQuery) {
            return $this->buildInsert($query);
        }

        return [];
    }

    public function debug(Query $query)
    {
        $s = json_encode([
            "query" => $this->toSql($query),
            "valuesMap" => $query->valuesMap
        ]);

        echo "<pre>{$s}</pre>";
    }

    public function toSql(Query $query)
    {
        $rawQuery = $this->build($query);
        $result = [];

        foreach ($rawQuery as $token) {
            if ($token instanceof SqlOperators || $token instanceof SqlOrder) {
                $result[] = $token->value;
            } else {
                $result[] = $token;
            }
        }

        return implode(" ", $result);
    }

    private function buildSelect(SelectQuery $query)
    {
        $this->addToken("SELECT");

        $cols = array_map(fn($col) => "{$query->table}.{$col}", $query->columns);
        $cols = implode(", ", $cols);
        $this->addToken($cols);

        $this->addToken("FROM");
        $this->addToken($query->table);

        if (count($query->conditions) > 0) {
            $this->addToken("WHERE");
            $this->query = [...$this->query, ...$query->conditions];
        }

        if (count($query->orderPiece) > 0) {
            $this->addToken("ORDER BY");
            $this->addToken($query->orderPiece[0]);
            $this->addToken($query->orderPiece[1]->value);
        }

        if ($query->limitPiece !== null) {
            $this->addToken("LIMIT");
            $this->addToken(':limit');
        }

        if ($query->offsetPiece !== null) {
            $this->addToken("OFFSET");
            $this->addToken(':offset');
        }

        return $this->query;
    }

    private function buildDelete(DeleteQuery $query)
    {
        $this->addToken("DELETE");
        $this->addToken("FROM");
        $this->addToken($query->table);

        if (count($query->conditions) > 0) {
            $this->addToken("WHERE");
            $this->query = [...$this->query, ...$query->conditions];
        }

        return $this->query;
    }

    private function buildInsert(InsertQuery $query)
    {
        $this->addToken("INSERT");
        $this->addToken("INTO");
        $this->addToken($query->table);

        $this->addToken("(" . implode(", ", $query->columns) . ")");

        $this->addToken("VALUES");
        $this->addToken("(" . implode(", ", $query->values) . ")");

        return $this->query;
    }

    /* public static function deleteUniqueFrom(string $table, string $field, $value)
    {
        $q = (new DeleteQuery())
            ->from($table)
            ->where()
            ->cond($field, SqlOperators::EQ, $value);

        return $q;
    }

    public static function selectAll(string $table)
    {
        $q = (new SelectQuery())
            ->from($table);

        return $q;
    } */
}
