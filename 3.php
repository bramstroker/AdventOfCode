<?php
class PresentDeliverer
{
    /** @var array */
    private $presentCount = [];

    /** @var array */
    private $position = [0, 0];

    /**
     * @param $route
     * @return array
     */
    public function doDelivery($route)
    {
        $this->reset();
        $this->deliverPresent();
        for ($i = 0; $i < strlen($route); $i++) {
            $command = substr($route, $i, 1);
            $this->move($command);
            $this->deliverPresent();
        }
        return $this->presentCount;
    }

    private function reset()
    {
        $this->position = [0, 0];
        $this->presentCount = [];
    }

    /**
     * @param string $command
     */
    private function move($command) {
        switch ($command) {
            case '^':
                $this->position[1]--;
                break;
            case 'v':
                $this->position[1]++;
                break;
            case '>':
                $this->position[0]++;
                break;
            case '<':
                $this->position[0]--;
                break;
        }
    }

    /**
     * Delivers a present at the current position on the grid
     */
    private function deliverPresent()
    {
        $key = implode(':', $this->position);
        if (!isset($this->presentCount[$key])) {
            $this->presentCount[$key] = 0;
        }
        $this->presentCount[$key]++;
    }
}

$presentDeliverer = new PresentDeliverer();

/*print_r($presentDeliverer->doDelivery('>'));
print_r($presentDeliverer->doDelivery('^>v<'));
print_r($presentDeliverer->doDelivery('^v^v^v^v^v'));*/

$presentCounts = $presentDeliverer->doDelivery(file_get_contents('3.txt'));
echo count($presentCounts);