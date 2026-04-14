<?php
include('connect.php');

$materia = $_POST['materia_id'];
$fecha = $_POST['fecha'];
$tipo = $_POST['tipo'];

mysqli_query($conn,"
INSERT INTO examenes (materia_id, fecha, tipo)
VALUES ('$materia','$fecha','$tipo')
");

header("Location: profesor.php");
exit();
?>