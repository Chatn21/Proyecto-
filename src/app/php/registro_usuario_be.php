<?php

include 'conexion_be.php';


$nombre_completo = $_POST['nombre_completo'];
$correo = $_POST['correo'];
$telefono = $_POST['telefono'];
$contraseña = $_POST['contraseña'];


$query = "INSERT INTO usuarios(nombre_completo, correo, telefono, contraseña)
          VALUES('$nombre_completo','$correo','$telefono','$contraseña')";

//verificar que el correo no se repita en la base de  datos//
$verficar_correo = mysqli_query($conexion,"SELECT * FROM usuarios WHERE correo='$correo' ");
if(mysqli_num_rows($verficar_correo) > 0){
    echo '
    <script>
    alert("Este correo ya esta registrado, intenta con otro diferente");
    window.location = "../app.component.html";
    </script>
    ';
    exit();
}
    //verificar que el usuario no se repita en la base de  datos//
$verficar_telefono = mysqli_query($conexion,"SELECT * FROM usuarios WHERE telefono='$telefono' ");
if(mysqli_num_rows($verficar_telefono) > 0){
    echo '
    <script>
    alert("Esta telefono ya esta registrado, intenta con otro diferente");
    window.location = "../app.component.html";
    </script>
    ';
    exit();
}

$ejecutar = mysqli_query($conexion, $query);

if($ejecutar){
    echo '
    <script>
    alert("Usuario almacenado exitosamente");
    window.location = "../app.component.html";
    </script>
    ';
} else{
    echo '
    <script>
    alert("Intentalo de nuevo, usuario no almacenado ");
    window.location = "../index.php";
    </script>
    ';
}

mysqli_close($conexion);

?>
