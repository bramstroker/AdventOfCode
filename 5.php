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

assert(isNiceString('ugknbfddgicrmopn') === true);
assert(isNiceString('aaa') === true);
assert(isNiceString('jchzalrnumimnmhp') === false);
assert(isNiceString('haegwjzuvuyypxyu') === false);
assert(isNiceString('dvszwmarrgswjxmb') === false);

$countNiceWords = 0;
foreach (file('5.txt') as $string) {
    if (isNiceString($string)) {
        $countNiceWords++;
    }
}

echo $countNiceWords;