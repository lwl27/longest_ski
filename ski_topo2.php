#!/usr/bin/env php
<?php

/*
 * Ref: http://en.wikipedia.org/wiki/Topological_sorting
 *
 * L ← Empty list that will contain the sorted elements
 * S ← Set of all nodes with no incoming edges
 * while S is non-empty do
 *     remove a node n from S
 *     add n to tail of L
 *     for each node m with an edge e from n to m do
 *         remove edge e from the graph
 *         if m has no other incoming edges then
 *             insert m into S
 * if graph has edges then
 *     return error (graph has at least one cycle)
 * else 
 *     return L (a topologically sorted order)
 */
function topological_sort($nodes, $edges, $data) {
  // Form a lookup for outgoing edges
  $incoming = array();
  foreach ($edges as $edge) {
    $incoming[$edge[1]][$edge[0]] = 1;
  }
  //print_r($incoming);

  $L = array();
  $S = $nodes;
  arsort($S);
  //$S = array_keys($nodes);
  while (count($S) > 0) {
    //$node = array_shift($S);
    $node = array_splice($S, 0, 1);
    $n = array_keys($node)[0];
    $L[] = $n;

    $loop_edges = $edges;
    $looped = array();
    while (count($loop_edges) > 0) {
      $edge = array_shift($loop_edges);
      if ($edge[0] == $n) {
        $m = $edge[1];
        unset($incoming[$m][$n]);
        if (count($incoming[$m]) < 1) {
          list($i, $j) = preg_split('/-/', $m);
          $S[$m] = $data[$i][$j];
          arsort($S);
        }
      } else
        $looped[] = $edge;
    }
    $edges = $looped;

    //print "DEBUG ---".PHP_EOL;
    //print '$S = '.print_r($S, true);
    //print '$L = '.print_r($L, true);
    //readline();
  }

  if (count($edges) > 0) {
    var_dump($edges);
    return null;
  } else
    return $L;
}

// MAIN

$data = array();
$max_i = -1;
$max_j = -1;
$str = file_get_contents($argv[1]);
foreach (explode(PHP_EOL, trim($str)) as $line) {
  $line_arr = preg_split('/\s+/', trim($line));
  if (count($line_arr) > 2) {
    $tmp = array();
    foreach ($line_arr as $item)
      $tmp[] = intval($item);
    $data[] = $tmp;
  } else {
    $max_i = intval($line_arr[0]);
    $max_j = intval($line_arr[1]);
  }
}
//print_r($data);

$nodes = array();
$edges = array();
for ($i = 0; $i < count($data); $i++) {
  for ($j = 0; $j < count($data[$i]); $j++) {
    $has_incoming = false;

    // Check North
    if ($i - 1 >= 0 && isset($data[$i - 1][$j])) {
      if ($data[$i][$j] > $data[$i - 1][$j]) {
        $edges[] = array(strval($i.'-'.$j), strval(($i - 1).'-'.$j));
      } else if ($data[$i][$j] < $data[$i - 1][$j]){
        $has_incoming = true;
      }
    }

    // Check South
    if ($i + 1 < $max_i && isset($data[$i + 1][$j])) {
      if ($data[$i][$j] > $data[$i + 1][$j]) {
        $edges[] = array(strval($i.'-'.$j), strval(($i + 1).'-'.$j));
      } else if ($data[$i][$j] < $data[$i + 1][$j]) {
        $has_incoming = true;
      }
    }

    // Check East
    if ($j + 1 < $max_j && isset($data[$i][$j + 1])) {
      if ($data[$i][$j] > $data[$i][$j + 1]) {
        $edges[] = array(strval($i.'-'.$j), strval($i.'-'.($j + 1)));
      } else if ($data[$i][$j] < $data[$i][$j + 1]) {
        $has_incoming = true;
      }
    }

    // Check West
    if ($j - 1 >= 0 && isset($data[$i][$j - 1])) {
      if ($data[$i][$j] > $data[$i][$j - 1]) {
        $edges[] = array(strval($i.'-'.$j), strval($i.'-'.($j - 1)));
      } else if ($data[$i][$j] < $data[$i][$j - 1]) {
        $has_incoming = true;
      }
    }

    if (!$has_incoming) {
      $nodes[strval($i.'-'.$j)] = $data[$i][$j];
    }

    //readline();
  }
}
//print_r($nodes);
//print_r($edges);

var_dump(topological_sort($nodes, $edges, $data));

exit;
