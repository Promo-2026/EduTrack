<?php 
include('connect.php');  

$dni = $_POST['dni'];
$porcentaje = $_POST['porcentaje'];

mysqli_query($conn,"
INSERT INTO asistencia (dni, porcentaje)
VALUES ('$dni','$porcentaje')
ON DUPLICATE KEY UPDATE porcentaje='$porcentaje'
");

header("Location: profesor.php"); 
?>