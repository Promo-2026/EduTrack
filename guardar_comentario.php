<?php
include('connect.php');

$dni = $_POST['dni'];
$comentario = $_POST['comentario'];

mysqli_query($conn,"
INSERT INTO comentarios (dni, comentario)
VALUES ('$dni','$comentario')
");

header("Location: profesor.php");
?>