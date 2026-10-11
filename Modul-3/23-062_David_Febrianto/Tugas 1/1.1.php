<?php
$fruits = array("Avocado", "Blueberry", "Cherry");

// Menambahkan lima data baru
array_push($fruits, "Durian", "Elderberry", "Fig", "Grape", "Honeydew");

// Menampilkan format output sesuai contoh
echo 'fruits = ("' . implode('", "', $fruits) . '")<br>';

// Menampilkan nilai dengan indeks tertinggi (elemen terakhir)
$highest_index = count($fruits) - 1;
echo "Nilai dengan indeks tertinggi: " . $fruits[$highest_index];
?>