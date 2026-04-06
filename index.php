<?php
session_start();
include('connect.php');

if($_POST){
    $user = $_POST['user'];
    $pass = $_POST['pass'];

    $res = mysqli_query($conn,"SELECT * FROM usuarios WHERE username='$user' AND password='$pass'");
    
    if($row = mysqli_fetch_assoc($res)){
        $_SESSION['rol'] = $row['rol'];
        $_SESSION['dni'] = $row['dni'];

        if($row['rol']=='profesor'){
            header("Location: profesor.php");
        } else {
            header("Location: alumno.php");
        }
        exit();
    } else {
        echo "<div class='alert error'>Usuario o contraseña incorrectos</div>";
    }
}
?>

<link rel="stylesheet" href="style.css">

<div class="login-container">
    <form method="POST" class="card login-card">
        <h2 class="text-center">Login</h2>

        <input name="user" placeholder="Usuario" required>
        <input name="pass" type="password" placeholder="Contraseña" required>

        <button>Ingresar</button>

        <a href="registro.php">Crear cuenta</a>
    </form>
</div>