<?php
class PresentDeliverer
{
    /** @var array */
    protected $presentCount = [];

    /** @var array */
    protected $positions = [];

    /** @var array */
    protected $persons = [];

    public function __construct($persons = [])
    {
        $this->persons = $persons;
        $this->reset();
    }

    /**
     * @param $route
     * @return array
     */
    public function doDelivery($route)
    {
        $this->reset();
        foreach ($this->persons as $person) {
            $this->deliverPresent($person);
        }

        foreach (str_split($route) as $i => $command) {
            if (count($this->persons) == 1) {
                $personToAct = $this->persons[0];
            } else {
                $personToAct = $this->persons[$i % 2 == 0 ? 1 : 0];
            }
            $this->move($command, $personToAct);
            $this->deliverPresent($personToAct);
        }
        return $this->presentCount;
    }

    protected function reset()
    {
        foreach ($this->persons as $person) {
            $this->positions[$person] = [0, 0];
        }

        $this->presentCount = [];
    }

    /**
     * @param string $command
     * @param string $who
     */
    protected function move($command, $who) {
        switch ($command) {
            case '^':
                $this->positions[$who][1]--;
                break;
            case 'v':
                $this->positions[$who][1]++;
                break;
            case '>':
                $this->positions[$who][0]++;
                break;
            case '<':
                $this->positions[$who][0]--;
                break;
        }
    }


    /**
     * Delivers a present at the current position on the grid
     */
    private function deliverPresent($who)
    {
        $position = $this->positions[$who];
        $key = implode(':', $position);
        if (!isset($this->presentCount[$key])) {
            $this->presentCount[$key] = 0;
        }
        $this->presentCount[$key]++;
    }
}

$input = file_get_contents('3.txt');

$presentDeliverer1 = new PresentDeliverer(['santa']);
$presentDeliverer2 = new PresentDeliverer(['santa', 'robo']);

/*print_r($presentDeliverer1->doDelivery('>'));
print_r($presentDeliverer1->doDelivery('^>v<'));
print_r($presentDeliverer1->doDelivery('^v^v^v^v^v'));
print_r($presentDeliverer2->doDelivery('^v'));
print_r($presentDeliverer2->doDelivery('^>v<'));
print_r($presentDeliverer2->doDelivery('^v^v^v^v^v'));*/

echo sprintf('Part 1 answer: %s', count($presentDeliverer1->doDelivery($input))) . PHP_EOL;
echo sprintf('Part 2 answer: %s', count($presentDeliverer2->doDelivery($input))) . PHP_EOL;

