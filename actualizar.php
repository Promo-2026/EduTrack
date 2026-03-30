<?php
include('connect.php');
if (
    isset($_POST['id']) &&
    isset($_POST['campo']) &&
    isset($_POST['valor'])
) {
    $id = (int)$_POST['id'];
    $campo = $_POST['campo'];
    $valor = $_POST['valor'];

    $permitidos = ['Nombre', 'Apellido', 'Edad', 'Grado', 'calificacion'];
    if (!in_array($campo, $permitidos)) {
        exit('Campo no permitido');
    }

    if (($campo == 'Edad' || $campo == 'calificacion') && !is_numeric($valor)) {
        exit('Valor inválido');
    }

    if ($campo == 'calificacion') {
        $calificacion = (int)$valor;
        if ($calificacion >= 7) {
            $estado = 'Aprobado';
        } elseif ($calificacion <= 4) {
            $estado = 'Reprobado';
        } else {
            $estado = 'Desaprobado';
        }
        $sql = "UPDATE estudiantes SET calificacion=$calificacion, estado='$estado' WHERE ID=$id";
    } else {
        $valor = mysqli_real_escape_string($conn, $valor);
        $sql = "UPDATE estudiantes SET $campo='$valor' WHERE ID=$id";
    }

    if (mysqli_query($conn, $sql)) {
        echo 'OK';
    } else {
        echo 'Error';
    }
}
mysqli_close($conn);
?>