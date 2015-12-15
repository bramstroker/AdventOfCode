<?php
$input = file_get_contents('1.txt');

$floor = 0;
$i = 0;
foreach (str_split($input) as $char) {
    if ($char == '(') {
        $floor++;
    }

    if ($char == ')') {
        $floor--;
    }

    // For second part
    if ($floor < 0 && !isset($basementHitAt)) {
        $basementHitAt = $i + 1;
    }
    $i++;
}

echo 'First part answer:' . $floor . PHP_EOL;
echo 'Second part answer:' . $basementHitAt . PHP_EOL;