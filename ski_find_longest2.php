#!/usr/bin/env php
<?php

// MAIN

$data = [];
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
print "Size of data = {$max_i} x {$max_j} = ".($max_i * $max_j).PHP_EOL;

$topo_sorted_data = explode(PHP_EOL, trim(file_get_contents($argv[2])));
print "Size of topo sorted data = ".count($topo_sorted_data).PHP_EOL;

$computed = [];
$best_node = null;
foreach (array_reverse($topo_sorted_data) as $node) {
  list($i, $j) = explode('-', $node);
  $computed[$node] = [ 'height' => intval($data[$i][$j]), 'longest_path' => 1, 'base_height' => intval($data[$i][$j]) ];

  // Check North
  if ($i - 1 >= 0 && isset($data[$i - 1][$j])) {
    $north_node = strval(($i - 1).'-'.$j);
    if ($data[$i][$j] > $data[$i - 1][$j] && $computed[$node]['longest_path'] < $computed[$north_node]['longest_path'] + 1) {
      $computed[$node]['longest_path'] = $computed[$north_node]['longest_path'] + 1;
      $computed[$node]['base_height'] = $computed[$north_node]['base_height'];
    }
  }

  // Check South
  if ($i + 1 < $max_i && isset($data[$i + 1][$j])) {
    $south_node = strval(($i + 1).'-'.$j);
    if ($data[$i][$j] > $data[$i + 1][$j] && $computed[$node]['longest_path'] < $computed[$south_node]['longest_path'] + 1) {
       $computed[$node]['longest_path'] = $computed[$south_node]['longest_path'] + 1;
       $computed[$node]['base_height'] = $computed[$south_node]['base_height'];
    }
  }
  // Check East
  if ($j + 1 < $max_j && isset($data[$i][$j + 1])) {
    $east_node = strval($i.'-'.($j + 1));
    if ($data[$i][$j] > $data[$i][$j + 1] && $computed[$node]['longest_path'] < $computed[$east_node]['longest_path'] + 1) {
       $computed[$node]['longest_path'] = $computed[$east_node]['longest_path'] + 1;
       $computed[$node]['base_height'] = $computed[$east_node]['base_height'];
    }
  }
  // Check West
  if ($j - 1 >= 0 && isset($data[$i][$j - 1])) {
    $west_node = strval($i.'-'.($j - 1));
    if ($data[$i][$j] > $data[$i][$j - 1] && $computed[$node]['longest_path'] < $computed[$west_node]['longest_path'] + 1) {
       $computed[$node]['longest_path'] = $computed[$west_node]['longest_path'] + 1;
       $computed[$node]['base_height'] = $computed[$west_node]['base_height'];
    }
  }

  $computed[$node]['drop'] = $computed[$node]['height'] - $computed[$node]['base_height'];

  // Checking if it's the BEST NODE
  if (is_null($best_node) || ($best_node['longest_path'] <= $computed[$node]['longest_path'] && $best_node['drop'] < $computed[$node]['drop']))
    $best_node = $computed[$node];
}
//print_r($computed);
print "BEST NODE = ".print_r($best_node, true);

exit;
