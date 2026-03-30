<?php
include('connect.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['dni'])) {
    $dni = $_POST['dni'];

    // Verificar si el estudiante existe antes de eliminar
    $stmt_check = $conn->prepare("SELECT * FROM estudiantes WHERE dni = ?");
    $stmt_check->bind_param("s", $dni);
    $stmt_check->execute();
    $result = $stmt_check->get_result();

    if ($result->num_rows > 0) {
        // Eliminar solo el estudiante seleccionado
        $stmt = $conn->prepare("DELETE FROM estudiantes WHERE dni = ?");
        $stmt->bind_param("s", $dni);

        if ($stmt->execute()) {
            header("Location: index.php");
            exit();
        } else {
            echo "Error al eliminar el estudiante: " . $stmt->error;
        }

        $stmt->close();
    } else {
        echo "No se encontró el estudiante con DNI: " . htmlspecialchars($dni);
    }

    $stmt_check->close();
}

$conn->close();
?>