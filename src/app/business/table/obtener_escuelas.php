<?php

include 'conexion_be.php';


$sql = "SELECT * FROM escuelas";
$result = $conexion->query($sql);


if ($result->num_rows > 0) {
  while ($row = $result->fetch_assoc()) {
      echo "<tr>";
      echo "<td class='py-2 px-4'>{$row['nombre']}</td>";
      echo "<td class='py-2 px-4'>{$row['direccion']}</td>";
      echo "<td class='py-2 px-4'>{$row['ciudad']}</td>";
      echo "<td class='py-2 px-4'>{$row['estado']}</td>";
      echo "<td class='py-2 px-4'>{$row['codigo_postal']}</td>";
      echo "<td class='py-2 px-4'>{$row['latitud']}</td>";
      echo "<td class='py-2 px-4'>{$row['longitud']}</td>";
      echo "<td class='py-2 px-4'><img src='{$row['imagen']}' alt='Imagen de la escuela' width='50'></td>";
      echo "<td class='py-2 px-4'>{$row['fecha_registro']}</td>";
      echo "</tr>";
  }
} else {
    echo "<tr><td colspan='5'>No hay escuelas registradas.</td></tr>";
}


$conexion->close();
?>
