<?php

session_start();

include 'conexion_be.php';

$correo = $_POST['correo'];
$contraseña = $_POST['contraseña'];

$validar_login = mysqli_query($conexion, "SELECT * FROM usuarios WHERE correo='$correo' and contraseña='$contraseña' ");

if(mysqli_num_rows($validar_login) > 0){
    $_SESSION['usuario'] = $correo;
    echo '<script>
      sessionStorage.setItem("login", 1);
      window.location = "http://localhost/Proyecto/Escuela/src/app/casa/casa.component.html"
    </script>';

    // header("location: ../casa/casa.component.html");
    exit;
} else{
    echo'
    <script>
    alert("Usuario no existe, por favor verifique los datos introducidos");
    window.location = "../app.component.html";
    </script>
    ';
    exit;
}
?>
