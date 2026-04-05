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
        echo "Usuario o contraseña incorrectos";
    }
}
?>

<link rel="stylesheet" href="style.css">

<div class="container text-center mt-5">
    <h2>Login</h2>
    <form method="POST" class="card p-4 mx-auto" style="max-width:400px;">
        <input name="user" placeholder="Usuario" class="form-control mb-2">
        <input name="pass" type="password" placeholder="Contraseña" class="form-control mb-2">
        <button class="btn btn-primary">Ingresar</button>
        <a href="registro.php">Crear cuenta</a>
    </form>
</div>