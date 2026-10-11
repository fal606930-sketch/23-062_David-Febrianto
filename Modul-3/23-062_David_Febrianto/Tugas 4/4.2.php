<?php
$weight = array("Andy"=>"70", "Barry"=>"65", "Charlie"=>"75");

$str = array();
foreach($weight as $k => $v) { $str[] = '"'.$k.'"=>"'.$v.'"'; }
echo 'weight = (' . implode(', ', $str) . ')<br>';

$keys = array_keys($weight); // Mengambil semua kunci ke dalam array terindeks
$length = count($keys);

// Menggunakan struktur FOR sesuai arahan
for($i = 0; $i < $length; $i++) {
    $key = $keys[$i];
    echo $key . " is " . $weight[$key] . " kg.<br>";
}
?>