<?php

function bigNumber() : int
{
    # prevent the first number from being 0
    $output = rand(1,9);

    for($i=0; $i<74; $i++) {
    $output .= rand(0,9);
    }

    return $output;
}
