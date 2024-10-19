<?php

function fixedNumFilter($length)
{
    return [
        "regex" => "/^[0-9]+$/",
        "min" => $length,
        "max" => $length
    ];
}

function regexFilter($regex)
{
    return [
        "regex" => $regex
    ];
}

function emailFilter()
{
    return [
        "custom" => fn($v) => filter_var($v, FILTER_VALIDATE_EMAIL) != false
    ];
}

function nameFilter()
{
    return [
        "regex" => "/^[A-Za-z]+$/",
        "min" => 3,
        "max" => 40
    ];
}

function getErrorMsg($translations, $field)
{
    if (array_key_exists($field, $translations)) {
        return "Il campo " . $translations[$field] . " non va bene";
    } else {
        return "Il campo " . $field . " non va bene";
    }
}

function _filterInt($field)
{
    return filter_input(INPUT_POST, $field, FILTER_VALIDATE_INT);
}

function _filterArray($field)
{
    return array_map(fn($v) => htmlspecialchars($v), $_POST[$field]);
}

class RequestParser
{
    private array $params;
    private $errorHandler = null;

    public function addParam($name, $type = "string")
    {
        $this->params[$name] = [
            "value" => null,
            "type" => $type,
            "filters" => []
        ];
    }

    public function addFilters($name, $filters)
    {
        $this->params[$name]["filters"] = $filters;
    }

    public function setErrorHandler($handler)
    {
        $this->errorHandler = $handler;
    }

    public function setParams()
    {
        foreach ($this->params as $name => $param) {
            if ($param["type"] == "string") {
                $this->params[$name]["value"] = filter_input(INPUT_POST, $name);
            } else if ($param["type"] == "int") {
                $this->params[$name]["value"] = _filterInt($name);
            } else if ($param["type"] == "array") {
                $this->params[$name]["value"] = _filterArray($name);
            }
        }
    }

    private function applyFilters($param)
    {
        $result = true;
        $filters = $param["filters"];
        $type = $param["type"];
        $value = $param["value"];

        if (array_key_exists("custom", $filters)) {
            $result = $result && $filters["custom"]($value);
        }

        if ($type == "string") {
            if (array_key_exists("regex", $filters)) {
                $result = $result && !!(preg_match($filters["regex"], $value));
            }

            if (array_key_exists("min", $filters)) {
                $result = $result && strlen($value) >= $filters["min"];
            }

            if (array_key_exists("max", $filters)) {
                $result = $result && strlen($value) <= $filters["max"];
            }
        } else if ($type == "int") {
            if (array_key_exists("min", $filters)) {
                $result = $result && $value >= $filters["min"];
            }

            if (array_key_exists("max", $filters)) {
                $result = $result && $value <= $filters["max"];
            }
        } elseif ($type == "array") {
            if (array_key_exists("values", $filters)) {
                foreach ($value as $v) {
                    $result = $result && in_array($v, $filters["values"]);
                }
            }
        }

        return $result;
    }

    private function callErrorHandler($name)
    {
        call_user_func_array($this->errorHandler, [$name]);
    }

    private function checkParams()
    {
        foreach ($this->params as $name => $param) {
            if (!$param["value"]) {
                $this->callErrorHandler($name);
                return false;
            }
        }

        return true;
    }

    private function checkFilters()
    {
        $result = true;

        foreach ($this->params as $name => $param) {
            $result = $result && $this->applyFilters($param);

            if (!$result) {
                $this->callErrorHandler($name);
                break;
            }
        }

        return $result;
    }

    public function parse()
    {
        $this->setParams();

        return $this->checkParams() && $this->checkFilters();
    }

    public function getParams()
    {
        $params = [];

        foreach ($this->params as $name => $param) {
            $params[$name] = $param["value"];
        }

        return $params;
    }
}