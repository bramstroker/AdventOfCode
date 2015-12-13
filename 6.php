<?php

class LightGrid
{
    /**
     * @var array
     */
    protected $lights = [];

    /**
     *
     */
    public function __construct()
    {
        // Construct the grid and turn off all lights by default
        for ($x = 0; $x < 1000; $x++) {
            for ($y = 0; $y < 1000; $y++) {
                $this->lights[$x][$y] = false;
            }
        }
    }

    /**
     * @param LightSwitchCommand $command
     */
    public function toggleLights(LightSwitchCommand $command)
    {
        for ($x = $command->getFrom()->getX(); $x <= $command->getTo()->getX(); $x++) {
            for ($y = $command->getFrom()->getY(); $y <= $command->getTo()->getY(); $y++) {
                if ($command->getCommand() == LightSwitchCommand::COMMAND_TOGGLE) {
                    $newState = !$this->lights[$x][$y];
                } else {
                    $newState = ($command->getCommand() == LightSwitchCommand::COMMAND_ON) ? true : false;
                }
                $this->lights[$x][$y] = $newState;
            }
        }
    }

    public function getLights()
    {
        return $this->lights;
    }

    /**
     * @return int
     */
    public function getNumLightsLit()
    {
        $numLit = 0;
        for ($x = 0; $x < 1000; $x++) {
            for ($y = 0; $y < 1000; $y++) {
                if ($this->lights[$x][$y] === true) {
                    $numLit++;
                }
            }
        }
        return $numLit;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        $output = '';
        for ($y = 0; $y < 1000; $y++) {
            for ($x = 0; $x < 1000; $x++) {
                $output .= ($this->lights[$x][$y]) ? 1 : 0;
            }
            $output .= PHP_EOL;
        }
        return $output;
    }

}

class Coordinate
{
    /**
     * @var int
     */
    private $x;

    /**
     * @var int
     */
    private $y;

    /**
     * @param int $x
     * @param int $y
     */
    public function __construct($x, $y)
    {
        $this->x = (int) $x;
        $this->y = (int) $y;
    }

    /**
     * @return int
     */
    public function getX()
    {
        return $this->x;
    }

    /**
     * @return int
     */
    public function getY()
    {
        return $this->y;
    }

    public static function fromString($string)
    {
        list($x, $y) = explode(',', $string);
        return new self($x, $y);
    }
}

class LightSwitchCommand
{
    const COMMAND_ON = 1;
    const COMMAND_OFF = 2;
    const COMMAND_TOGGLE = 3;

    /**
     * @var Coordinate
     */
    protected $from;

    /**
     * @var Coordinate
     */
    protected $to;

    /**
     * @var string
     */
    protected $command;

    /**
     * @param Coordinate $from
     * @param Coordinate $to
     * @param string $command
     */
    public function __construct(Coordinate $from, Coordinate $to, $command)
    {
        $this->from = $from;
        $this->to = $to;
        $this->command = $command;
    }

    /**
     * @return Coordinate
     */
    public function getFrom()
    {
        return $this->from;
    }

    /**
     * @return Coordinate
     */
    public function getTo()
    {
        return $this->to;
    }

    /**
     * @return string
     */
    public function getCommand()
    {
        return $this->command;
    }
}

class CommandParser
{
    /**
     * @param $string
     * @return LightSwitchCommand
     */
    public function parseCommand($string)
    {
        if (preg_match('/(toggle|turn on|turn off) (.*) through (.*)/', $string, $matches) == 0)
        {
            throw new \InvalidArgumentException('Could not parse the instruction "' . $string . '"');
        }

        switch ($matches[1]) {
            case 'toggle':
                $command = LightSwitchCommand::COMMAND_TOGGLE;
                break;
            case 'turn on':
                $command = LightSwitchCommand::COMMAND_ON;
                break;
            case 'turn off':
            default:
                $command = LightSwitchCommand::COMMAND_OFF;
        }

        return new LightSwitchCommand(
            Coordinate::fromString($matches[2]),
            Coordinate::fromString($matches[3]),
            $command
        );
    }
}

$parser = new CommandParser();
$lightGrid = new LightGrid();

foreach (file('6.txt') as $instruction) {
    echo 'excecuting ' . $instruction . PHP_EOL;
    $lightGrid->toggleLights($parser->parseCommand($instruction));
}

echo 'answer is: ' . $lightGrid->getNumLightsLit();

