<?php

function redirectTo($location) {
    header("Location: " . $location);
    exit();
}