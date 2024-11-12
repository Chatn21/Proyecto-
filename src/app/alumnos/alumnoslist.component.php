<?php

include 'conexion_be.php';

$results_per_page = 10;

$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;

$start_from = ($page - 1) * $results_per_page;

// Consulta SQL para obtener los datos de los alumnos junto con el nombre de la escuela
$query = "SELECT alumnos.id, alumnos.nombre_alumno, alumnos.apellido, alumnos.telefono, alumnos.direccion,
                 alumnos.datos_tutor, alumnos.curso_actual, alumnos.imagen, escuelas.nombre AS nombre_escuela
          FROM alumnos
          LEFT JOIN escuelas ON alumnos.escuela_id = escuelas.id
          ORDER BY alumnos.nombre_alumno ASC
          LIMIT $start_from, $results_per_page";

$result = mysqli_query($conexion, $query);

if (!$result) {
    die("Error en la consulta: " . mysqli_error($conexion));
}


$query_total = "SELECT COUNT(*) AS total FROM alumnos";
$result_total = mysqli_query($conexion, $query_total);
$row = mysqli_fetch_assoc($result_total);
$total_results = $row['total'];


$total_pages = ceil($total_results / $results_per_page);

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Listado de Alumnos</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        table, th, td {
            border: 1px solid black;
        }
        th, td {
            padding: 8px;
            text-align: left;
        }
        img {
            width: 50px;
            height: 50px;
        }
        .pagination {
            margin-top: 20px;
        }
        .pagination a {
            margin: 0 5px;
            padding: 5px 10px;
            border: 1px solid #ddd;
            text-decoration: none;
        }
        .pagination a.active {
            background-color: #4CAF50;
            color: white;
        }
    </style>
</head>
<body>
    <h1>Listado de Alumnos</h1>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Apellido</th>
                <th>Teléfono</th>
                <th>Dirección</th>
                <th>Datos del Tutor</th>
                <th>Curso Actual</th>
                <th>Imagen</th>
                <th>Escuela</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($alumno = mysqli_fetch_assoc($result)): ?>
                <tr>
                    <td><?= $alumno['id']; ?></td>
                    <td><?= $alumno['nombre_alumno']; ?></td>
                    <td><?= $alumno['apellido']; ?></td>
                    <td><?= $alumno['telefono']; ?></td>
                    <td><?= $alumno['direccion']; ?></td>
                    <td><?= $alumno['datos_tutor']; ?></td>
                    <td><?= $alumno['curso_actual']; ?></td>
                    <td>
                        <?php if ($alumno['imagen'] && file_exists($alumno['imagen'])): ?>
                            <img src="<?= $alumno['imagen']; ?>" alt="Imagen del alumno">
                        <?php else: ?>
                            No disponible
                        <?php endif; ?>
                    </td>
                    <td><?= $alumno['nombre_escuela'] ?? 'No asignada'; ?></td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>

    <!-- Paginación -->
    <div class="pagination">
        <?php if ($page > 1): ?>
            <a href="?page=1">Primera</a>
            <a href="?page=<?= $page - 1; ?>">Anterior</a>
        <?php endif; ?>

        <?php for ($i = 1; $i <= $total_pages; $i++): ?>
            <a href="?page=<?= $i; ?>" class="<?= ($i == $page) ? 'active' : ''; ?>"><?= $i; ?></a>
        <?php endfor; ?>

        <?php if ($page < $total_pages): ?>
            <a href="?page=<?= $page + 1; ?>">Siguiente</a>
            <a href="?page=<?= $total_pages; ?>">Última</a>
        <?php endif; ?>
    </div>

    <a href="http://localhost/Proyecto/Escuela/src/app/alumnos/alumnos.component.php">Regresar</a>
</body>
</html>

<?php
mysqli_close($conexion);
?>


