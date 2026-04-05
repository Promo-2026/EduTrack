<?php
include('connect.php');

if($_POST){
    $user = $_POST['user'];
    $pass = $_POST['pass'];
    $dni = $_POST['dni'];
    $rol = $_POST['rol'];
    $foto = $_POST['foto'];

    $rutaFoto = "";

    // 📷 guardar foto
    if (!empty($foto)) {
        $foto = str_replace('data:image/png;base64,', '', $foto);
        $foto = str_replace(' ', '+', $foto);
        $data = base64_decode($foto);

        $rutaFoto = "fotos/" . time() . ".png";
        file_put_contents($rutaFoto, $data);
    }

    // 👤 guardar usuario
    mysqli_query($conn,"
    INSERT INTO usuarios (username,password,rol,dni,foto)
    VALUES ('$user','$pass','$rol','$dni','$rutaFoto')
    ");

    // 🎓 SI ES ALUMNO → GUARDAR EN ESTUDIANTES
    if($rol == 'alumno'){
        mysqli_query($conn,"
        INSERT INTO estudiantes (Nombre, Apellido, dni, Edad, Grado, calificacion, foto)
        VALUES ('$user','','$dni','0','Sin asignar','0','$rutaFoto')
        ");
    }

    header("Location: index.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Registro</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container">

<h2>Registro</h2>

<form method="POST">

<input name="user" placeholder="Usuario" class="form-control mb-2" required>
<input name="pass" type="password" placeholder="Contraseña" class="form-control mb-2" required>
<input name="dni" placeholder="DNI" class="form-control mb-2" required>

<select name="rol" class="form-control mb-2">
  <option value="alumno">Alumno</option>
  <option value="profesor">Profesor</option>
</select>

<h5>Tomar foto</h5>
<video id="video" width="200" autoplay></video>
<br>
<button type="button" onclick="tomarFoto()" class="btn btn-secondary mt-2">Capturar</button>

<canvas id="canvas" width="200" height="150" style="display:none;"></canvas>
<input type="hidden" name="foto" id="foto">

<br><br>
<button class="btn btn-success">Registrarse</button>

</form>

<script>
const video = document.getElementById('video');

navigator.mediaDevices.getUserMedia({ video: true })
.then(stream => video.srcObject = stream)
.catch(() => alert("No se pudo usar la cámara"));

function tomarFoto() {
    const canvas = document.getElementById('canvas');
    const ctx = canvas.getContext('2d');

    ctx.drawImage(video, 0, 0, 200, 150);
    document.getElementById('foto').value = canvas.toDataURL('image/png');

    alert("Foto capturada ✅");
}
</script>

</body>
</html>