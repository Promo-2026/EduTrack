<?php
include('connect.php');

if ($_SERVER["REQUEST_METHOD"] == "POST" && !empty($_POST['foto']) && !empty($_POST['estudiante_dni'])) {
    $foto = $_POST['foto'];
    $foto = str_replace('data:image/png;base64,', '', $foto);
    $foto = str_replace(' ', '+', $foto);
    $data = base64_decode($foto);

    $dni = mysqli_real_escape_string($conn, $_POST['estudiante_dni']);
    $res = mysqli_query($conn, "SELECT Nombre, Apellido FROM estudiantes WHERE dni = '$dni'");
    $row = mysqli_fetch_assoc($res);

    $nombreLimpio = preg_replace('/[^a-zA-Z0-9]/', '_', $row['Nombre'] . '_' . $row['Apellido'] . '_' . $dni);
    $nombreArchivo = "img/{$nombreLimpio}.png";

    file_put_contents($nombreArchivo, $data);

    mysqli_query($conn, "UPDATE estudiantes SET foto='$nombreArchivo' WHERE dni='$dni'");

    echo "<h3>Foto guardada exitosamente para {$row['Nombre']} {$row['Apellido']} (DNI: $dni).</h3>";
    echo "<img src='$nombreArchivo' width='300'>";
    echo "<br><a href='index.php' class='btn btn-primary mt-3'>Volver al inicio</a>";
    exit;
}

$estudiantes = mysqli_query($conn, "SELECT dni, Nombre, Apellido FROM estudiantes");
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Capturar y Guardar Foto con PHP</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
</head>
<body class="bg-light">
<div class="container py-4">
    <h2 class="mb-4">Capturar Foto con la Cámara</h2>
    <form method="POST" onsubmit="return enviarFoto()">
        <div class="mb-3">
            <label for="estudiante_dni" class="form-label">Selecciona el estudiante:</label>
            <select name="estudiante_dni" id="estudiante_dni" class="form-select" required>
                <option value="">-- Selecciona --</option>
                <?php while($e = mysqli_fetch_assoc($estudiantes)): ?>
                    <option value="<?= htmlspecialchars($e['dni']) ?>">
                        <?= htmlspecialchars($e['Nombre'] . ' ' . $e['Apellido'] . ' (DNI: ' . $e['dni'] . ')') ?>
                    </option>
                <?php endwhile; ?>
            </select>
        </div>
        <div class="mb-3">
            <video id="video" width="320" height="240" autoplay class="border"></video><br>
            <button type="button" class="btn btn-success mt-2" onclick="tomarFoto()">Tomar Foto</button>
        </div>
        <canvas id="canvas" width="320" height="240" style="display:none;"></canvas>
        <input type="hidden" name="foto" id="foto">
        <button type="submit" class="btn btn-primary">Guardar Foto</button>
        <a href="index.php" class="btn btn-secondary">Volver</a>
    </form>
</div>
<script>
    const video = document.getElementById('video');
    const canvas = document.getElementById('canvas');
    const fotoInput = document.getElementById('foto');
    const contexto = canvas.getContext('2d');

    navigator.mediaDevices.getUserMedia({ video: true })
        .then(stream => video.srcObject = stream)
        .catch(error => console.error("Error al acceder a la cámara: ", error));

    function tomarFoto() {
        contexto.drawImage(video, 0, 0, canvas.width, canvas.height);
        const dataURL = canvas.toDataURL('image/png');
        fotoInput.value = dataURL;
        alert("Foto capturada. Ahora podés guardarla.");
    }

    function enviarFoto() {
        if (!document.getElementById('estudiante_dni').value) {
            alert("Selecciona un estudiante.");
            return false;
        }
        if (!fotoInput.value) {
            alert("Primero tenés que tomar una foto.");
            return false;
        }
        return true;
    }
</script>
</body>
</html>