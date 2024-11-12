<?php

include 'conexion_be.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Función para limpiar los datos recibidos
    function limpiar_dato($conexion, $dato) {
        return mysqli_real_escape_string($conexion, trim($dato));
    }

    // Obtener datos del formulario y limpiar
    $nombre = limpiar_dato($conexion, $_POST['NombreAlumno']);
    $apellido = limpiar_dato($conexion, $_POST['ApellidoAlumno']);
    $telefono = limpiar_dato($conexion, $_POST['TelefonoAlumno']);
    $direccion = limpiar_dato($conexion, $_POST['DireccionAlumno']);
    $datos_tutor = limpiar_dato($conexion, $_POST['DatosTutor']);
    $curso_actual = limpiar_dato($conexion, $_POST['CursoActual']);
    $escuela_id = intval($_POST['Escuela']);

    // Verificar si el nombre ya está registrado
    $verificar_nombre = mysqli_query($conexion, "SELECT * FROM alumnos WHERE nombre_alumno = '$nombre'");

    if (!$verificar_nombre) {
        die("Error en la consulta: " . mysqli_error($conexion)); // Muestra el error si la consulta falla
    }

    if (mysqli_num_rows($verificar_nombre) > 0) {
        echo '
        <script>
            alert("Este alumno ya está registrado, intenta con otro diferente");
            window.location = "http://localhost/Proyecto/Escuela/src/app/alumnos/alumnos.component.php";
        </script>';
        exit();
    }

    // Procesar la imagen si se ha subido
    $ruta_imagen = null;
    if (!empty($_FILES['ImagenAlumno']['tmp_name'])) {
        $imagen_nombre = basename($_FILES['ImagenAlumno']['name']);
        $ruta_imagen = 'ruta/a/guardar/' . $imagen_nombre;

        move_uploaded_file($_FILES['ImagenAlumno']['tmp_name'], $ruta_imagen);
    }

    // Verificar si los datos están correctos antes de insertar
    echo "Nombre: $nombre, Apellido: $apellido, Teléfono: $telefono, Dirección: $direccion, Tutor: $datos_tutor, Curso: $curso_actual, Escuela ID: $escuela_id, Imagen: $ruta_imagen"; // Para depuración


    $sql = "INSERT INTO alumnos (nombre_alumno, apellido, telefono, direccion, datos_tutor, curso_actual, imagen, escuela_id)
            VALUES ('$nombre', '$apellido', '$telefono', '$direccion', '$datos_tutor', '$curso_actual', '$ruta_imagen', '$escuela_id')";


    $ejecutar = mysqli_query($conexion, $sql);

    if ($ejecutar) {
        echo '
        <script>
            alert("Alumno registrado exitosamente");
            window.location = "http://localhost/Proyecto/Escuela/src/app/alumnos/alumnos.component.php";
        </script>';
    } else {
        echo '
        <script>
            alert("Error al registrar el alumno, intenta de nuevo: ' . mysqli_error($conexion) . '");
            window.location = "http://localhost/Proyecto/Escuela/src/app/alumnos/alumnos.component.php";
        </script>';
    }


    mysqli_close($conexion);
}
?>


