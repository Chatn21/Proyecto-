<?php

include 'conexion_be.php';


$id = $_GET['id'];


$sql = "SELECT * FROM escuelas WHERE id = $id";
$result = $conexion->query($sql);

if ($result->num_rows > 0) {
    $escuela = $result->fetch_assoc();
    echo json_encode($escuela);
} else {
    echo json_encode(null);
}

$conexion->close();
?>
