<?php
session_start();
include("../conexion.php");

if (!isset($_SESSION["id_usuario"])) {
    header("Location: ../sesion/iniciar.html");
    exit();
}

$id_usuario = $_SESSION["id_usuario"];
$id_pedido = $_GET["id"];

// Verificar que el pedido pertenezca al usuario
$sql = "SELECT id_pedido
        FROM pedidos
        WHERE id_pedido = ? AND id_usuario = ?";

$stmt = mysqli_prepare($conexion, $sql);
mysqli_stmt_bind_param($stmt, "ii", $id_pedido, $id_usuario);
mysqli_stmt_execute($stmt);

$resultado = mysqli_stmt_get_result($stmt);

if (mysqli_num_rows($resultado) > 0) {

    // Eliminar primero el detalle del pedido
    $sql = "DELETE FROM detalle_pedido WHERE id_pedido = ?";
    $stmt = mysqli_prepare($conexion, $sql);
    mysqli_stmt_bind_param($stmt, "i", $id_pedido);
    mysqli_stmt_execute($stmt);

    // Luego eliminar el pedido
    $sql = "DELETE FROM pedidos WHERE id_pedido = ? AND id_usuario = ?";
    $stmt = mysqli_prepare($conexion, $sql);
    mysqli_stmt_bind_param($stmt, "ii", $id_pedido, $id_usuario);
    mysqli_stmt_execute($stmt);
}

header("Location: historial.php");
exit();
?>