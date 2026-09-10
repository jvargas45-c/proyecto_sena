<?php
session_start();
include("../conexion.php");

// Verificar que el usuario haya iniciado sesión
if (!isset($_SESSION["id_usuario"])) {
    header("Location: ../sesion/iniciar.html");
    exit();
}

$id_usuario = $_SESSION["id_usuario"];
$id_producto = $_GET["id"];

// Eliminar el producto del carrito
$sql = "DELETE FROM carrito
        WHERE id_usuario = ? AND id_producto = ?";

$stmt = mysqli_prepare($conexion, $sql);
mysqli_stmt_bind_param($stmt, "ii", $id_usuario, $id_producto);
mysqli_stmt_execute($stmt);

// Volver al carrito
header("Location: carrito.php");
exit();
?>