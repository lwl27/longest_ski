#!/usr/bin/env php
<?php

function topological_sort($nodeids, $edges) {

  // initialize variables
  $L = $S = $nodes = array(); 

  // remove duplicate nodes
  $nodeids = array_unique($nodeids);  

  // remove duplicate edges
  $hashes = array();
  foreach($edges as $k=>$e) {
    $hash = md5(serialize($e));
    if (in_array($hash, $hashes)) { unset($edges[$k]); }
    else { $hashes[] = $hash; }; 
  }

  // Build a lookup table of each node's edges
  foreach($nodeids as $id) {
    $nodes[$id] = array('in'=>array(), 'out'=>array());
    foreach($edges as $e) {
      if ($id==$e[0]) { $nodes[$id]['out'][]=$e[1]; }
      if ($id==$e[1]) { $nodes[$id]['in'][]=$e[0]; }
    }
  }
  //print_r($nodes);

  // While we have nodes left, we pick a node with no inbound edges, 
  // remove it and its edges from the graph, and add it to the end 
  // of the sorted list.
  foreach ($nodes as $id=>$n) { if (empty($n['in'])) $S[]=$id; }
  while (!empty($S)) {
    $L[] = $id = array_shift($S);
    foreach($nodes[$id]['out'] as $m) {
      $nodes[$m]['in'] = array_diff($nodes[$m]['in'], array($id));
      if (empty($nodes[$m]['in'])) { $S[] = $m; }
    }
    $nodes[$id]['out'] = array();
  }

  // Check if we have any edges left unprocessed
  foreach($nodes as $n) {
    if (!empty($n['in']) or !empty($n['out'])) {
      return null; // not sortable as graph is cyclic
    }
  }
  return $L;
}

// MAIN
//$data = array(array(4, 4), 
//  array(4, 8, 7, 3),
//  array(2, 5, 9, 3),
//  array(6, 3, 2, 5),
//  array(4, 4, 1, 6),
//);

$data = array();
$max_i = -1;
$max_j = -1;
$str = file_get_contents($argv[1]);
foreach (explode(PHP_EOL, trim($str)) as $line) {
  $line_arr = preg_split('/\s+/', trim($line));
  if (count($line_arr) > 2) {
    $data[] = $line_arr;
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
    if ($i - 1 > 0 && isset($data[$i - 1][$j])) {
      if ($data[$i][$j] > $data[$i - 1][$j]) {
        $edges[] = array(strval($i.'-'.$j), strval(($i - 1).'-'.$j));
        //$edges[] = array($i * $max_i + $j, ($i - 1) * $max_i + $j);
      } else {
        $has_incoming = true;
      }
    }

    // Check South
    if ($i + 1 > 0 && isset($data[$i + 1][$j])) {
      if ($data[$i][$j] > $data[$i + 1][$j]) {
        $edges[] = array(strval($i.'-'.$j), strval(($i + 1).'-'.$j));
        //$edges[] = array($i * $max_i + $j, ($i + 1) * $max_i + $j);
      } else {
        $has_incoming = true;
      }
    }

    // Check East
    if ($j + 1 > 0 && isset($data[$i][$j + 1])) {
      if ($data[$i][$j] > $data[$i][$j + 1]) {
        $edges[] = array(strval($i.'-'.$j), strval($i.'-'.($j + 1)));
        //$edges[] = array($i * $max_i + $j, $i * $max_i + ($j + 1));
      } else {
        $has_incoming = true;
      }
    }

    // Check West
    if ($j - 1 > 0 && isset($data[$i][$j - 1])) {
      if ($data[$i][$j] > $data[$i][$j - 1]) {
        $edges[] = array(strval($i.'-'.$j), strval($i.'-'.($j - 1)));
        //$edges[] = array($i * $max_i + $j, $i * $max_i + ($j - 1));
      } else {
        $has_incoming = true;
      }
    }

    //if (!$has_incoming)
      $nodes[] = strval($i.'-'.$j);
  }
}
//print_r($nodes);
//print_r($edges);

//$nodes = array('1','2','3','4','5');
//$edges = array(array('1','2'),
//               array('3','1'),
//               array('3','4'));

var_dump(topological_sort($nodes, $edges));

exit;
