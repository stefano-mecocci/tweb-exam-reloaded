<?php

function checkLength($result, $options) {
    if (array_key_exists("length", $options)) {
        return strlen($result) < $options["length"];
    } else {
        return true;
    }
}

function filterField($options) {
    $result = null;

    if (array_key_exists("filter", $options)) {
        if ($options["filter"] == FILTER_VALIDATE_REGEXP) {
            $result = filter_input(INPUT_POST, $options["field"], FILTER_VALIDATE_REGEXP, [
                "options" => ["regexp" => $options["regex"]]
            ]);
        } else {
            $result = filter_input(INPUT_POST, $options["field"], $options["filter"]);
        }
    } else {
        $result = filter_input(INPUT_POST, $options["field"], FILTER_DEFAULT);
    }

    if ($result != null && $result != false && checkLength($result, $options)) {
        return $_POST[$options["field"]];
    } else {
        sendResponse($options["message"]);
    }
}

// new API
function filterByRegex($field, $regex) {
    $result = filter_input(INPUT_POST, $field, FILTER_VALIDATE_REGEXP, [
        "options" => ["regexp" => $regex]
    ]);

    if (!$result) {
        return null;
    } else {
        return $result;
    }
}

function filterAnInt($field, $min, $max = -1) {
    $options = ["min_range" => $min];

    if ($max != -1) {
        $options["max_range"] = $max;
    }

    $result = filter_input(INPUT_POST, $field, FILTER_VALIDATE_INT, [
        "options" => $options
    ]);

    if (!$result) {
        return null;
    } else {
        return $result;
    }
}

function filterDefault($field, $length = 0) {
    $result = filter_input(INPUT_POST, $field, FILTER_DEFAULT);

    if (!$result) {
        return null;
    } else {
        if ($length == 0 || ($length > 0 && strlen($result) < $length)) {
            return $result;
        } else {
            return null;
        }
    }
}

function getErrorMsg($translations, $field) {
    return "Il campo " . $translations[$field] . " non va bene";
}

/* function filterDate($field) {

} */

function checkParams($params, $callback) {
    foreach ($params as $k => $v) {
        if ($v == null) {
            $callback($k, $v);
        }
    }
}
