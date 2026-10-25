<!DOCTYPE html>
<html>
<head>
    <title>Register - Self Submission</title>
</head>
<body>
<?php
$errors = array();

if (isset($_POST['surname'])) {
    require 'validate.inc';
    validateName($errors, $_POST, 'surname');
    
    if ($errors) {
        echo '<h1>Invalid, correct the following errors:</h1>';
        foreach ($errors as $field => $error) {
            echo "$field $error</br>";
        }
        // tampilkan kembali form beserta data yang sudah diisi
        include 'form.inc';
    } else {
        echo '<h1>Form submitted successfully with no errors!</h1>';
    }
} else {
    // tampilkan form kosong saat pertama kali diakses
    include 'form.inc';
}
?>
</body>
</html>