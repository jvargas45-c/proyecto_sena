<?php
session_start();
include("../conexion.php");

// Recibir datos
$correo = $_POST["email"];
$password = $_POST["password"];

// Buscar usuario
$sql = "SELECT * FROM usuarios WHERE correo = ?";

$stmt = mysqli_prepare($conexion, $sql);
mysqli_stmt_bind_param($stmt, "s", $correo);
mysqli_stmt_execute($stmt);

$resultado = mysqli_stmt_get_result($stmt);

if(mysqli_num_rows($resultado) == 1){

    $usuario = mysqli_fetch_assoc($resultado);

    // Verificar contraseña
    if(password_verify($password, $usuario["contrasena"])){

        $_SESSION["id_usuario"] = $usuario["id_usuario"];
        $_SESSION["nombre"] = $usuario["nombre"];
        $_SESSION["rol"] = $usuario["rol"];

        $_SESSION["mensaje"] = "🌸 ¡Bienvenido, ".$usuario["nombre"]."!";
        $_SESSION["tipo"] = "success";

        header("Location: ../index.php");
        exit();

    }else{

        $_SESSION["mensaje"] = "Contraseña incorrecta.";
        $_SESSION["tipo"] = "error";

        header("Location: iniciar.html");
        exit();
    }

}else{

    $_SESSION["mensaje"] = "El correo no está registrado.";
    $_SESSION["tipo"] = "error";

    header("Location: iniciar.html");
    exit();
}

mysqli_close($conexion);
?>