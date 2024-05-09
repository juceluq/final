<?php

function split_description($text, $length = 15)
{
    $parts = str_split($text, $length);

    if (count($parts) > 2) {
        $parts = array_slice($parts, 0, 2);
        $parts[1] = rtrim($parts[1]) . '...';
    }

    return $parts;
}

function split_title($text, $length = 9)
{
    $parts = str_split($text, $length);
    if (count($parts) > 2) {
        $parts = array_slice($parts, 0, 2);
        $parts[1] .= '...';
    }
    return $parts;
}
