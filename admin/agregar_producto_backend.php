<?php
session_start();
include("../conexion.php");

if ($_SESSION["rol"] !== "admin") {
    exit("Acceso denegado");
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = $_POST["nombre"];
    $descripcion = $_POST["descripcion"];
    $tipo = $_POST["tipo"];
    $stock = $_POST["stock"];
    $imagen = $_POST["imagen"];
    $id_categoria = $_POST["id_categoria"];
    $id_tamano = 1; 
    $precio = $_POST["precio"];

    
    $sql = "INSERT INTO productos (nombre_producto, descripcion, tipo_ponque, stock, imagen, id_categoria, id_tamano) VALUES (?, ?, ?, ?, ?, ?, ?)";
    $stmt = mysqli_prepare($conexion, $sql);
    mysqli_stmt_bind_param($stmt, "sssisii", $nombre, $descripcion, $tipo, $stock, $imagen, $id_categoria, $id_tamano);
    mysqli_stmt_execute($stmt);
    
    
    $id_producto_nuevo = mysqli_insert_id($conexion);

    
    $sql_precio = "INSERT INTO precios (id_producto, precio) VALUES (?, ?)";
    $stmt_p = mysqli_prepare($conexion, $sql_precio);
    mysqli_stmt_bind_param($stmt_p, "id", $id_producto_nuevo, $precio);
    mysqli_stmt_execute($stmt_p);

    header("Location: panel.php");
    exit();
}
?>