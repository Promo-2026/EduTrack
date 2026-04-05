<?php
include('connect.php');

$dni = $_POST['dni'];
$porcentaje = $_POST['porcentaje'];

mysqli_query($conn,"REPLACE INTO asistencia (dni, porcentaje) VALUES ('$dni','$porcentaje')");

header("Location: profesor.php");
?>