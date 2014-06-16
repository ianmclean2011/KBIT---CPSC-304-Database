<?php

function idGen()
{
    $first = rand(0,60);
    $second = rand(0,60);
    $third = rand(0,60);
    $fourth = rand(0,60);
    $fifth = rand(0,60);
    $sixth = rand(0,60);
    $letters = "0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ";
    $l1 = $letters[$first];
    $l2 = $letters[$second];
    $l3 = $letters[$third];
    $l4 = $letters[$fourth];
    $l5 = $letters[$fifth];
    $l6 = $letters[$sixth];
    return $l1.$l2.$l3.$l4.$l5.$l6;
}

?>