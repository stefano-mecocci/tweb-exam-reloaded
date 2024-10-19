<?php

namespace App\Core\Querybuilder;

class InsertQuery extends Query
{
    public array $columns = [];

    public array $values = [];

    public function into(string $table)
    {
        $this->table = $table;

        return $this;
    }

    public function columns(array $columns)
    {
        $this->columns = $columns;

        return $this;
    }

    public function values(array $values)
    {
        $this->values = array_map(fn($v) => ":$v", $this->columns);

        for ($i = 0; $i < count($values); $i++) {
            $this->valuesMap[$this->columns[$i]] = $values[$i];
        }

        return $this;
    }
}