
<?php 
session_start();
include('connect.php');

if(!isset($_SESSION['rol']) || $_SESSION['rol']!='profesor'){
    header("Location: login.php");
    exit();
}

$res = mysqli_query($conn, "SELECT * FROM estudiantes");
?>

<link rel="stylesheet" href="style.css">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet">

<div class="container">

<h2 class="mb-4">Panel Profesor</h2>

<a href="logout.php" class="btn btn-danger mb-3">Cerrar sesión</a>

<!-- FORM -->
<h4>Cargar Nota</h4>

<form method="POST" action="guardar_nota.php" class="form-section">

<!-- ALUMNO -->
<select name="dni" class="form-control mb-2" required>
<option value="">Seleccionar alumno</option>
<?php
$al = mysqli_query($conn,"SELECT dni, Nombre, Apellido FROM estudiantes");
while($a = mysqli_fetch_assoc($al)){
    echo "<option value='{$a['dni']}'>{$a['Nombre']} {$a['Apellido']} ({$a['dni']})</option>";
}
?>
</select>

<!-- MATERIA -->
<select name="materia" class="form-control mb-2" required>
<option value="">Seleccionar materia</option>
<?php
$mat = mysqli_query($conn,"SELECT * FROM materias");
while($m = mysqli_fetch_assoc($mat)){
    echo "<option value='{$m['id']}'>{$m['nombre']}</option>";
}
?>
</select>

<!-- NOTA -->
<input name="nota" type="number" min="0" max="10" placeholder="Nota (0 a 10)" class="form-control mb-2" required>

<!-- CUATRIMESTRE -->
<select name="cuatrimestre" class="form-control mb-2" required>
<option value="">Seleccionar cuatrimestre</option>
<option value="1">1° Cuatrimestre</option>
<option value="2">2° Cuatrimestre</option>
</select>

<button class="btn btn-primary">Guardar Nota</button>

</form>


<section class="form-section">
<h4>Asignar Asistencia</h4>
<form method="POST" action="guardar_asistencia.php">
<input name="dni" placeholder="DNI" class="form-control mb-2">
<input name="porcentaje" type="number" class="form-control mb-2">
<button class="btn btn-warning">Guardar Asistencia</button>
</form>
</section>

<section class="form-section">

<h4>Agregar Examen</h4>

<form method="POST" action="guardar_examen.php">

<!-- MATERIA -->
<select name="materia_id" class="form-control mb-2" required>
<option value="">Seleccionar materia</option>
<?php
$mat = mysqli_query($conn,"SELECT * FROM materias");
while($m = mysqli_fetch_assoc($mat)){
    echo "<option value='{$m['id']}'>{$m['nombre']}</option>";
}
?>
</select>

<!-- FECHA -->
<input name="fecha" type="date" class="form-control mb-2" required>

<!-- TIPO -->
<select name="tipo" class="form-control mb-2" required>
<option value="">Seleccionar tipo</option>
<option value="TP">Trabajo Práctico</option>
<option value="Examen">Examen</option>
</select>

<button class="btn btn-info">Guardar</button>

</form>

</section>

<section class="form-section">
<h4>Agregar Comentario</h4>

<form method="POST" action="guardar_comentario.php">

<!-- SELECT ALUMNO -->
<select name="dni" class="form-control mb-2" required>
  <option value="">Seleccionar Alumno</option>
  <?php
  $alumnos = mysqli_query($conn,"SELECT dni, Nombre, Apellido FROM estudiantes");
  while($a = mysqli_fetch_assoc($alumnos)){
      echo "<option value='{$a['dni']}'>{$a['Nombre']} {$a['Apellido']} ({$a['dni']})</option>";
  }
  ?>
</select>

<!-- COMENTARIO -->
<textarea name="comentario" class="form-control mb-2" placeholder="Escribir comentario..." required></textarea>

<button class="btn btn-dark">Guardar Comentario</button>

</form>
</section>

<!-- TABLA -->
<?php
// 🔥 JOIN para traer la foto desde usuarios
$res = mysqli_query($conn, "
SELECT estudiantes.*, usuarios.foto 
FROM estudiantes 
INNER JOIN usuarios ON estudiantes.dni = usuarios.dni
");
?>

<section class="table-container mt-4">
<table class="table table-bordered text-center align-middle">

<tr>
<th>Nombre</th>
<th>DNI</th>
<th>Foto</th>
<th>Acciones</th>
</tr>

<?php while($row = mysqli_fetch_assoc($res)): ?>
<tr>

<td><?= $row['Nombre']." ".$row['Apellido'] ?></td>

<td><?= $row['dni'] ?></td>

<!-- 📷 FOTO -->
<td>
<?php if(!empty($row['foto']) && file_exists($row['foto'])): ?>
    <img src="<?= $row['foto'] ?>" width="70" height="70"
    style="object-fit:cover;border-radius:50%; border:2px solid #0d6efd;">
<?php else: ?>
    <span class="text-muted">Sin foto</span>
<?php endif; ?>
</td>

<!-- ❌ ELIMINAR -->
<td>
<form method="POST" action="borrar.php">
<input type="hidden" name="dni" value="<?= $row['dni'] ?>">
<button class="btn btn-danger btn-sm"
onclick="return confirm('¿Eliminar estudiante?')">
Eliminar
</button>
</form>
</td>

</tr>
<?php endwhile; ?>

</table>
</section>
</div>