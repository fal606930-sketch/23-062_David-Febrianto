<?php
$fruits = array("Avocado", "Blueberry", "Cherry");
$tambahan = array("Buah Tambahan 1", "Buah Tambahan 2", "Buah Tambahan 3", "Buah Tambahan 4", "Buah Tambahan 5");

// Menambahkan data baru dengan perulangan for
for($i = 0; $i < 5; $i++) {
    $fruits[] = $tambahan[$i];
}

$arrlength = count($fruits);
echo "Panjang array saat ini: " . $arrlength . "<br>";

for($x = 0; $x < $arrlength; $x++) {
    echo $fruits[$x] . "<br>";
}
?>