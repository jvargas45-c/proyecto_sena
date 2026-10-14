<?php
session_start();
include("../conexion.php");


if (!isset($_SESSION["id_usuario"])) {
    header("Location: ../sesion/iniciar.html");
    exit();
}

$id_usuario = $_SESSION["id_usuario"];


$sql = "SELECT
            c.id_producto,
            c.cantidad,
            pr.precio
        FROM carrito c
        INNER JOIN precios pr
            ON c.id_producto = pr.id_producto
        WHERE c.id_usuario = ?";

$stmt = mysqli_prepare($conexion, $sql);
mysqli_stmt_bind_param($stmt, "i", $id_usuario);
mysqli_stmt_execute($stmt);

$resultado = mysqli_stmt_get_result($stmt);


$total = 0;
$productos = [];

while ($fila = mysqli_fetch_assoc($resultado)) {
    $subtotal = $fila["precio"] * $fila["cantidad"];
    $total += $subtotal;
    $productos[] = $fila;
}


$sql = "INSERT INTO pedidos (id_usuario, total) VALUES (?, ?)";
$stmt = mysqli_prepare($conexion, $sql);
mysqli_stmt_bind_param($stmt, "id", $id_usuario, $total);
mysqli_stmt_execute($stmt);


$id_pedido = mysqli_insert_id($conexion);


foreach ($productos as $producto) {

    $sql = "INSERT INTO detalle_pedido
            (id_pedido, id_producto, cantidad, precio)
            VALUES (?, ?, ?, ?)";

    $stmt = mysqli_prepare($conexion, $sql);
    mysqli_stmt_bind_param(
        $stmt,
        "iiid",
        $id_pedido,
        $producto["id_producto"],
        $producto["cantidad"],
        $producto["precio"]
    );

    mysqli_stmt_execute($stmt);
}


$sql = "DELETE FROM carrito WHERE id_usuario = ?";
$stmt = mysqli_prepare($conexion, $sql);
mysqli_stmt_bind_param($stmt, "i", $id_usuario);
mysqli_stmt_execute($stmt);


$_SESSION["mensaje"] = "🎉 ¡Compra realizada con éxito!";
$_SESSION["tipo"] = "success";


header("Location: ../index.php");
exit();
?>