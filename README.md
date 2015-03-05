# longest_ski
Solving a longest ski path problem

## To Run

```bash
php ski_topo_sort2.php actual_data.txt actual_data_topo_sorted.txt

php ski_find_longest2.php acutal_data.txt actual_data_topo_sorted.txt
```

## Sample Test Run

```bash
limwl27@blah:~/longest_ski (master)$ php ski_topo_sort2.php test_data.txt test_data_topo_sorted.txt
Size of data = 4 x 4 = 16
$nodes = 5, $edges = 22
Formed incoming lookup = 11, outgoing lookup = 11
Sorted $S
$S = 4, $L = 1, $incoming = 11, $outgoing = 10
$S = 6, $L = 2, $incoming = 8, $outgoing = 9
$S = 6, $L = 3, $incoming = 7, $outgoing = 8
$S = 6, $L = 4, $incoming = 6, $outgoing = 7
$S = 6, $L = 5, $incoming = 5, $outgoing = 6
$S = 5, $L = 6, $incoming = 5, $outgoing = 5
$S = 5, $L = 7, $incoming = 4, $outgoing = 4
$S = 4, $L = 8, $incoming = 4, $outgoing = 4
$S = 4, $L = 9, $incoming = 3, $outgoing = 3
$S = 4, $L = 10, $incoming = 2, $outgoing = 2
$S = 3, $L = 11, $incoming = 2, $outgoing = 2
$S = 2, $L = 12, $incoming = 2, $outgoing = 2
$S = 2, $L = 13, $incoming = 1, $outgoing = 1
$S = 2, $L = 14, $incoming = 0, $outgoing = 0
$S = 1, $L = 15, $incoming = 0, $outgoing = 0
$S = 0, $L = 16, $incoming = 0, $outgoing = 0
$sorted = 16
limwl27@blah:~/longest_ski (master)$ php ski_find_longest2.php test_data.txt test_data_topo_sorted.txt
Size of data = 4 x 4 = 16
Size of topo sorted data = 16
BEST NODE = Array
(
    [height] => 9
    [longest_path] => 5
    [base_height] => 1
    [drop] => 9
)
```
