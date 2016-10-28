<?php

include_once(__DIR__ . DIRECTORY_SEPARATOR . 'yxml.class.php');

// Initializing
$yxml = new yxml('user', 'key', true);

// Get XML search result for keyword "keyword example" and region 213 (Moscow)
$result = $yxml->getResult('keyword example', 213);

// If result don't have errors
if ($result != false) {

    // Search domain "example.ru" position
    $position = $yxml->position('example.ru');

    if ($position != false) {
        echo 'Domain position: ' . $position;
    } else {
        echo 'Domain not found in search results';
    }

} else {
    echo 'Errors in XML search result';
}

// Debug log
echo '<pre>' . $yxml->log() . '</pre>';