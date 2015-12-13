<?php
function calculatePaperSize($presentDimensions)
{
    list($l, $w, $h) = explode('x', $presentDimensions);

    $sides = [
        $l * $w,
        $w * $h,
        $h * $l
    ];

    $paperNeeded = 0;
    foreach ($sides as $side) {
        $paperNeeded += 2 * $side;
    }

    // Add extra paper (smallest side)
    $paperNeeded += min($sides);

    return $paperNeeded;
}

assert(calculatePaperSize('2x3x4') == 58);
assert(calculatePaperSize('1x1x10') == 43);

$presentDimensions = file('2.txt');
$totalPaperNeeded = 0;
foreach($presentDimensions as $dim) {
    $totalPaperNeeded += calculatePaperSize($dim);
}

echo $totalPaperNeeded;
