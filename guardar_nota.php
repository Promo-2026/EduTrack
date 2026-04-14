<?php
include('connect.php');

$dni=$_POST['dni'];
$materia=$_POST['materia'];
$nota=$_POST['nota'];
$cuat=$_POST['cuatrimestre'];

mysqli_query($conn,"
INSERT INTO notas (dni, materia_id, cuatrimestre, nota)
VALUES ('$dni','$materia','$cuat','$nota')
");

header("Location: profesor.php");
?>