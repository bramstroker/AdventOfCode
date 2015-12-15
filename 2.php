<?php
class Present
{
    private $x;
    private $y;
    private $z;

    public function __construct($x, $y, $z)
    {
        $this->x = (int) $x;
        $this->y = (int) $y;
        $this->z = (int) $z;
    }

    public static function fromString($string)
    {
        $parts = explode('x', $string);
        return new self($parts[0], $parts[1], $parts[2]);
    }

    public function getSides()
    {
        return [
            $this->x * $this->y,
            $this->y * $this->z,
            $this->x * $this->z
        ];
    }

    public function getSurfaceArea()
    {
        return array_sum($this->getSides()) * 2;
    }

    public function getVolume()
    {
        return $this->x * $this->y * $this->z;
    }

    public function getPaperNeeded()
    {
        return $this->getSurfaceArea() + min($this->getSides());
    }

    public function getRibbonNeeded()
    {
        $dimensions = [$this->x, $this->y, $this->z];
        sort($dimensions);
        return $this->getVolume() + ($dimensions[0] * 2 + $dimensions[1] * 2);
    }
}

assert(Present::fromString('2x3x4')->getPaperNeeded() == 58);
assert(Present::fromString('1x1x10')->getPaperNeeded() == 43);
assert(Present::fromString('2x3x4')->getRibbonNeeded() == 34);
assert(Present::fromString('1x1x10')->getRibbonNeeded() == 14);

$totalPaper = 0;
$totalRibbon = 0;
foreach(file('2.txt') as $dimensions) {
    $present = Present::fromString($dimensions);

    $totalPaper += $present->getPaperNeeded();
    $totalRibbon += $present->getRibbonNeeded();
}

echo sprintf('Part 1 answer: %s', $totalPaper) . PHP_EOL;
echo sprintf('Part 2 answer: %s', $totalRibbon) . PHP_EOL;
