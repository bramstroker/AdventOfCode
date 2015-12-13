<?php

function convertValue($input)
{
    $occurances = 1;
    $output = '';
    foreach (str_split($input) as $number) {
        $number = (int) $number;

        if (isset($previousNumber)) {
            if ($number == $previousNumber) {
                $occurances++;
            } else {
                $output .= $occurances . $previousNumber;
                $occurances = 1;
            }
        }
        $previousNumber = $number;
    }
    $output .= $occurances . $number;
    return $output;
}

function resursiveConvert($input, $maxIterations, $iteration = 1)
{
    $output = convertValue($input);

    if ($maxIterations == $iteration) {
        return $output;
    }
    return resursiveConvert($output, $maxIterations, ++$iteration);
}

assert(convertValue('1') == '11');
assert(convertValue('11') == '21');
assert(convertValue('21') == '1211');
assert(convertValue('1211') == '111221');
assert(convertValue('111221') == '312211');

echo 'Part 1 answer: ' . strlen(resursiveConvert(3113322113, 40));
echo 'Part 2 answer: ' . strlen(resursiveConvert(3113322113, 50));