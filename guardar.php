<?php
include('connect.php');

if (
    $_SERVER['REQUEST_METHOD'] == 'POST' &&
    isset($_POST['nombre']) &&
    isset($_POST['apellido']) &&
    isset($_POST['dni']) &&
    isset($_POST['edad']) &&
    isset($_POST['grado']) &&
    isset($_POST['calificacion'])
) {
    $nombre = mysqli_real_escape_string($conn, $_POST['nombre']);
    $apellido = mysqli_real_escape_string($conn, $_POST['apellido']);
    $dni = mysqli_real_escape_string($conn, $_POST['dni']);
    $edad = (int) $_POST['edad'];
    $grado = mysqli_real_escape_string($conn, $_POST['grado']);
    $calificacion = (int) $_POST['calificacion'];

    if ($calificacion >= 7) {
        $estado = 'Aprobado';
    } elseif ($calificacion <= 4) {
        $estado = 'Reprobado';
    } else {
        $estado = 'Desaprobado';
    }

    $sql = "INSERT INTO estudiantes (dni, Nombre, Apellido, Edad, Grado, calificacion, estado) 
            VALUES ('$dni', '$nombre', '$apellido', $edad, '$grado', $calificacion, '$estado')";

    if (mysqli_query($conn, $sql)) {
        header("Location: index.php");
        exit();
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}

mysqli_close($conn);
?>