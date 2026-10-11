<?php
$fruits = array("Avocado", "Blueberry", "Cherry", "Durian", "Elderberry", "Fig", "Grape", "Honeydew");

// Menghapus Blueberry (indeks 1)
unset($fruits[1]);
echo "Data Blueberry dihapus.<br>";

// Menyusun ulang indeks array agar kembali berurutan
$fruits = array_values($fruits);

echo 'fruits = ("' . implode('", "', $fruits) . '")<br>';
$highest_index = count($fruits) - 1;
echo "Nilai dengan indeks tertinggi: " . $fruits[$highest_index];
?>