<?php
include 'conexion_be.php';


if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $nombreEscuela = $_POST['NombreEscuela'];


    if (empty($nombreEscuela)) {
        die("Error: El nombre de la escuela no está definido.");
    }

    $direccion = $_POST['Direccion'];
    $ciudad = $_POST['Ciudad'];
    $estado = $_POST['Estado'];
    $codigoPostal = $_POST['CodigoPost'];


    $target_dir = "uploads/";
    $target_file = $target_dir . basename($_FILES["Imagen"]["name"]);
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));


    if ($_FILES["Imagen"]["error"] == 0) {
        $check = getimagesize($_FILES["Imagen"]["tmp_name"]);
        if($check !== false) {
            if (move_uploaded_file($_FILES["Imagen"]["tmp_name"], $target_file)) {

                $sql = "UPDATE escuelas SET direccion='$direccion', ciudad='$ciudad', estado='$estado', codigo_postal='$codigoPostal', imagen='$target_file' WHERE nombre='$nombreEscuela'";
            } else {
                echo "Hubo un error al cargar la imagen.";
                exit();
            }
        } else {
            echo "El archivo no es una imagen.";
            exit();
        }
    } else {

        $sql = "UPDATE escuelas SET direccion='$direccion', ciudad='$ciudad', estado='$estado', codigo_postal='$codigoPostal' WHERE nombre='$nombreEscuela'";
    }


    if ($conexion->query($sql) === TRUE) {
        echo '<script>
                alert("Escuela actualizada exitosamente");
                window.location = "/Proyecto/Escuela/src/app/casa/casa.component.html"
              </script>';
    } else {

        echo "Error en la consulta: " . $sql . "<br>" . $conexion->error;
    }
}

$conexion->close();
?>
