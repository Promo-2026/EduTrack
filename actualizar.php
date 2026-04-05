<?php
include('connect.php');

$dni = $_POST['dni'];
$campo = $_POST['campo'];
$valor = $_POST['valor'];

$permitidos = ['Edad','Grado','calificacion'];

if(!in_array($campo, $permitidos)){
    echo "ERROR";
    exit();
}

$sql = "UPDATE estudiantes SET $campo='$valor' WHERE dni='$dni'";

if(mysqli_query($conn, $sql)){
    echo "OK";
}else{
    echo "ERROR";
}
?>