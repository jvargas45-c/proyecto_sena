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

// Buscar la cantidad actual
$sql = "SELECT cantidad
        FROM carrito
        WHERE id_usuario = ? AND id_producto = ?";

$stmt = mysqli_prepare($conexion, $sql);
mysqli_stmt_bind_param($stmt, "ii", $id_usuario, $id_producto);
mysqli_stmt_execute($stmt);

$resultado = mysqli_stmt_get_result($stmt);

if ($fila = mysqli_fetch_assoc($resultado)) {

    if ($fila["cantidad"] > 1) {

        $nuevaCantidad = $fila["cantidad"] - 1;

        $sql = "UPDATE carrito
                SET cantidad = ?
                WHERE id_usuario = ? AND id_producto = ?";

        $stmt = mysqli_prepare($conexion, $sql);
        mysqli_stmt_bind_param($stmt, "iii", $nuevaCantidad, $id_usuario, $id_producto);
        mysqli_stmt_execute($stmt);

    } else {

        // Si solo queda uno, eliminar el producto
        $sql = "DELETE FROM carrito
                WHERE id_usuario = ? AND id_producto = ?";

        $stmt = mysqli_prepare($conexion, $sql);
        mysqli_stmt_bind_param($stmt, "ii", $id_usuario, $id_producto);
        mysqli_stmt_execute($stmt);
    }
}

header("Location: carrito.php");
exit();
?>