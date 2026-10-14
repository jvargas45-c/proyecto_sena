<?php
session_start();
include("../conexion.php");


$correo = $_POST["email"];
$password = $_POST["password"];


$sql = "SELECT * FROM usuarios WHERE correo = ?";

$stmt = mysqli_prepare($conexion, $sql);
mysqli_stmt_bind_param($stmt, "s", $correo);
mysqli_stmt_execute($stmt);

$resultado = mysqli_stmt_get_result($stmt);

if(mysqli_num_rows($resultado) == 1){

    $usuario = mysqli_fetch_assoc($resultado);

    
    if(password_verify($password, $usuario["contrasena"])){

        $_SESSION["id_usuario"] = $usuario["id_usuario"];
        $_SESSION["nombre"] = $usuario["nombre"];
        $_SESSION["rol"] = $usuario["rol"]; 

        $_SESSION["mensaje"] = "🌸 ¡Bienvenido, ".$usuario["nombre"]."!";
        $_SESSION["tipo"] = "success";

        
        if ($_SESSION["rol"] === "admin") {
            header("Location: ../admin/panel.php");
        } else {
            header("Location: ../index.php");
        }
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