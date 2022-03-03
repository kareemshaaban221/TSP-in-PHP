<?php


class Graph {

    public $g = [];

    function __construct(array $adMat){
        $this->g = $adMat;
    }

    function cost($v1, $v2) {
        return $this->g[$v1][$v2];
    }

    function distance(array $path){
        
        $n = count($path);

        $d = 0;

        for($i = 0; $i < $n - 1; $i++){
            $d += $this->cost($path[$i], $path[$i+1]);
        }

        return $d;

    }

}


$g = new Graph([
//   0   1   2   3
    [0, 10, 15, 20], // 0
    [5,  0,  9, 10], // 1
    [6, 13,  0, 12], // 2
    [8,  8,  9,  0]  // 3
]);

// echo $g->distance([0, 1, 2, 3, 0]); // test

$start = 0;

$routes = [];

$dis = 0;

for($i = 1; $i <= 3; $i++){
    $dis += $g->cost($start, $i);
}

function find_paths($currentNode, Graph $graph, $path, $distance) {

    $path[] = $currentNode;

    $pathLen = count($path);

    if ($pathLen > 1){
        $distance += $graph->distance([ $path[$pathLen - 2], $currentNode ]);
    }

    if ( ( count($graph->g) == $pathLen ) && ( $graph->g[ $path[$pathLen-1] ][ $path[0] ] > 0 ) ) {
        global $routes;

        $path[] = $path[0];

        $distance += $graph->distance([ $path[$pathLen - 2], $currentNode ]);

        $routes[] = [$distance, $path];

        return;
    }

    foreach($graph->g as $node => $others){
        if (!in_array($node, $path) && $graph->g[$node][$currentNode] > 0){
            find_paths($node, $graph, $path, $distance);
        }
    }

}

find_paths(0, $g, [], 0);


var_dump($routes);