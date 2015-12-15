<?php
$string = '';
foreach (file('8.txt') as $line) {
    $string += $line;
}