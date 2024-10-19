<?php

function prevent_xss($book)
{
    foreach (array_keys($book) as $key) {
        if ($book[$key] == null) {
            continue;
        }

        $book[$key] = htmlspecialchars($book[$key], ENT_QUOTES, 'UTF-8');
    }

    return $book;
}

function format_price($price)
{
    $priceStr = strval($price);

    return substr($priceStr, 0, -2) . "," . substr($priceStr, -2) . " €";
}

function get_cover_path($id)
{
    return "/books_covers/cover" . $id . ".jpg";
}