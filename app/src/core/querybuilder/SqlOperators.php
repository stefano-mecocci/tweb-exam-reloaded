<?php

namespace App\Core\Querybuilder;

enum SqlOperators: string
{
    case EQ = '=';
    case GT = '>';
    case AND = 'AND';
    case OR = 'OR';
    case LIKE = 'LIKE';
}

enum SqlOrder: string
{
    case ASC = 'ASC';
    case DESC = 'DESC';
}
