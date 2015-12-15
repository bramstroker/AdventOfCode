<?php
function generatePassword($password)
{
    $passwordLength = strlen($password);
    while(true) {
        $password++;

        if (strlen($password) > $passwordLength) {
            break;
        }

        if (isValid($password)) {
            return $password;
        }
    }
    return false;
}

function isValid($password) {
    if (preg_match('/[iol]/', $password) > 0) {
        return false;
    }

    if (preg_match('/(.)\1.*(.)\2/', $password) == 0) {
        return false;
    }

    if (preg_match('/abc|bcd|cde|def|efg|fgh|ghi|hij|ijk|jkl|klm|lmn|mno|nop|opq|pqr|qrs|rst|stu|tuv|uvw|vwx|wxy|xyz/', $password) == 0) {
        return false;
    }

    return true;
}

/*assert(isValid('hijklmmn') == false);
assert(isValid('abbceffg') == false);
assert(isValid('abbcegjk') == false);
assert(isValid('abcdffaa') == true);
assert(generatePassword('abcdefgh') == 'abcdffaa');
assert(generatePassword('ghijklmn') == 'ghjaabcc');*/

echo sprintf('Part 1 answer: %s', generatePassword('cqjxjnds')) . PHP_EOL;
echo sprintf('Part 2 answer: %s', generatePassword('cqjxxyzz'));

// Generate regex
/*$string = '';
for ($i = 97; $i < 121; $i++) {
    $string .= chr($i) . chr($i+1) . chr($i + 2) . '|';
}
echo $string;*/