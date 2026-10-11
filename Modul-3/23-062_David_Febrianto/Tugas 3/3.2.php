<?php
$weight = array("Andy"=>"70", "Barry"=>"65", "Charlie"=>"75");

// Menampilkan format array
$str = array();
foreach($weight as $k => $v) { $str[] = '"'.$k.'"=>"'.$v.'"'; }
echo 'weight = (' . implode(', ', $str) . ')<br>';

// Mengambil data kedua
$values = array_values($weight);
echo "Data kedua: " . $values[1];
?>