<?php
$distances = [];

foreach (file('9.txt') as $line) {
    $parts = explode(' ', $line);

    $distances[$parts[0]][$parts[2]] = $parts[4];
    $distances[$parts[2]][$parts[0]] = $parts[4];

    $destinations = array_unique(array_keys($distances));
}

function calculateAllPossibleRoutes($destinations, $route = array( ), &$routes = array()) {
    if (empty($destinations)) {
        $routes[] = $route;
    }  else {
        for ($i = count($destinations) - 1; $i >= 0; --$i) {
            $newDestinations = $destinations;
            $newRoute = $route;
            list($foo) = array_splice($newDestinations, $i, 1);
            array_unshift($newRoute, $foo);
            calculateAllPossibleRoutes($newDestinations, $newRoute, $routes);
        }
    }
}

$routes = [];
calculateAllPossibleRoutes($destinations, [], $routes);

$lowestDistance = null;
$highestDistance = null;

foreach ($routes as $route) {
    $totalDistance = 0;
    for ($i = 0; $i < count($route) - 1; $i++) {
        $distance = $distances[$route[$i]][$route[$i+1]];
        $totalDistance += $distance;
    }
    if ($lowestDistance == null || $totalDistance < $lowestDistance) {
        $lowestDistance = $totalDistance;
    }
    if ($highestDistance == null || $totalDistance > $highestDistance) {
        $highestDistance = $totalDistance;
    }
}

echo 'Part 1 answer: ' . $lowestDistance . PHP_EOL;
echo 'Part 2 answer: ' . $highestDistance;