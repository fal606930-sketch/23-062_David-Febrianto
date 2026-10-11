<?php
// array_push
$arr_push = array("A");
echo 'Array awal: ("A")<br>';
array_push($arr_push, "B");
echo 'Hasil array_push: ' . implode(" ", $arr_push) . '<br><br>';

// array_merge
$arr_merge1 = array("A", "B");
$arr_merge2 = array("C");
echo 'Array awal: ("A", "B") digabung dengan ("C")<br>';
$hasil_merge = array_merge($arr_merge1, $arr_merge2);
echo 'Hasil array_merge: ' . implode(" ", $hasil_merge) . '<br><br>';

// array_values
$arr_vals = array("x"=>1, "y"=>2);
echo 'Array awal: ("x"=>1, "y"=>2)<br>';
$hasil_vals = array_values($arr_vals);
echo 'Hasil array_values: ' . implode(" ", $hasil_vals) . '<br><br>';

// array_search
$arr_search = array("A", "B", "C");
echo 'Mencari "B" pada array: ("A", "B", "C")<br>';
$hasil_search = array_search("B", $arr_search);
echo 'Hasil array_search: ' . $hasil_search . '<br><br>';

// array_filter
$arr_filter = array(0, 1, false, 2, "", 3, "array");
echo 'Array awal: (0, 1, false, 2, "", 3, "array")<br>';
$hasil_filter = array_filter($arr_filter);
echo 'Hasil array_filter: ' . implode(" ", $hasil_filter) . '<br><br>';

// Sorting Array Terindeks
$arr_sort = array(3, 1, 2);
echo 'Array awal: (3, 1, 2)<br>';
sort($arr_sort);
echo 'Hasil sort: ' . implode(" ", $arr_sort) . '<br>';
$arr_rsort = array(3, 1, 2);
rsort($arr_rsort);
echo 'Hasil rsort: ' . implode(" ", $arr_rsort) . '<br><br>';

// Sorting Array Asosiatif
$arr_assoc = array("Peter"=>35, "Ben"=>37, "Joe"=>43);
echo 'Array awal: ("Peter"=>35, "Ben"=>37, "Joe"=>43)<br>';

$asort_arr = $arr_assoc; asort($asort_arr);
echo 'Hasil asort: ';
foreach($asort_arr as $k => $v) echo $k . "=>" . $v . ", "; echo "<br>";

$ksort_arr = $arr_assoc; ksort($ksort_arr);
echo 'Hasil ksort: ';
foreach($ksort_arr as $k => $v) echo $k . "=>" . $v . ", "; echo "<br>";

$arsort_arr = $arr_assoc; arsort($arsort_arr);
echo 'Hasil arsort: ';
foreach($arsort_arr as $k => $v) echo $k . "=>" . $v . ", "; echo "<br>";

$krsort_arr = $arr_assoc; krsort($krsort_arr);
echo 'Hasil krsort: ';
foreach($krsort_arr as $k => $v) echo $k . "=>" . $v . ", ";
?>