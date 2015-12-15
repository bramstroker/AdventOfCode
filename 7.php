<?php
//middleware solution

$wires = [];

$instructions = [
    '123 -> x',
    '456 -> y',
    'x AND y -> d',
    'x OR y -> e',
    'x LSHIFT 2 -> f',
    'y RSHIFT 2 -> g',
    'NOT x -> h',
    'NOT y -> i',
];

//$instructions = file('7.txt');

$circuit = new Circuit();
foreach ($instructions as $instruction) {
    $circuit->processInstruction($instruction);
}

print_r($circuit->getWires());

class Circuit
{
    private $wires = [];

    public function processInstruction($instruction)
    {
        preg_match('/^(?<a>.* ?)(?<operator>(AND|OR|LSHIFT|RSHIFT|NOT))? ?(?<b>.*) -> (?<wire>.*)$/', $instruction, $matches);
        print_r($matches);
        // We are dealing with a gate
        if (!empty($matches['operator'])) {
            $gate = new LogicGate;
            $input = $gate->process($matches['operator'], $this->getValue($matches['a']), $this->getValue($matches['b']));
        } else {
            $input = !empty($matches['a']) ? $matches['a'] : $matches['b'];
            $input = $this->getValue($input);
        }

        $this->wires[$matches['wire']] = $input;
    }

    public function getValue($input)
    {
        return is_numeric($input) ? (int) $input : $this->getWireValue($input);
    }

    public function getWireValue($wire)
    {
        if (!array_key_exists($wire, $this->wires)) {
            $this->wires[$wire] = null;
        }
        return $this->wires[$wire];
    }

    public function getWires()
    {
        return $this->wires;
    }
}

class LogicGate
{
    public function process($operator, $valueA, $valueB = null)
    {
        if (in_array($operator, ['AND', 'OR', 'LSHIFT', 'RSHIFT']) && $valueB === null) {
            throw new InvalidArgumentException('b cannot be empty when using ' . $operator . ' operator');
        }
        switch ($operator) {
            case 'AND':
                return $valueA & $valueB;
            case 'OR':
                return $valueA | $valueB;
            case 'LSHIFT':
                return $valueA << $valueB;
            case 'RSHIFT':
                return $valueA >> $valueB;
            case 'NOT':
                return ~ $valueA;
            default:
                throw new InvalidArgumentException(sprintf('Operator "%s" is invalid', $operator));
        }
    }
}