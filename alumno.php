<?php
session_start();
include('connect.php');

if(!isset($_SESSION['rol']) || $_SESSION['rol']!='alumno'){
    header("Location: login.php");
    exit();
}

$dni = $_SESSION['dni'];
$alumno = mysqli_fetch_assoc(mysqli_query($conn,"SELECT * FROM estudiantes WHERE dni='$dni'"));
?>

<link rel="stylesheet" href="style.css">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet">

<div class="container">

<h2>Bienvenido <?= $alumno['Nombre'] ?></h2>
<a href="logout.php" class="btn btn-danger mb-3">Cerrar sesión</a>

<!-- DATOS -->

<div class="card p-3 mb-3">
<h4><?= $alumno['Nombre']." ".$alumno['Apellido'] ?></h4>
<p>DNI: <?= $alumno['dni'] ?></p>
<p>Grado: <?= $alumno['Grado'] ?></p>
</div>

<!-- NOTAS -->
<h3>Notas</h3>
<?php
$res = mysqli_query($conn,"
SELECT m.nombre, n.nota, n.cuatrimestre
FROM notas n 
JOIN materias m ON n.materia_id=m.id
WHERE n.dni='$dni'
");

while($r=mysqli_fetch_assoc($res)){
    echo "<p>{$r['nombre']} - Cuat {$r['cuatrimestre']}: {$r['nota']}</p>";
}
?>

<!-- ASISTENCIA -->
<h3>Asistencia</h3>
<?php
$resAsis = mysqli_query($conn,"SELECT porcentaje FROM asistencia WHERE dni='$dni'");
$asis = mysqli_fetch_assoc($resAsis);

if(!$asis){
    $asis['porcentaje'] = 0;
}
?>

<div class="progress mb-2">
  <div class="progress-bar" style="width:<?= $asis['porcentaje'] ?>%">
    <?= $asis['porcentaje'] ?>%
  </div>
</div>

<?php if($asis['porcentaje'] < 75): ?>
<p class="text-danger">⚠ Riesgo de quedar libre</p>
<?php endif; ?>

<!-- ESTADO -->
<h3>Estado Académico</h3>
<?php
$prom = mysqli_fetch_assoc(mysqli_query($conn,"SELECT AVG(nota) as p FROM notas WHERE dni='$dni'"));
echo ($prom['p']>=7) ? "<span class='text-success'>Aprobado</span>" : "<span class='text-warning'>Intensificación</span>";
?>

<!-- EXAMENES -->
<h3>Próximos Exámenes</h3>

<?php
$res = mysqli_query($conn,"
SELECT m.nombre, e.fecha, e.tipo
FROM examenes e 
JOIN materias m ON e.materia_id=m.id
ORDER BY e.fecha ASC
");

while($r=mysqli_fetch_assoc($res)){
    echo "<p><strong>{$r['nombre']}</strong> - {$r['tipo']} - {$r['fecha']}</p>";
}
?>

<h3>Materias pendientes</h3>
<?php
$res = mysqli_query($conn,"
SELECT m.nombre
FROM materias m
LEFT JOIN notas n ON m.id=n.materia_id AND n.dni='$dni'
WHERE n.nota < 7 OR n.nota IS NULL
");

while($r=mysqli_fetch_assoc($res)){
    echo "<p>{$r['nombre']}</p>";
}
?>

<!-- COMENTARIOS -->
<h3>Comentarios</h3>
<?php
$res = mysqli_query($conn,"SELECT comentario FROM comentarios WHERE dni='$dni'");
while($r=mysqli_fetch_assoc($res)){
    echo "<p>{$r['comentario']}</p>";
}
?>

</div>