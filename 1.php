<?php
$input = file_get_contents('1.txt');

$floor = 0;
for ($i = 0; $i < strlen($input); $i++) {
    $char = substr($input, $i, 1);

    if ($char == '(') {
        $floor++;
    }

    if ($char == ')') {
        $floor--;
    }
}

echo $floor;