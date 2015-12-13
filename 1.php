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

    // For second part
    if ($floor < 0 && !isset($basementHitAt)) {
        $basementHitAt = $i + 1;
    }
}

echo 'First part answer:' . $floor . PHP_EOL;
echo 'Second part answer:' . $basementHitAt . PHP_EOL;