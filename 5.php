<?php

function isNiceString($string)
{
    // Check for at least 3 vowels
    $countVowels = 0;
    if (preg_match_all('/[aeiou]+/', $string, $matches) > 0) {
        foreach ($matches[0] as $vowels) {
            $countVowels += strlen($vowels);
            if ($countVowels >= 3) {
                break;
            }
        }
    }

    if ($countVowels < 3) {
        return false;
    }

    // One letter twice in a row
    if (preg_match('/([a-z])\1+/', $string) == 0) {
        return false;
    }

    // Blacklisted strings
    if (preg_match('/(ab|cd|pq|xy)/', $string) > 0) {
        return false;
    }

    return true;
}

function isNiceString2($string)
{
    // Pair of two letters at least twice in the string
    preg_match_all('/(?=([a-z]{2}))/', $string, $matches);
    if (count(array_unique($matches[1])) === count($matches[1])) {
        return false;
    }

    // Same character twice with one character between them
    $ruleMet = false;
    foreach (range('a', 'z') as $char) {
        if (preg_match('/' . $char . '[a-z]{1}' . $char . '/', $string) > 0) {
            $ruleMet = true;
            break;
        }
    }
    if (!$ruleMet) {
        return false;
    }

    return true;
}

assert(isNiceString('ugknbfddgicrmopn') === true);
assert(isNiceString('aaa') === true);
assert(isNiceString('jchzalrnumimnmhp') === false);
assert(isNiceString('haegwjzuvuyypxyu') === false);
assert(isNiceString('dvszwmarrgswjxmb') === false);
assert(isNiceString2('qjhvhtzxzqqjkmpb') === true);
assert(isNiceString2('xxyxx') === true);
assert(isNiceString2('uurcxstgmygtbstg') === false);
assert(isNiceString2('ieodomkazucvgmuy') === false);
assert(isNiceString2('xxxddetvrlpzsfpq') === false);

$countNiceWords = 0;
$countNiceWords2 = 0;
foreach (file('5.txt') as $string) {
    if (isNiceString($string)) {
        $countNiceWords++;
    }
    if (isNiceString2($string)) {
        echo $string . PHP_EOL;
        $countNiceWords2++;
    }
}

echo sprintf('Part 1 answer: %s', $countNiceWords) . PHP_EOL;
echo sprintf('Part 2 answer: %s', $countNiceWords2) . PHP_EOL;