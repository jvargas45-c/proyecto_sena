<?php
session_start();
include("../conexion.php");


if (!isset($_SESSION["id_usuario"])) {
    header("Location: ../sesion/iniciar.html");
    exit();
}

$id_usuario = $_SESSION["id_usuario"];
$id_producto = $_GET["id"];


$sql = "DELETE FROM carrito
        WHERE id_usuario = ? AND id_producto = ?";

$stmt = mysqli_prepare($conexion, $sql);
mysqli_stmt_bind_param($stmt, "ii", $id_usuario, $id_producto);
mysqli_stmt_execute($stmt);


header("Location: carrito.php");
exit();
?>