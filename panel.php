<?php
session_start();
if(!isset($_SESSION['rol'])){
    header("Location: login.php");
    exit();
}
?>
<?php include('connect.php'); $res = mysqli_query($conn, "SELECT * FROM estudiantes"); ?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="style.css">
  <title>Gestión de Estudiantes</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container">

  <header class="d-flex justify-content-between align-items-center">
    <h1>Gestión de Estudiantes</h1>
    <div class="btn-group">
      <button class="btn btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
        Menú
      </button>
      <ul class="dropdown-menu">
        <li><a class="dropdown-item" href="camara.php">Camara</a></li>
        <li><a class="dropdown-item" href="#">Ver estudiantes</a></li>
        <li><a class="dropdown-item" href="#">Salir</a></li>
      </ul>
    </div>
  </header>

  <section class="form-section">
    <h4>Agregar nuevo estudiante</h4>
    <form method="POST" action="guardar.php">
      <div class="mb-3">
        <label for="nombre" class="form-label">Nombre</label>
        <input type="text" id="nombre" name="nombre" class="form-control" required>
      </div>
      <div class="mb-3">
        <label for="apellido" class="form-label">Apellido</label>
        <input type="text" id="apellido" name="apellido" class="form-control" required>
      </div>
      <div class="mb-3">
        <label for="dni" class="form-label">DNI</label>
        <input type="text" id="dni" name="dni" class="form-control" required>
      </div>
      <div class="mb-3">
        <label for="edad" class="form-label">Edad</label>
        <input type="number" id="edad" name="edad" class="form-control" required min="0">
      </div>
      <div class="mb-3">
        <label for="grado" class="form-label">Grado</label>
        <select id="grado" name="grado" class="form-control" required>
            <option value="">Seleccione...</option>
            <option value="Primero">Primero</option>
            <option value="Segundo">Segundo</option>
            <option value="Tercero">Tercero</option>
            <option value="Cuarto">Cuarto</option>
            <option value="Quinto">Quinto</option>
            <option value="Sexto">Sexto</option>
            <option value="Séptimo">Séptimo</option>
        </select>
      </div>
      <div class="mb-3">
        <label for="calificacion" class="form-label">Calificación</label>
        <input type="number" id="calificacion" name="calificacion" class="form-control" required min="0" max="10">
      </div>
      <button type="submit" class="btn btn-primary">Agregar estudiante</button>
    </form>
  </section>

  <section class="table-container">
    <h4>Listado de estudiantes</h4>
    <table class="table table-bordered table-striped">
      <thead class="table-dark">
        <tr>
          <th>Estudiante (DNI)</th>
          <th>Edad</th>
          <th>Grado</th>
          <th>Calificación</th>
          <th>Estado</th>
          <th>Foto</th>
          <th>Acciones</th>
        </tr>
      </thead>
      <tbody>
        <?php
        if (mysqli_num_rows($res) > 0) {
          while($row = mysqli_fetch_assoc($res)) {
            echo "<tr>";
            echo "<td><strong>{$row['Nombre']} {$row['Apellido']}</strong> <span class='text-muted'>({$row['dni']})</span></td>";
            echo "<td class='editable' data-dni='{$row['dni']}' data-campo='Edad'>{$row['Edad']}</td>";
            echo "<td class='editable' data-dni='{$row['dni']}' data-campo='Grado'>{$row['Grado']}</td>";
            echo "<td class='editable' data-dni='{$row['dni']}' data-campo='calificacion'>{$row['calificacion']}</td>";

            $cal = $row['calificacion'];
            if ($cal >= 7) {
                $estado = 'TEA';
                $color = 'text-primary';
            } elseif ($cal > 4) {
                $estado = 'TEP';
                $color = 'text-warning';
            } else {
                $estado = 'TED';
                $color = 'text-danger';
            }
            echo "<td class='$color fw-bold'>$estado</td>";

            if (!empty($row['foto']) && file_exists($row['foto'])) {
              echo "<td><img src='{$row['foto']}' alt='Foto' width='60' height='60' style='object-fit:cover;border-radius:50%;'></td>";
            } else {
              echo "<td><span class='text-muted'>Sin foto</span></td>";
            }

            echo "<td>
                    <form method='POST' action='borrar.php'>
                      <input type='hidden' name='dni' value='{$row['dni']}'>
                      <button class='btn btn-sm btn-danger' onclick='return confirm(\"¿Estás seguro de eliminar este estudiante?\")'>Eliminar</button>
                    </form>
                  </td>";
            echo "</tr>";
          }
        } else {
          echo "<tr><td colspan='7' class='text-center'>No hay estudiantes registrados.</td></tr>";
        }
        ?>
      </tbody>
    </table>
  </section>
</div>
<a href="logout.php">Cerrar sesión</a>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js"></script>
<script src="editar.js"></script>
</body>
</html>

<?php mysqli_close($conn); ?>