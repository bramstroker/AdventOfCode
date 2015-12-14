<?php
$secretKey = 'ckczppom';

function findLowestNumber($secretKey, $stopAtPrefix = '00000')
{
    $i = 0;
    while (true) {
        $i++;
        $hash = md5($secretKey . $i);
        if (substr($hash, 0, strlen($stopAtPrefix)) === $stopAtPrefix) {
            return $i;
        }
    }
}

assert(findLowestNumber('abcdef') == 609043);
assert(findLowestNumber('pqrstuv') == 1048970);

echo sprintf('Part 1 answer: %s', findLowestNumber($secretKey, '00000')) . PHP_EOL;
echo sprintf('Part 2 answer: %s', findLowestNumber($secretKey, '000000'));