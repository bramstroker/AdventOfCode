<?php
$decodedJson = json_decode(file_get_contents('12.json'), true);

function resursivelyFindNumbers($json, &$numbersFound = [])
{
    foreach ($json as $key => $val) {
        if (is_numeric($val)) {
            $numbersFound[] = (int) $val;
        }
        if (is_array($json[$key])) {
            resursivelyFindNumbers($json[$key], $numbersFound);
        }
    }
}

$numbersFound = [];
resursivelyFindNumbers($decodedJson, $numbersFound);

echo sprintf('Part 1 answer: %s', array_sum($numbersFound)) . PHP_EOL;