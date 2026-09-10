<?php
session_start();
include("../conexion.php");

// Recibir datos del formulario
$nombre = $_POST['firstName'];
$apellido = $_POST['lastName'];
$correo = $_POST['email'];
$telefono = $_POST['telefono'];
$usuario = $_POST['usuario'];

$password = $_POST['password'];
$confirmar = $_POST['confirmPassword'];

$rol = "cliente";

// Unir nombre y apellido
$nombreCompleto = $nombre . " " . $apellido;

// Validar que las contraseñas coincidan
if ($password != $confirmar) {

    $_SESSION['mensaje'] = "Las contraseñas no coinciden.";
    $_SESSION['tipo'] = "error";

    header("Location: registrar.html");
    exit();
}

// Verificar si el correo ya existe
$sql = "SELECT id_usuario FROM usuarios WHERE correo = ?";

$stmt = mysqli_prepare($conexion, $sql);
mysqli_stmt_bind_param($stmt, "s", $correo);
mysqli_stmt_execute($stmt);

$resultado = mysqli_stmt_get_result($stmt);

if (mysqli_num_rows($resultado) > 0) {

    $_SESSION['mensaje'] = "El correo ya está registrado.";
    $_SESSION['tipo'] = "error";

    header("Location: registrar.html");
    exit();
}

// Verificar si el usuario ya existe
$sql = "SELECT id_usuario FROM usuarios WHERE usuario = ?";

$stmt = mysqli_prepare($conexion, $sql);
mysqli_stmt_bind_param($stmt, "s", $usuario);
mysqli_stmt_execute($stmt);

$resultado = mysqli_stmt_get_result($stmt);

if (mysqli_num_rows($resultado) > 0) {

    $_SESSION['mensaje'] = "El nombre de usuario ya existe.";
    $_SESSION['tipo'] = "error";

    header("Location: registrar.html");
    exit();
}

// Encriptar contraseña
$contrasena = password_hash($password, PASSWORD_DEFAULT);

// Insertar usuario
$sql = "INSERT INTO usuarios
(nombre, correo, telefono, usuario, contrasena, rol)
VALUES (?, ?, ?, ?, ?, ?)";

$stmt = mysqli_prepare($conexion, $sql);

mysqli_stmt_bind_param(
    $stmt,
    "ssssss",
    $nombreCompleto,
    $correo,
    $telefono,
    $usuario,
    $contrasena,
    $rol
);

// Ejecutar
if (mysqli_stmt_execute($stmt)) {

    $_SESSION['mensaje'] = "🎉 ¡Registro exitoso! Ya puedes iniciar sesión.";
    $_SESSION['tipo'] = "success";

    header("Location: ../index.php");
    exit();

} else {

    $_SESSION['mensaje'] = "Ocurrió un error al registrar el usuario.";
    $_SESSION['tipo'] = "error";

    header("Location: registrar.html");
    exit();
}

mysqli_stmt_close($stmt);
mysqli_close($conexion);
?>