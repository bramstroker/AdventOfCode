<?php

$lines = [
    'Comet can fly 14 km/s for 10 seconds, but then must rest for 127 seconds.',
    'Dancer can fly 16 km/s for 11 seconds, but then must rest for 162 seconds.'
];

$lines = file('14.txt');

$race = new Race();

// Add reindeers to race
foreach ($lines as $line) {
    preg_match('/(.*) can fly ([0-9]+) km\/s for ([0-9]+) seconds, but then must rest for ([0-9]+) seconds\./', $line, $matches);
    $race->addReindeer(new Reindeer($matches[1], $matches[2], $matches[3], $matches[4]));
}

$race->startRace(2503);
$winner = $race->getWinner();

echo sprintf('Part 1 answer: %s', $winner->getDistanceCovered()) . PHP_EOL;

class Race
{
    /** @var Reindeer[] */
    protected $reindeers = [];

    /**
     * @param Reindeer $reindeer
     */
    public function addReindeer(Reindeer $reindeer)
    {
        $this->reindeers[] = $reindeer;
    }

    /**
     * @param int $duration
     */
    public function startRace($duration)
    {
        $secondsElasped = 0;
        do {
            array_walk($this->reindeers, function($reindeer) {
                $reindeer->advance();
            });
            $secondsElasped++;
        } while ($secondsElasped < $duration);
    }

    /**
     * @return Reindeer
     */
    public function getWinner()
    {
        usort($this->reindeers, function(Reindeer $a, Reindeer $b) {
            if ($a->getDistanceCovered() == $b->getDistanceCovered()) {
                return 0;
            }
            return ($a->getDistanceCovered() < $b->getDistanceCovered()) ? -1 : 1;
        });
        return end($this->reindeers);
    }
}

class Reindeer
{
    const STATE_RESTING = 1;
    const STATE_FLYING = 2;

    /** @var string */
    protected $currentState = self::STATE_FLYING;

    /** @var string */
    protected $name;

    /** @var int */
    protected $flySpeed;

    /** @var int */
    protected $flyDuration;

    /** @var int */
    protected $restDuration;

    /** @var int */
    protected $distanceCovered = 0;

    /** @var int */
    protected $counter = 0;

    /**
     * @param string $name
     * @param int $flySpeed
     * @param int $flyDuration
     * @param int $restDuration
     */
    public function __construct($name, $flySpeed, $flyDuration, $restDuration)
    {
        $this->name = $name;
        $this->flySpeed = (int) $flySpeed;
        $this->flyDuration = (int) $flyDuration;
        $this->restDuration = (int) $restDuration;
        $this->counter = (int) $flyDuration;
    }

    /**
     * Advance the Reindier
     */
    public function advance()
    {
        if ($this->currentState == self::STATE_FLYING) {
            $this->distanceCovered += $this->flySpeed;
        }

        if (--$this->counter === 0) {
            $this->currentState = ($this->currentState == self::STATE_FLYING) ? self::STATE_RESTING : self::STATE_FLYING;
            $this->counter = $this->currentState == self::STATE_FLYING ? $this->flyDuration : $this->restDuration;
        }
    }

    /**
     * @return int
     */
    public function getDistanceCovered()
    {
        return $this->distanceCovered;
    }
}