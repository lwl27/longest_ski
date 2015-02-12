#!/usr/bin/env php
<?php

// Brute force method

function longestPath($curr_i, $curr_j, $data) {
    $path_length = array(0, 0, 0, 0);

    // Check North
    if ($curr_i - 1 > 0 && isset($data[$curr_i - 1][$curr_j]) && $data[$curr_i][$curr_j] > $data[$curr_i - 1][$curr_j]) {
      $path_length[0] = longestPath($curr_i - 1, $curr_j, $data) + 1;
    }

    // Check South
    if ($curr_i + 1 > 0 && isset($data[$curr_i + 1][$curr_j]) && $data[$curr_i][$curr_j] > $data[$curr_i + 1][$curr_j]) {
      $path_length[1] = longestPath($curr_i + 1, $curr_j, $data) + 1;
    }

    // Check East
    if ($curr_j + 1 > 0 && isset($data[$curr_i][$curr_j + 1]) && $data[$curr_i][$curr_j] > $data[$curr_i][$curr_j + 1]) {
      $path_length[2] = longestPath($curr_i, $curr_j + 1, $data) + 1;
    }

    // Check West
    if ($curr_j - 1 > 0 && isset($data[$curr_i][$curr_j - 1]) && $data[$curr_i][$curr_j] > $data[$curr_i][$curr_j - 1]) {
      $path_length[3] = longestPath($curr_i, $curr_j - 1, $data) + 1;
    }

    return max($path_length);
}

// MAIN

//$data = array(array(4, 4), 
//  array(4, 8, 7, 3),
//  array(2, 5, 9, 3),
//  array(6, 3, 2, 5),
//  array(4, 4, 1, 6),
//);

$data = array();
$str = file_get_contents($argv[1]);
foreach (explode(PHP_EOL, $str) as $line) {
  $line_arr = array();
  foreach (preg_split('/\s+/', trim($line)) as $item) {
    $line_arr[] = $item;
  }
  $data[] = $line_arr;
}

for ($i = 0; $i < count($data); $i++) {
  if (count($data[$i]) > 2) {
    for ($j = 0; $j < count($data[$i]); $j++) {
      print $i.' '.$j.' '.longestPath($i, $j, $data).PHP_EOL;
    }
  }
}

exit;
