<?php

namespace App\Core\Querybuilder;

class SelectQuery extends Query
{
    public array $columns = ["*"];

    public array $orderPiece = [];

    public int|null $limitPiece = null;

    public int|null $offsetPiece = null;

    public function from(string $table)
    {
        $this->table = $table;

        return $this;
    }

    public function columns(array $columns)
    {
        $this->columns = $columns;

        return $this;
    }

    public function orderBy(string $column, SqlOrder $order = SqlOrder::ASC)
    {
        $this->orderPiece = [$column, $order];

        return $this;
    }

    public function limit(int $limit)
    {
        $this->limitPiece = $limit;
        $this->valuesMap["limit"] = $limit;

        return $this;
    }

    public function offset(int $offset)
    {
        $this->offsetPiece = $offset;
        $this->valuesMap["offset"] = $offset;

        return $this;
    }
}