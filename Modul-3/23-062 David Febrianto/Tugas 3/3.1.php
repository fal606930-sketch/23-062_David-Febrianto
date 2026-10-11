<?php
$height = array("Andy"=>"176", "Barry"=>"165", "Charlie"=>"170");

// Menambahkan 5 data baru
$height["David"] = "180";
$height["Ethan"] = "172";
$height["Frank"] = "168";
$height["George"] = "175";
$height["Harry"] = "182";

// Fungsi bantuan untuk mencetak array asosiatif sesuai format
function cetakHeight($arr) {
    $str = array();
    foreach($arr as $k => $v) { $str[] = '"'.$k.'"=>"'.$v.'"'; }
    return 'height = (' . implode(', ', $str) . ')<br>';
}

echo cetakHeight($height);
$keys = array_keys($height);
$last_key = end($keys);
echo "Nilai dengan indeks terakhir: " . $height[$last_key] . "<br><br>";

// Menghapus data "Barry"
unset($height["Barry"]);

echo cetakHeight($height);
$keys = array_keys($height);
$last_key = end($keys);
echo "Nilai dengan indeks terakhir setelah dihapus: " . $height[$last_key];
?>