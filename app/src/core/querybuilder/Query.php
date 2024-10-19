<?php

namespace App\Core\Querybuilder;

class Query
{
    public string $table;

    public array $conditions = [];

    public array $valuesMap = [];

    public function where()
    {
        return $this;
    }

    public function subWhere()
    {
        $this->conditions[] = "(";

        return $this;
    }

    // ends a condition block
    public function end()
    {
        $this->conditions[] = ")";

        return $this;
    }

    public function cond(string $field, SqlOperators $operator, $value)
    {
        $placeholder = ":$field";
        $this->valuesMap[$field] = $value;

        $this->conditions[] = "$field {$operator->value} $placeholder";

        return $this;
    }

    public function and()
    {
        array_push($this->conditions, SqlOperators::AND );

        return $this;
    }

    public function or()
    {
        array_push($this->conditions, SqlOperators::OR );

        return $this;
    }

    public function getValuesMap()
    {
        return $this->valuesMap;
    }
}
