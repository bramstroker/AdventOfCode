<?php
$secretKey = 'ckczppom';

function findLowestNumber($secretKey)
{
    $i = 0;
    while (true) {
        $i++;
        $hash = md5($secretKey . $i);
        if (substr($hash, 0, 5) === '00000') {
            return $i;
        }
    }
}

assert(findLowestNumber('abcdef') == 609043);
assert(findLowestNumber('pqrstuv') == 1048970);

echo findLowestNumber($secretKey);