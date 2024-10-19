<?php

namespace App\Core\Querybuilder;

class DeleteQuery extends Query
{
    public string $table;

    public function from(string $table)
    {
        $this->table = $table;

        return $this;
    }
}