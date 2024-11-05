<?php

include 'conexion_be.php';

$target_dir = "uploads/";
if (!is_dir($target_dir)) {
    if (!mkdir($target_dir, 0777, true)) {
        die("Error al crear la carpeta uploads: " . error_get_last()['message']);
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombreEscuela = $_POST['NombreEscuela'];
    $direccion = $_POST['Direccion'];
    $ciudad = $_POST['Ciudad'];
    $estado = $_POST['Estado'];
    $codigoPostal = $_POST['CodigoPost'];
    $latitud = $_POST['lat'];
    $longitud = $_POST['lng'];


    $target_file = $target_dir . basename($_FILES["Imagen"]["name"]);
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));


    $check = getimagesize($_FILES["Imagen"]["tmp_name"]);
    if ($check !== false) {
        if (move_uploaded_file($_FILES["Imagen"]["tmp_name"], $target_file)) {

            $sql = "INSERT INTO escuelas (nombre, direccion, ciudad, estado, codigo_postal, latitud, longitud, imagen)
            VALUES ('$nombreEscuela', '$direccion', '$ciudad', '$estado', '$codigoPostal', '$latitud', '$longitud', '$target_file')";

            if ($conexion->query($sql) === TRUE) {
                echo '
                <script>
                alert("Escuela registrada exitosamente");
                window.location = "/Proyecto/Escuela/src/app/casa/casa.component.html";
                </script>
                ';
            } else {
                echo "Error: " . $sql . "<br>" . $conexion->error;
            }
        } else {
            echo "Hubo un error al cargar la imagen.";
        }
    } else {
        echo "El archivo no es una imagen.";
    }
}


if (isset($conexion)) {
    $conexion->close();
}
?>

